<?php

namespace App\Domain\Coin\Filament\Resources\CoinResource\Pages;

use App\Domain\Coin\Filament\Resources\CoinResource;
use Filament\Tables\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ListCoins extends ListRecords
{
    /**
     * @var string $resource The name of the resource that this page is associated with.
     */
    protected static string $resource = CoinResource::class;

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
                TextColumn::make('remote_id')
                    ->label(__('Remote ID'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('symbol')
                    ->label(__('Symbol'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                    Actions\RestoreAction::make(),
                    Actions\ForceDeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
                Actions\RestoreBulkAction::make(),
                Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    /**
     * Get the header title for the list coins page.
     *
     * @return string
     */
    protected function getHeaderActions(): array
    {
        return [
            // Import action can be added here if needed
        ];
    }
}
