<?php 

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modules = config('module.modules');

        while (list(, $module) = each($modules)) {
            if (file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }

            if (file_exists(__DIR__.'/'.$module.'/breadcrumbs.php')) {
                include __DIR__.'/'.$module.'/breadcrumbs.php';
            }

            if (is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }

            /**
             * @todo  Confirm it is good to go.
             */
            if (is_dir(__DIR__.'/'.$module.'/Repositories')) {
                $bindings = [];
                $repositories = scandir(__DIR__.'/'.$module.'/Repositories');

                foreach ($repositories as $key => $repository) {
                    if (strpos($repository, '.php')) {
                        $path = "App\\Modules\\".$module."\\Repositories\\";
                        $repositoryName = str_replace('.php', '', $repository);
                        $repo = $path.$repositoryName;
                        $interface = $path.'Interfaces\\'.$repositoryName.'Interface';

                        $bindings[$repo] = [$interface];
                    }
                }
            }

            foreach ($bindings as $concrete => $interfaces) {
                foreach ($interfaces as $interface) {
                    $this->app->bind($interface, $concrete);
                }
            }
        }
    }

    public function register()
    {
    }
}
