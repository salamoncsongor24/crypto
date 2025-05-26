<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Table;

class CoinsRelationManager extends RelationManager
{
    /**
     * @var string $relationship The name of the relationship.
     */
    protected static string $relationship = 'coins';

    /**
     * The table configuration for the relation manager.
     *
     * @param \Filament\Tables\Table $table
     *
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Coin Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('symbol')
                    ->label('Symbol')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.amount')
                    ->label('Amount')
                    ->sortable()
                    ->numeric(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Add Coin')
                    ->color('primary')
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('amount')
                            ->label('Amount Held')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(1),
                    ])
            ])
            ->actions([
                DetachAction::make()
                    ->label('Remove Coin')
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
    }

    /**
     * Determine if the relation manager is read-only.
     *
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return false;
    }
}
