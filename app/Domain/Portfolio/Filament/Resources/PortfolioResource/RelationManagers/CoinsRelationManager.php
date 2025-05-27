<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\RelationManagers;

use App\Domain\Coin\Models\Coin;
use Auth;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
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
                ActionGroup::make([
                    Action::make('edit_amount')
                        ->label('Edit Amount')
                        ->icon('heroicon-o-pencil')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->authorize(fn (Coin $record) => Auth::user()->can('changeAmount', $record))
                        ->form([
                            TextInput::make('pivot.amount')
                                ->label('Amount Held')
                                ->numeric()
                                ->required()
                                ->default(fn (Coin $record) => $record->pivot->amount)
                                ->minValue(0),
                        ])
                        ->action(function (Coin $record, array $data) {
                            $record->pivot->update(['amount' => $data['pivot']['amount']]);

                            Notification::make()
                                ->title('Amount Updated')
                                ->body("The amount for {$record->name} has been updated to {$data['pivot']['amount']}.")
                                ->success()
                                ->send();
                        }),
                    DetachAction::make()
                        ->label('Remove Coin')
                        ->color('danger')
                        ->requiresConfirmation(),
                ])
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
