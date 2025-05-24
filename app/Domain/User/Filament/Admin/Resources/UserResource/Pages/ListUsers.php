<?php

namespace App\Domain\User\Filament\Admin\Resources\UserResource\Pages;

use App\Domain\User\Filament\Admin\Resources\UserResource;
use App\Domain\User\Models\User;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ListUsers extends ListRecords
{
    /**
     * @var string $resource The name of the resource that this page is associated with.
     */
    protected static string $resource = UserResource::class;

    /**
     * The table configuration for the resource listing page.
     *
     * @param \Filament\Tables\Table $table
     *
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles')
                    ->label(__('Roles'))
                    ->placeholder(__('No roles assigned'))
                    ->state(fn (User $record) => $record->roles->pluck('name')->join(', ')),
                IconColumn::make('email_verified_at')
                    ->label(__('Email Verified'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('deleted_at')
                    ->label(__('Deleted'))
                    ->boolean()
                    ->sortable(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
