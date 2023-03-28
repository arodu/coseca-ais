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
    case SPECIAL;
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
            static::SPECIAL => Color::WARNING,
            static::REPORT => Color::SUCCESS,
            static::ROOT => Color::INDIGO,
            default => Color::DEFAULT,
        };
    }

    public function btn(string $extra = ''): string
    {
        $output = implode(' ', [
            $this->color()->btn(),
            'btn-flat',
            $extra,
        ]);

        return trim($output);
    }

    public function text(): string
    {
        return $this->color()->text();
    }
}
