<?php

namespace App\Domain\User\Policies;

use App\Domain\Common\Policies\CommonPolicy;

class UserPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'user';
}
