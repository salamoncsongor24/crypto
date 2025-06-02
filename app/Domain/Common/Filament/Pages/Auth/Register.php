<?php

namespace App\Domain\Common\Filament\Pages\Auth;

use Filament\Forms\Components\Toggle;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    /**
     * Get the register form.
     *
     * @return array{form: \Filament\Forms\Form}
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getNotificationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Get the notification subscription switch
     *
     * @return Toggle
     */
    protected function getNotificationFormComponent(): Toggle
    {
        return Toggle::make('get_notifications')
            ->label('Subscribe to Notifications')
            ->default(true)
            ->helperText('Get notifications about New coins, Price changes')
            ->onIcon('heroicon-m-bell-alert')
            ->offIcon('heroicon-m-bell-slash')
            ->onColor('success')
            ->offColor('danger');
    }
}
