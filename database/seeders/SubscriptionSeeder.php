<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Amirhome\LaravelSubscriptionManagment\LaravelSubscriptionManagment;


class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        
        $modelPath = config('laravel_subscription_managment.model_path');

        // Dynamically reference the models
        $groupClass = $modelPath . '\SubscriptionGroup';
        $featureClass = $modelPath . '\SubscriptionFeature';
        $productClass = $modelPath . '\SubscriptionProduct';

        // Check if classes exist before using them
        if (class_exists($groupClass) && class_exists($featureClass) && class_exists($productClass)) {
            $group1 = new $groupClass(['id' => 1, 'name' => 'Personal', 'type' => 'plugin']);
            $group1->save();

            $group2 = new $groupClass(['id' => 2, 'name' => 'Business', 'type' => 'plugin']);
            $group2->save();

            $group3 = new $groupClass(['id' => 3, 'name' => 'General', 'type' => 'feature']);
            $group3->save();

            $feature = new $featureClass([
                'name' => 'GPT-4o',
                'description' => 'Limited access to all reasoning models and GPT-4o',
                'group_id' => 3,
                'code' => 'GPT-4o',
                'active' => true,
                'limited' => true,
            ]);
            $feature->save();

            // Free Plugin
            $plugin = new $productClass([
                'name' => 'Free Plugin',
                'description' => 'Explore how AI can help you with everyday tasks',
                'group_id' => 1,
                'code' => 'free',
                'price' => 0,
                'price_yearly' => 0,
                'active' => true,
                'type' => 1,
            ]);
            $plugin->save();
            $plugin->features()->attach($feature, ['value' => '2000']);


            # Plus Plugin
            $plugin = new $productClass([
                'name' => 'Plus Plugin',
                'description' => 'Level up productivity and creativity with expanded access',
                'group_id' => 1,
                'code' => 'plus',
                'price' => 20, # monthly price
                # 'currency' => 'USD',
                'price_yearly' => 200,
                'active' => true,
            ]);
            $plugin->save();

            $plugin->features()->create([
                'name' => 'o3-mini',
                'description' => 'Access to multiple reasoning models (o3-mini, o3-mini-high, and o1)',
                'group_id' => 3,
                'code' => 'o3-mini',
                'active' => true,
                'limited' => false,
            ]);

            # Pro Plugin
            $plugin = new $productClass([
                'name' => 'Pro Plugin',
                'description' => 'Get the best of OpenAI with the highest level of access',
                'group_id' => 1,
                'code' => 'pro',
                'price' => 200, # monthly price
                'price_yearly' => 2000,
                'active' => true,
            ]);
            $plugin->save();
            # Unlimited GPT-4o
            $plugin->features()->attach($feature, ['value' => '999999999']);
            // $plugin->features()->create([
            //     'name' => 'GPT-4o',
            //     'description' => 'Unlimited access to all reasoning models and GPT-4o',
            //     'group_id' => 3,
            //     'code' => 'GPT-4o',
            //     'active' => true,
            //     'limited' => false,
            // ]);

            # User1 assigns free plugin
            $user = \App\Models\User::find(1);
            $plugin = $productClass::find(1);
            LaravelSubscriptionManagment::make($user)->subscribeTo($plugin);

            #LaravelSubscriptionManagment::make($user)->renew();
            $code = $plugin->getCode();
            echo "$user->email subscribed to $code\n";
            echo "Is GPT-4o available? " . $user->canConsume('GPT-4o') . "\n";

            $user->consume('GPT-4o', 10);
            $user->consume('GPT-4o', 12);
            echo 'Consumed ' . $user->getCurrentConsumption('GPT-4o') . ' balance ' . $user->getBalance('GPT-4o') . "\n";
            # $user->retrieve('GPT-4o');
            $subscription = $user->getSubscription();
            echo $subscription . "\n";
            echo "plugin getKey " . $plugin->getKey() . "\n";
            echo "subscription getKey " . $subscription->getKey() . "\n";
            echo $user->canConsumeAny(['GPT-4o', 'o3-mini']);
            echo "\n";


            # User2 assigns plus plugin
            $user = \App\Models\User::find(2);
            $plugin = $productClass::find(2);
            LaravelSubscriptionManagment::make($user)->subscribeTo($plugin);
            # User3 assigns pro plugin
            $user = \App\Models\User::find(3);
            $plugin = $productClass::find(3);
            LaravelSubscriptionManagment::make($user)->subscribeTo($plugin);

            # Create a Contract on Plugin
            # Set the contract for the subscription
            $user = User::find(4);
            $subscriptionHandler = LaravelSubscriptionManagment::make($user)->subscribeTo($plugin, '2023-02-01');
            # $subscriptionHandler = LaravelSubscriptionManagment::make($user)->subscribeTo($plugin, now());
            if ($subscriptionHandler->getSubscription()) {
                $subscriptionHandler->addPlugin($plugin, '2023-02-02', $user);
                # $subscriptionHandler->addPlugin($plugin, now());
                # $subscriptionHandler->cancelPlugin($plugin);
                # $subscriptionHandler->resumePlugin($plugin);
            } else {
                echo "User does not have an active subscription.";
            }

            // Create a subscription handler for the user
            //$subscriptionHandler = LaravelSubscriptionManagment::make($user);

            // Retrieve the existing subscription
            // $existingSubscription = $subscriptionHandler->getSubscription();
            $existingSubscription = $user->getSubscription();

            if ($existingSubscription && !$existingSubscription->isValid()) {
                // Renew the subscription
                $renewedSubscription = $subscriptionHandler->renew(25, false);

                // Update the end date of the renewed subscription
                $renewedSubscription->addPlugin($plugin, now());

                echo "Subscription renewed successfully!";
            } else {
                echo "No expired subscription found for renewal.";
            }
        } else {
            throw new \Exception("One or more model classes do not exist.");
        }
    }
}
