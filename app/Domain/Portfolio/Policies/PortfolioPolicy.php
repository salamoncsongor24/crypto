<?php

namespace App\Domain\Portfolio\Policies;

use App\Domain\Common\Policies\CommonPolicy;

class PortfolioPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'portfolio';
}
