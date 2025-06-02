<?php

namespace App\Domain\User\Filament\Admin\Resources\UserResource\Pages;

use App\Domain\User\Filament\Admin\Resources\UserResource;
use App\Domain\User\Models\User;
use Filament\Actions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    /**
     * @var string $resource The resource that this page is associated with.
     */
    protected static string $resource = UserResource::class;

    /**
     * Returns an Infolist instance for displaying user information.
     *
     * @param \Filament\Infolists\Infolist $infolist
     *
     * @return Infolist
     */
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('User Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),
                        TextEntry::make('email')
                            ->label(__('Email')),
                        TextEntry::make('roles')
                            ->label(__('Roles'))
                            ->placeholder(__('No roles assigned'))
                            ->state(fn (User $record) => $record->roles->pluck('name')->join(', ')),
                        TextEntry::make('email_verified_at')
                            ->label(__('Email Verified At'))
                            ->placeholder(__('Not Verified'))
                            ->dateTime(),
                        IconEntry::make('get_notifications')
                            ->label(__('Subscribed to Notifications'))
                            ->boolean(),
                    ])
                    ->columns(['md' => 2])
                    ->columnSpan(['md' => 2]),
                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime(),
                        TextEntry::make('deleted_at')
                            ->label(__('Deleted At'))
                            ->dateTime()
                            ->color('danger')
                            ->visible(fn (User $record) => $record->trashed()),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    /**
     * Get the header actions for the view user page.
     *
     * @return array<Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
