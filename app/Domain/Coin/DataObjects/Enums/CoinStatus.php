<?php

namespace App\Domain\Coin\DataObjects\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self active()
 * @method static self inactive()
 */
class CoinStatus extends Enum implements HasLabel, HasColor
{
    /**
     * Get the label for the enum value.
     *
     * @return array<string, string>
     */
    protected static function labels(): array
    {
        return [
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];
    }

    /**
     * Get status label.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return match ($this->value) {
            'active' => __('Active'),
            'inactive' => __('Inactive'),
            default => null,
        };
    }

    /**
     * Get status color based on the value.
     *
     * @return string|null
     */
    public function getColor(): ?string
    {
        return match ($this->value) {
            'active' => 'success',
            'inactive' => 'danger',
            default => null,
        };
    }
}
