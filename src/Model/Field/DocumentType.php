<?php
declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum DocumentType: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case ADSCRIPTION_PROJECT = 'adscription_project';
    case ADSCRIPTION_TRACKING = 'adscription_tracking';
}
