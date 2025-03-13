<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use App\Models\SimRequest\SimRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //{
              //  $this->app->bind(SimRequest::class, function ($app) {
            //     return new SimRequest();
            //  });
           // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Laravel Macros are great way of extending Laravel's core classes and add extra functionality
         * required for our application.
         * It is a way to add somme missing functionality to Laravel's internal component with a piece of code
         * that doesn't exist in the Laravel class.
         *
         * Blueprint is macroable, so we can just define a macro on it in this service provider to get base fields
         */
        Blueprint::macro('baseFields', function () {
            $this->uuid('uuid');
            $this->foreignId('status_id')->nullable()
                ->comment('status reference')
                ->constrained('statuses')->onDelete('set null');
            $this->boolean('is_default')->default(false)->comment('determine whether is the default one.');

            $this->timestamps();

            // foreign creator & updator user
            $this->foreignId('created_by')->nullable()
                ->comment('user creator reference')
                ->constrained('users')->onDelete('set null');

            $this->foreignId('updated_by')->nullable()
                ->comment('user updator reference')
                ->constrained('users')->onDelete('set null');

        });
        Blueprint::macro('dropBaseForeigns', function () {

            /** Make sure to put this condition to check if driver is SQLite */
            if (DB::getDriverName() !== 'sqlite') {
                $this->dropForeign(['status_id']);
                $this->dropForeign(['created_by']);
                $this->dropForeign(['updated_by']);
            }
        });
    }
}
