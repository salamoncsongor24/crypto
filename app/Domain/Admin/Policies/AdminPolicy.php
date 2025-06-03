<?php

namespace App\Domain\Admin\Policies;

use App\Domain\Common\Policies\CommonPolicy;

class AdminPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'admin';
}
