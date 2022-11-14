<?php
declare(strict_types=1);

namespace App\Enum;

enum FaIcon: string
{
    case DOWNLOAD = 'fas fa-download';
    case IN_PROGRESS = 'fas fa-cogs';
    case WAITING = 'fas fa-pause-circle';
    case SUCCESS = 'fas fa-check';
    case PENDING = 'fas fa-lock';
}
