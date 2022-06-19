<?php

namespace App\Providers;

use App\Models\AbsentSpot;
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
            $absentPendingCount = AbsentSpot::where('status', 'Pending')->count();
            $event->menu->add(
                [
                    'text'    => 'Staff',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
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
                ],
            );
            if ($absentPendingCount) {
                $event->menu->add(
                    [
                        'text'        => 'Manage Absent',
                        'icon'        => 'fas fa-fw fa-user-clock',
                        'label'       => $absentPendingCount,
                        'label_color' => 'danger',

                        'submenu'     => [
                            [
                                'text' => 'Absent',
                                'icon' => 'fas fa-fw fa-business-time',
                                'url'  => 'dashboard/absent',
                            ],
                            [
                                'text' => 'Absent Spot',
                                'icon' => 'fas fa-fw fa-map-marker-alt',
                                'url'  => 'dashboard/absentspot',
                                'label'       => $absentPendingCount,
                                'label_color' => 'danger',
                            ],
                        ]
                    ]
                );
            } else {
                $event->menu->add(
                    [
                        'text'        => 'Manage Absent',
                        'icon'        => 'fas fa-fw fa-user-clock',

                        'submenu'     => [
                            [
                                'text' => 'Absent',
                                'icon' => 'fas fa-fw fa-business-time',
                                'url'  => 'dashboard/absent',
                            ],
                            [
                                'text' => 'Absent Spot',
                                'icon' => 'fas fa-fw fa-map-marker-alt',
                                'url'  => 'dashboard/absentspot',
                            ],
                        ]
                    ]
                );
            }
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
