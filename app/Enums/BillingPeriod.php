<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Monthly()
 * @method static static Yearly()
 */
final class BillingPeriod extends Enum
{
    public const Monthly = 0;

    public const Yearly = 1;
}
