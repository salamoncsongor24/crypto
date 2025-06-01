<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\RelationManagers;

use App\Domain\Coin\Filament\Resources\CoinResource\Widgets\CoinPriceWidget;
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
use LaraZeus\InlineChart\Tables\Columns\InlineChart;

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
        $currency = config('currency.default_currency');

        return $table
            ->poll('5s')
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
                Tables\Columns\TextColumn::make('held_value')
                    ->label('Held Value')
                    ->getStateUsing(fn (Coin $record) => $record->pivot->amount * $record->getCurrentPrice($currency))
                    ->description(
                        fn (Coin $record) => __('Last updated: ') . $record->getCurrentPriceLastUpdated($currency)->diffForHumans()
                        )
                    ->money($currency, true),
                InlineChart::make('price_chart')
                    ->label('Coin Value Chart (Last 24 hours)')
                    ->chart(CoinPriceWidget::class)
                    ->maxWidth(350)
                    ->maxHeight(100),
                Tables\Columns\TextColumn::make('coin_value')
                    ->label('Coin Current Value')
                    ->getStateUsing(fn (Coin $record) => $record->getCurrentPrice($currency))
                    ->description(
                        fn (Coin $record) => __('Last updated: ') . $record->getCurrentPriceLastUpdated($currency)->diffForHumans()
                    )
                    ->money($currency, true),
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
