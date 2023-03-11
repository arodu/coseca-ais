<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum DocumentType: string
{
    use ListTrait;
    use BasicEnumTrait;

    case ADSCRIPTION = 'adscription';
}
