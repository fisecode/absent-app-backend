<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $usersCount = User::count();
            $event->menu->add([
                'text'        => 'Staff',
                'icon'        => 'fas fa-fw fa-users',
                'submenu'     => [
                    [
                        'text' => 'Admin',
                        'icon' => 'fas fa-fw fa-user-secret',
                        'url'  => 'dashboard/user',
                    ],
                    [
                        'text' => 'Employee',
                        'icon' => 'fas fa-fw fa-user-tie',
                        'url'  => 'dashboard/employee',
                    ],
                ]
            ]);
        });
        Paginator::useBootstrap();
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
