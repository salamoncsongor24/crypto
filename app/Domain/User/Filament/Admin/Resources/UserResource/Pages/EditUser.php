<?php

namespace App\Domain\User\Filament\Admin\Resources\UserResource\Pages;

use App\Domain\User\Filament\Admin\Resources\UserResource;
use App\Domain\User\Models\User;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    /**
     * @var string $resource The resource that this page is associated with.
     */
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->unique(
                        table: 'users',
                        column: 'email',
                        ignorable: fn (User $record) => $record,
                        ignoreRecord: true
                    ),
                DateTimePicker::make('email_verified_at')
                    ->label(__('Email Verified At'))
                    ->nullable(),
            ]);
    }

    /**
     * Get the header actions for the edit user page.
     *
     * @return array<Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
