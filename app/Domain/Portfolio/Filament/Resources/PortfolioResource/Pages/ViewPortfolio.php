<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\Pages;

use App\Domain\Portfolio\Filament\Resources\PortfolioResource;
use App\Domain\Portfolio\Models\Portfolio;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPortfolio extends ViewRecord
{
    /**
     * The resource that this page is associated with.
     *
     * @var string
     */
    protected static string $resource = PortfolioResource::class;

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
                Section::make(__('Portfolio Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),
                        TextEntry::make('description')
                            ->label(__('Description'))
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
                            ->visible(fn (Portfolio $record) => $record->trashed()),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    /**
     * Get the header actions for the page.
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
