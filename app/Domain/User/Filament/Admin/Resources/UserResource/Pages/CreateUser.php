<?php

namespace App\Domain\User\Filament\Admin\Resources\UserResource\Pages;

use App\Domain\User\Filament\Admin\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    /**
     * @var string $resource The resource that this page is associated with.
     */
    protected static string $resource = UserResource::class;
}
