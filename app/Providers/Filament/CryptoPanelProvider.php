<?php

namespace App\Providers\Filament;

use App\Domain\Coin\Filament\Resources\CoinResource\Widgets\CoinPriceWidget;
use App\Domain\Common\Filament\Pages\Auth\Profile;
use App\Domain\Common\Filament\Pages\Auth\Register;
use App\Domain\Portfolio\Filament\Resources\PortfolioResource;
use App\Domain\Portfolio\Filament\Resources\PortfolioResource\Widgets\PortfolioTotalValueWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CryptoPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('crypto')
            ->path('crypto')
            ->brandLogo(asset('logo.png'))
            ->brandLogoHeight('5rem')
            ->favicon(asset('favicon.ico'))
            ->login()
            ->registration(Register::class)
            ->passwordReset()
            ->emailVerification()
            ->profile(Profile::class)
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Purple,
            ])
            ->resources([
                PortfolioResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                CoinPriceWidget::class,
                PortfolioTotalValueWidget::class,
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
                Authenticate::class,
            ]);
    }
}
