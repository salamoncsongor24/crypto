<?php

namespace App\Domain\Portfolio\Filament\Resources;

use App\Domain\Portfolio\Filament\Resources\PortfolioResource\Pages;
use App\Domain\Portfolio\Models\Portfolio;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PortfolioResource extends Resource implements HasShieldPermissions
{
    /**
     * @var string $model The model the resource corresponds to.
     */
    protected static ?string $model = Portfolio::class;

    /**
     * @var string $navigationIcon The navigation icon for the resource.
     */
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    /**
     * The pages that should be registered for the resource.
     *
     * @return array<string, string>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'view' => Pages\ViewPortfolio::route('/{record}'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the eloquent query builder for the resource.
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::user()->id);
    }

    /**
     * Get the navigation group for the resource.
     *
     * @return string
     */
    public static function getNavigationGroup(): string
    {
        return __('Tracking');
    }

    /**
     * Get the permissions for the resource.
     *
     * @return array
     */
    public static function getPermissionPrefixes(): array
    {
        return config('filament-shield.permission_prefixes.resource');
    }
}
