<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Color;

interface BadgeInterface
{
    public function label(): string;
    public function color(): Color;
}
