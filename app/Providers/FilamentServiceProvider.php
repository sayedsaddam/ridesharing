<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\UserResource;


class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function(){
            if(auth()->user()){
                if(auth()->user()->is_admin === 1 && auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator'])){
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                        ->label('Manage Users')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-users'),
                        UserMenuItem::make()
                        ->label('Manage Roles')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-cog'),
                        UserMenuItem::make()
                        ->label('Manage Permissions')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-o-key')
                    ]);
                }
            }
        });
    }
}
