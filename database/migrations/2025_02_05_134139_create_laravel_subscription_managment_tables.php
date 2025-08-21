<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        $prefix = subscriptionTablePrefix();
        Schema::create("{$prefix}groups", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum("type", ['plan', 'plugin', 'feature']);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create("{$prefix}products", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->unique();
            $table->text("description")->nullable();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionGroup', 'group_id')->nullable();
            $table->enum("type", ['recurring', 'non-recurring'])->default('recurring');
            $table->boolean('active')->default(true);
            $table->double("price")->default(0);
            $table->double("price_yearly")->default(0);
            $table->unsignedTinyInteger('concurrency')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$prefix}features", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->unique();
            $table->text("description")->nullable();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionGroup', 'group_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('limited')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$prefix}product_feature", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionProduct', 'plan_id');
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionFeature', 'feature_id');
            $table->boolean('active')->default(true);
            $table->double('value')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$prefix}subscriptions", function (Blueprint $table) {
            $table->id();
            $table->morphs("subscriber");
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionProduct', 'plan_id');
            $table->boolean("unlimited")->default(false);
            $table->timestamp("start_at")->nullable();
            $table->timestamp("end_at")->nullable();
            $table->timestamp("suppressed_at")->nullable();
            $table->timestamp("canceled_at")->nullable();
            $table->unsignedInteger("billing_period")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create("{$prefix}contracts", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\Subscription');
            $table->string("code");
            $table->morphs("product");
            $table->unsignedInteger("number")->default(1);
            $table->timestamp("start_at");
            $table->timestamp("end_at")->nullable();
            $table->boolean("auto_renew")->default(true);
            $table->enum("type", ['recurring', 'non-recurring']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$prefix}contract_transactions", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionContract');
            $table->string("type");
            $table->timestamp("start_at");
            $table->timestamp("end_at")->nullable();
            $table->morphs("causative");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("{$prefix}quotas", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\Subscription');
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionFeature', 'feature_id');
            $table->string("code");
            $table->timestamp("end_at")->nullable();
            $table->boolean('limited')->default(false);
            $table->double('quota')->unsigned()->default(0);
            $table->double('consumed')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create("{$prefix}feature_consumptions", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\Subscription');
            $table->foreignIdFor(config('laravel_subscription_managment.model_path') . '\SubscriptionFeature', 'feature_id');
            $table->string("code");
            $table->double('consumed')->unsigned()->default(0);
            $table->enum('type', ['increase', 'decrease'])->default('decrease');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        $prefix = subscriptionTablePrefix();
        Schema::dropIfExists("{$prefix}feature_consumptions");
        Schema::dropIfExists("{$prefix}quotas");
        Schema::dropIfExists("{$prefix}contract_transactions");
        Schema::dropIfExists("{$prefix}contracts");
        Schema::dropIfExists("{$prefix}subscriptions");
        Schema::dropIfExists("{$prefix}product_feature");
        Schema::dropIfExists("{$prefix}features");
        Schema::dropIfExists("{$prefix}products");
        Schema::dropIfExists("{$prefix}groups");
    }
};
