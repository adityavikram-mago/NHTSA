<?php

namespace App\Providers;

use App\Repositories\Cache\CacheVehicleDecorator;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp;
use Monolog;

class AppServiceProvider extends ServiceProvider {

    public function boot() {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->registerSingletons();
        $this->registerBindings();
        $this->registerCacheBindings();
    }

    private function registerSingletons() {
        $this->app->singleton(
            GuzzleHttp\Client::class,
            function($app) {
                $stack = GuzzleHttp\HandlerStack::create();
                $stack->push(
                    GuzzleHttp\Middleware::log(
                        with(new \Monolog\Logger('api'))->pushHandler(
                            new \Monolog\Handler\RotatingFileHandler(storage_path('logs/api.log'))
                        ),
                        new GuzzleHttp\MessageFormatter(
                            '{method} {uri} HTTP/{version} {req_body} RESPONSE: {code}'
                        )
                    )
                );

                return new GuzzleHttp\Client([
                    'base_uri' => env('RESOURCE_BASE_URI', null),
                    'query'    => ['format' => 'json'],
                    'handler'  => $stack,
                ]);
            }
        );
    }

    private function registerCacheBindings() {
        $this->app->bind(
            'App\Repositories\VehicleRepository',
            function() {
                $repository = new \App\Repositories\Eloquent\EloquentVehicleRepository(new \App\Entities\Vehicle());

                if (!env('CACHE_ENABLE', false)) {
                    return $repository;
                }
                
                return new CacheVehicleDecorator($repository);
            }
        );
    }

    private function registerBindings() {
        $this->app->bind(
            'App\Contracts\BaseResponseInterface',
            'App\Http\Responses\BaseResponse'
        );
    }
}
