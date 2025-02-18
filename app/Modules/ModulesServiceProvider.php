<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modules = ['Transactions', 'AccountHeads', 'Reports', 'Vouchers'];

        foreach ($modules as $module) {
            if (file_exists(__DIR__ . "/$module/routes.php")) {
                include __DIR__ . "/$module/routes.php";
            }

            if (is_dir(__DIR__ . "/$module/Views")) {
                $this->loadViewsFrom(__DIR__ . "/$module/Views", $module);
            }
        }
    }

    public function register() {}
}
