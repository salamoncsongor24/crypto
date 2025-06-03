<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\Pages;

use App\Domain\Portfolio\Filament\Resources\PortfolioResource;
use App\Domain\Portfolio\Filament\Resources\PortfolioResource\Widgets\PortfolioTotalValueWidget;
use App\Domain\Portfolio\Models\Portfolio;
use Filament\Actions;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\InlineChart\Tables\Columns\InlineChart;

class ListPortfolios extends ListRecords
{
    /**
     * The resource that this page is associated with.
     *
     * @var string
     */
    protected static string $resource = PortfolioResource::class;

    /**
     * The table configuration for the resource listing page.
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
            ->columns([
                TextColumn::make('name')
                    ->label(__('Portfolio Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50)
                    ->placeholder(__('No description'))
                    ->searchable(),
                InlineChart::make('value_chart')
                    ->label('Portfolio Value Chart (Last 24 hours)')
                    ->chart(PortfolioTotalValueWidget::class)
                    ->maxWidth(350)
                    ->maxHeight(100),
                TextColumn::make('value')
                    ->label(__('Current Portfolio Value'))
                    ->getStateUsing(fn (Portfolio $record) => $record->getTotalValue($currency))
                    ->description(
                        fn (Portfolio $record)=> __('Last updated: ') . $record->getCoinPriceLastUpdated($currency)?->diffForHumans())
                    ->money($currency, true),
                IconColumn::make('is_public')
                    ->label(__('Public'))
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
            ]);
    }

    /**
     * Get the header actions for the page.
     *
     * @return array<Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
