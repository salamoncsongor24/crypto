<?php

namespace App\Domain\Coin\Filament\Resources\CoinResource\Pages;

use App\Domain\Coin\Contracts\CoinApiContract;
use App\Domain\Coin\DataObjects\Enums\CoinStatus;
use App\Domain\Coin\Filament\Resources\CoinResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

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
                    Actions\Action::make('activate')
                        ->label(__('Activate'))
                        ->authorize(fn () => Auth::user()->can('activate', CoinResource::getModel()))
                        ->action(fn ($record) => $record->update(['status' => CoinStatus::active()]))
                        ->requiresConfirmation()
                        ->visible(fn ($record) => $record->status !== CoinStatus::active())
                        ->icon('heroicon-o-check-circle')
                        ->color('success'),
                    Actions\Action::make('deactivate')
                        ->label(__('Deactivate'))
                        ->authorize(fn () => Auth::user()->can('deactivate', CoinResource::getModel()))
                        ->action(fn ($record) => $record->update(['status' => CoinStatus::inactive()]))
                        ->requiresConfirmation()
                        ->visible(fn ($record) => $record->status !== CoinStatus::inactive())
                        ->icon('heroicon-o-x-circle')
                        ->color('danger'),
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
            Action::make('import')
                ->label(__('Import'))
                ->icon('heroicon-o-cloud-arrow-down')
                ->color('primary')
                ->requiresConfirmation()
                ->form([
                    Select::make('select_coin')
                        ->label(__('Select Coin'))
                        ->searchable()
                        ->live()
                        ->reactive()
                        ->getSearchResultsUsing(function (string $search, CoinApiContract $coinApiService) {
                            return strlen($search) > 2
                                ? $coinApiService->searchCoins($search)->map(function ($coin) {
                                    return [
                                        'value' => $coin->remote_id,
                                        'label' => "{$coin->name} ({$coin->symbol})",
                                    ];
                                })->pluck('label', 'value')
                                : collect([]);
                        })
                        ->afterStateUpdated(function ($state, Set $set, CoinApiContract $coinApiService) {
                                $set('description', $coinApiService->fetchCoinDescription($state));
                        })
                        ->required(),

                    Textarea::make('description')
                        ->label(__('Description'))
                        ->visible(fn (Get $get) => $get('select_coin') !== null)
                        ->maxLength(5000)
                        ->placeholder(__('No description from the API. Feel free to add your own description here.')),

                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->default(true)
                        ->visible(fn (Get $get) => $get('select_coin') !== null),

                    Checkbox::make('notify_users')
                        ->label(__('Notify Users?'))
                        ->default(false)
                        ->visible(fn (Get $get) => $get('select_coin') !== null),
                ])
                ->action(function (array $data) {
                    dd($data);
                }),
        ];
    }
}
