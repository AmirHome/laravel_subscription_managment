<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Amirhome\LaravelSubscriptionManagment\LaravelSubscriptionManagment;


class SubscriptionSeeder extends Seeder
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
            $group1 = new $groupClass(['id' => 1, 'name' => 'Personal', 'type' => 'Product']);
            $group1->save();

            $group2 = new $groupClass(['id' => 2, 'name' => 'Business', 'type' => 'Product']);
            $group2->save();

            $group3 = new $groupClass(['id' => 3, 'name' => 'General', 'type' => 'Feature']);
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

            // Free Product
            $product = new $productClass([
                'name' => 'Free Product',
                'description' => 'Explore how AI can help you with everyday tasks',
                'group_id' => 1,
                'code' => 'free',
                'price' => 0,
                'price_yearly' => 0,
                'active' => true,
                'type' => 1,
            ]);
            $product->save();
            $product->features()->attach($feature, ['value' => '2000']);


            # Plus Product
            $product = new $productClass([
                'name' => 'Plus Product',
                'description' => 'Level up productivity and creativity with expanded access',
                'group_id' => 1,
                'code' => 'plus',
                'price' => 20, # monthly price
                # 'currency' => 'USD',
                'price_yearly' => 200,
                'active' => true,
            ]);
            $product->save();

            $product->features()->create([
                'name' => 'o3-mini',
                'description' => 'Access to multiple reasoning models (o3-mini, o3-mini-high, and o1)',
                'group_id' => 3,
                'code' => 'o3-mini',
                'active' => true,
                'limited' => false,
            ]);

            # Pro Product
            $product = new $productClass([
                'name' => 'Pro Product',
                'description' => 'Get the best of OpenAI with the highest level of access',
                'group_id' => 1,
                'code' => 'pro',
                'price' => 200, # monthly price
                'price_yearly' => 2000,
                'active' => true,
            ]);
            $product->save();
            # Unlimited GPT-4o
            $product->features()->attach($feature, ['value' => '999999999']);
            // $product->features()->create([
            //     'name' => 'GPT-4o',
            //     'description' => 'Unlimited access to all reasoning models and GPT-4o',
            //     'group_id' => 3,
            //     'code' => 'GPT-4o',
            //     'active' => true,
            //     'limited' => false,
            // ]);

            # User1 assigns free Product
            $user = \App\Models\User::find(1);
            $product = $productClass::find(1);
            LaravelSubscriptionManagment::make($user)->subscribeTo($product);

            #LaravelSubscriptionManagment::make($user)->renew();
            $code = $product->getCode();
            echo "$user->email subscribed to $code\n";
            echo "Is GPT-4o available? " . $user->canConsume('GPT-4o') . "\n";

            $user->consume('GPT-4o', 10);
            $user->consume('GPT-4o', 12);
            echo 'Consumed ' . $user->getCurrentConsumption('GPT-4o') . ' balance ' . $user->getBalance('GPT-4o') . "\n";
            # $user->retrieve('GPT-4o');
            $subscription = $user->getSubscription();
            echo $subscription . "\n";
            echo "Product getKey " . $product->getKey() . "\n";
            echo "subscription getKey " . $subscription->getKey() . "\n";
            echo $user->canConsumeAny(['GPT-4o', 'o3-mini']);
            echo "\n";


            # User2 assigns plus Product
            $user = \App\Models\User::find(2);
            $product = $productClass::find(2);
            LaravelSubscriptionManagment::make($user)->subscribeTo($product);
            # User3 assigns pro Product
            $user = \App\Models\User::find(3);
            $product = $productClass::find(3);
            LaravelSubscriptionManagment::make($user)->subscribeTo($product);

            # Create a Contract on Product
            # Set the contract for the subscription
            $user = User::find(4);
            $subscriptionHandler = LaravelSubscriptionManagment::make($user)->subscribeTo($product, '2023-02-01');
            # $subscriptionHandler = LaravelSubscriptionManagment::make($user)->subscribeTo($product, now());
            if ($subscriptionHandler->getSubscription()) {
                $subscriptionHandler->addPlugin($product, '2023-02-02', $user);
                # $subscriptionHandler->addPlugin($product, now());
                # $subscriptionHandler->cancelPlugin($product);
                # $subscriptionHandler->resumePlugin($product);
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
                $renewedSubscription->addPlugin($product, now());

                echo "Subscription renewed successfully!";
            } else {
                echo "No expired subscription found for renewal.";
            }
        } else {
            throw new \Exception("One or more model classes do not exist.");
        }
    }
}
