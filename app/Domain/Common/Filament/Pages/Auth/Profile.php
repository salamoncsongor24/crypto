<?php

namespace App\Domain\Common\Filament\Pages\Auth;

use Filament\Forms\Components\Toggle;
use Filament\Pages\Auth\EditProfile as BaseProfile;

class Profile extends BaseProfile
{
    /**
     * Get the profile form
     *
     * @return array<int | string, string | \Filament\Forms\Form>
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
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
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
            ->helperText('Get notifications about New coins, Price changes')
            ->onIcon('heroicon-m-bell-alert')
            ->offIcon('heroicon-m-bell-slash')
            ->onColor('success')
            ->offColor('danger');
    }
}
