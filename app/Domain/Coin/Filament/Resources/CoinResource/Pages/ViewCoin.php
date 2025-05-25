<?php

namespace App\Domain\Coin\Filament\Resources\CoinResource\Pages;

use App\Domain\Coin\Filament\Resources\CoinResource;
use App\Domain\Coin\Models\Coin;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewCoin extends ViewRecord
{
    /**
     * @var string $resource The resource that this page is associated with.
     */
    protected static string $resource = CoinResource::class;

    /**
     * Returns an Infolist instance for displaying coin information.
     *
     * @param \Filament\Infolists\Infolist $infolist
     *
     * @return Infolist
     */
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('Coin Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),
                        TextEntry::make('remote_id')
                            ->label(__('Remote ID')),
                        TextEntry::make('symbol')
                            ->label(__('Symbol')),
                        TextEntry::make('status')
                            ->label(__('Status')),
                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->placeholder(__('No description provided'))
                            ->html()
                            ->columnSpan(['md' => 2]),
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
                            ->visible(fn (Coin $record) => $record->trashed()),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
