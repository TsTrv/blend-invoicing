<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface;

class ConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (\Schema::hasTable('currencies')) {
            $currencyRepository = App::make(CurrencyRepositoryInterface::class);
            config(['blend.currency' => $currencyRepository->getByCode(config('blend.defaultCurrency'))]);
        }
    }
}
