<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;

// 🔥 IMPORTAR EL PLUGIN DE AUTENTICACIÓN
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;

// 🔥 IMPORTAR EL MIDDLEWARE DE USUARIO ACTIVO
use App\Http\Middleware\CheckUserActive;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            // ============================================
            // 🎨 COLORES PERSONALIZADOS
            // ============================================
            ->colors([
                'primary' => Color::Cyan,
                'danger' => Color::Red,
                'success' => Color::Green,
                'warning' => Color::Yellow,
                'info' => Color::Sky,
                'gray' => Color::Gray,
                'purple' => Color::Purple,
                'orange' => Color::Orange,
                'pink' => Color::Pink,
                'indigo' => Color::Indigo,
                'teal' => Color::Teal,
                'cyan' => Color::Cyan,
                'rose' => Color::Rose,
                'emerald' => Color::Emerald,
                'violet' => Color::Violet,
                'fuchsia' => Color::Fuchsia,
                'lime' => Color::Lime,
                'zinc' => Color::Zinc,
                'stone' => Color::Stone,
                'slate' => Color::Slate,
            ])
            
            // ============================================
            // 🏷️ PERSONALIZACIÓN DE MARCA
            // ============================================
            ->brandName('Mi Sistema Web')
            ->font('Poppins')
            
            // ============================================
            // 📁 RECURSOS, PÁGINAS Y WIDGETS
            // ============================================
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            
            // ============================================
            // 🛡️ MIDDLEWARE
            // ============================================
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
                // 🔥 MIDDLEWARE PARA VERIFICAR USUARIOS ACTIVOS
                CheckUserActive::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            
            // ============================================
            // 🔌 PLUGINS
            // ============================================
            ->plugins([
                FilamentShieldPlugin::make(),
                
                // 🔥 PLUGIN DE AUTENTICACIÓN PERSONALIZADA
                AuthDesignerPlugin::make()
                    ->login(fn (AuthPageConfig $config) => $config
                        ->media(asset('images/moon.png'), alt: 'Bienvenido a Mi Sistema Web')
                        ->mediaPosition(MediaPosition::Cover)
                        // 🔥 ELIMINADO: ->blur(5) - IMAGEN NÍTIDA
                    )
                    ->themeToggle(bottom: '2rem', right: '2rem')
            ]);
    }
}