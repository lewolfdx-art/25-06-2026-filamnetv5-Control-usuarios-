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
                // 🔥 COLOR PRIMARIO (CYAN)
                'primary' => Color::Cyan,
                
                // 🔥 COLORES SECUNDARIOS
                'danger' => Color::Red,
                'success' => Color::Green,
                'warning' => Color::Yellow,
                'info' => Color::Sky,
                'gray' => Color::Gray,
                
                // 🔥 COLORES EXTRA (PARA ROLES)
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
            
            // 🔥 LOGO (descomenta cuando tengas la imagen)
            // ->brandLogo(asset('images/logo.svg'))
            // ->brandLogoHeight('2rem')
            
            // 🔥 LOGO PARA MODO OSCURO
            // ->darkModeBrandLogo(asset('images/logo-dark.svg'))
            
            // 🔥 FAVICON
            // ->favicon(asset('images/favicon.ico'))
            
            // ============================================
            // 🔤 FUENTE PERSONALIZADA
            // ============================================
            ->font('Poppins')
            
            // ============================================
            // 🌓 MODO OSCURO
            // ============================================
            // 🔥 Deshabilitar modo oscuro
            // ->darkMode(false)
            
            // 🔥 O forzar modo claro por defecto
            // ->defaultThemeMode(\Filament\Enums\ThemeMode::Light)
            
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
            // 🎨 TEMA PERSONALIZADO (cuando lo crees)
            // ============================================
            // ->viteTheme('resources/css/filament/admin/theme.css')
            
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            
            // ============================================
            // 🔌 PLUGINS
            // ============================================
            ->plugins([
                FilamentShieldPlugin::make()
            ]);
    }
}