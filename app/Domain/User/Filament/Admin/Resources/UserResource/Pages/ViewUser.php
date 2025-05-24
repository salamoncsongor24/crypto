<?php

namespace App\Domain\User\Filament\Admin\Resources\UserResource\Pages;

use App\Domain\User\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    /**
     * @var string $resource The resource that this page is associated with.
     */
    protected static string $resource = UserResource::class;

    /**
     * Get the header actions for the view user page.
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
