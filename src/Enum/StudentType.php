<?php
declare(strict_types=1);

namespace App\Enum;

enum StudentType: string
{
    case REGULAR = 'regular';
    case VALIDATED = 'validated';
}
