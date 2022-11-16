<?php
declare(strict_types=1);

namespace App\Model\Field;

enum StudentType: string
{
    case REGULAR = 'regular';
    case VALIDATED = 'validated';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::REGULAR => __('Regular'),
            static::VALIDATED => __('Convalidación'),

            default => __('NaN'),
        };
    }

    /**
     * @return array
     */
    public function getStageFieldList(): array
    {
        switch($this) {
            case StudentType::VALIDATED:
                    return [
                        StageField::REGISTER,
                        StageField::VALIDATION,
                    ];
                break;

            case StudentType::REGULAR:
            default:
                    return [
                        StageField::REGISTER,
                        StageField::COURSE,
                        StageField::ADSCRIPTION,
                        StageField::TRACKING,
                        StageField::ENDING,
                    ];
                break;
        }
    }
}
