<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\Pages;

use App\Domain\Portfolio\Filament\Resources\PortfolioResource;
use Filament\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePortfolio extends CreateRecord
{
    /**
     * The resource that this page is associated with.
     *
     * @var string
     */
    protected static string $resource = PortfolioResource::class;

    /**
     * Returns a Form instance for creating a portfolio.
     *
     * @param \Filament\Forms\Form $form
     *
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Portfolio Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Portfolio Name')
                            ->required()
                            ->string()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Description')
                            ->string()
                            ->maxLength(5000),
                        Hidden::make('user_id')
                            ->default(Auth::user()->id)
                            ->required(),
                        Hidden::make('public')
                            ->default(false)
                            ->required(),
                    ]),
            ]);
    }
}
