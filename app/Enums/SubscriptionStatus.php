<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Expired()
 * @method static static Active()
 */
final class SubscriptionStatus extends Enum
{
    public const Expired = 0;

    public const Active = 1;
}
