<?php

namespace App\Domain\Coin\Policies;

use App\Domain\Common\Policies\CommonPolicy;

class CoinPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'coin';
}
