<?php

namespace App\Domain\Coin\Filament\Resources;

use App\Domain\Coin\Filament\Resources\CoinResource\Pages;
use App\Domain\Coin\Models\Coin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoinResource extends Resource
{
    /**
     * @var string $model The model the resource corresponds to.
     */
    protected static ?string $model = Coin::class;

    /**
     * @var string $navigationIcon The navigation icon for the resource.
     */
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    /**
     * The pages that should be registered for the resource.
     *
     * @return array<string, string>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoins::route('/'),
            'view' => Pages\ViewCoin::route('/{record}'),
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
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Get the navigation group for the resource.
     *
     * @return string
     */
    public static function getNavigationGroup(): string
    {
        return __('Content');
    }

    /**
     * Get the navigation badge for the resource.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
