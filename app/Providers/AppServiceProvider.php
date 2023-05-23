<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Response::macro('structure', function ($data = [], $status = 200, $message = 'success', $isPaginate = false) {

            if($isPaginate) {
                return Response::json([
                    'data' => $data,
                    'message' => __("message.{$message}" ),
                    'status' => $status,
                    'meta' => [
                        'page_size' => $data->perPage(),
                        'current_page' => $data->currentPage(),
                        'last_page' => $data->lastPage(),
                        'total' => $data->total(),
                    ],
                ], $status);
            }

            return Response::json([
                'data' => $data,
                'message' => __("message.{$message}" ),
                'status' => $status
            ], $status);
        });
    }
}
