<?php

namespace App\Domain\User\Filament\Admin\Resources;

use App\Domain\User\Filament\Admin\Resources\UserResource\Pages;
use App\Domain\User\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    /**
     * @var string $model The model the resource corresponds to.
     */
    protected static ?string $model = User::class;

    /**
     * @var string $navigationIcon The navigation icon for the resource.
     */
    protected static ?string $navigationIcon = 'heroicon-o-users';

    /**
     * The pages that should be registered for the resource.
     *
     * @return array<string, string>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
        return __('User Management');
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
