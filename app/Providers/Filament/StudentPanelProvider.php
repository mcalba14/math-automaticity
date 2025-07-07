<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Pages\Auth\EditProfile;
use App\Filament\Auth\CustomRegistration;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class StudentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('student')
            ->path('/')
            ->login()
            ->registration(CustomRegistration::class)
            ->profile()
            ->topNavigation()
            ->darkMode(false)
            ->brandLogo(asset('images/math_fluency.png'))
            ->brandLogoHeight('6.2rem')
            ->favicon(asset('favicon.png'))
            ->colors([
                'primary' => [
                    50 => '#f1f4f8',
                    100 => '#d4dde8',
                    200 => '#aabfd1',
                    300 => '#7f9fb9',
                    400 => '#5571a0',
                    500 => '#112d4e', // Main navy blue
                    600 => '#0d2340',
                    700 => '#091b33',
                    800 => '#061225',
                    900 => '#020a17',
                ],
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()->label('Edit profile'),
                // ...
            ])
            ->discoverResources(in: app_path('Filament/Student/Resources'), for: 'App\\Filament\\Student\\Resources')
            ->discoverPages(in: app_path('Filament/Student/Pages'), for: 'App\\Filament\\Student\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Student/Widgets'), for: 'App\\Filament\\Student\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                'auth',
                'role:Student', // Student Panel
                // \Spatie\Permission\Middlewares\RoleMiddleware::class . ':student',
            ]);
            // ->plugin(FilamentSpatieRolesPermissionsPlugin::make());
    }
}
