<?php

namespace Callmeaf\Voucher;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CallmeafVoucherServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-voucher';
    private const CONFIGS_GROUP = 'callmeaf-voucher-config';
    private const VOUCHER_PRODUCT_PIVOT_CONFIGS_KEY = 'callmeaf-voucher-product-pivot';
    private const VOUCHER_PRODUCT_PIVOT_CONFIGS_GROUP = 'callmeaf-voucher-product-pivot-config';
    private const ROUTES_DIR = __DIR__ . '/../routes';
    private const DATABASE_DIR = __DIR__ . '/../database';
    private const DATABASE_GROUPS = 'callmeaf-voucher-migrations';
    private const RESOURCES_DIR = __DIR__ . '/../resources';
    private const VIEWS_NAMESPACE = 'callmeaf-voucher';
    private const VIEWS_GROUP = 'callmeaf-voucher-views';
    private const LANG_DIR = __DIR__ . '/../lang';
    private const LANG_NAMESPACE = 'callmeaf-voucher';
    private const LANG_GROUP = 'callmeaf-voucher-lang';
    public function boot()
    {
        require_once( __DIR__ . '/helpers.php');
        $this->registerConfig();
        $this->registerRoute();
        $this->registerMigration();
        $this->registerEvents();
        $this->registerViews();
        $this->registerLang();
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-voucher.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-voucher.php' => config_path('callmeaf-voucher.php'),
        ],self::CONFIGS_GROUP);

        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-voucher-product-pivot.php',self::VOUCHER_PRODUCT_PIVOT_CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-voucher-product-pivot.php' => config_path('callmeaf-voucher-product-pivot.php'),
        ],self::VOUCHER_PRODUCT_PIVOT_CONFIGS_GROUP);
    }

    private function registerRoute(): void
    {
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/api.php');
    }

    private function registerMigration(): void
    {
        $this->loadMigrationsFrom(self::DATABASE_DIR . '/migrations');
        $this->publishes([
            self::DATABASE_DIR . '/migrations' => database_path('migrations'),
        ],self::DATABASE_GROUPS);
    }

    private function registerEvents(): void
    {
        foreach (config('callmeaf-voucher.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(self::RESOURCES_DIR . '/views',self::VIEWS_NAMESPACE);
        $this->publishes([
            self::RESOURCES_DIR . '/views' => resource_path('views/vendor/callmeaf-voucher'),
        ],self::VIEWS_GROUP);

    }

    private function registerLang(): void
    {
        $langPathFromVendor = lang_path('vendor/callmeaf/voucher');
        if(is_dir($langPathFromVendor)) {
            $this->loadTranslationsFrom($langPathFromVendor,self::LANG_NAMESPACE);
        } else {
            $this->loadTranslationsFrom(self::LANG_DIR,self::LANG_NAMESPACE);
        }
        $this->publishes([
            self::LANG_DIR => $langPathFromVendor,
        ],self::LANG_GROUP);
    }

}
