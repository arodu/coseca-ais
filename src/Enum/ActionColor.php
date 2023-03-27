<?php

declare(strict_types=1);

namespace App\Enum;

enum ActionColor
{
    case VIEW;
    case CANCEL;
    case BACK;
    case ADD;
    case EDIT;
    case SUBMIT;
    case VALIDATE;
    case DELETE;
    case INACTIVE;
    case ESPECIAL;
    case REPORT;
    case ROOT;

    public function color(): Color
    {
        return match ($this) {
            static::VIEW => Color::SECONDARY,
            static::CANCEL => Color::DEFAULT,
            static::BACK => Color::DEFAULT,
            static::ADD => Color::INFO,
            static::EDIT => Color::INFO,
            static::SUBMIT => Color::PRIMARY,
            static::VALIDATE => Color::SUCCESS,
            static::DELETE => Color::DANGER,
            static::INACTIVE => Color::DANGER,
            static::ESPECIAL => Color::WARNING,
            static::REPORT => Color::SUCCESS,
            static::ROOT => Color::ORANGE,
            default => Color::DEFAULT,
        };
    }

    public function btn(): string
    {
        return $this->color()->btn();
    }
}
