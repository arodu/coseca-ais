<?php
declare(strict_types=1);

namespace App\Enum;

use CakeLteTools\Enum\Color;

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
    case ACTIVATE;
    case DEACTIVATE;
    case SPECIAL;
    case REPORT;
    case SEARCH;
    case ROOT;
    case DEFAULT;

    /**
     * @return \CakeLteTools\Enum\Color
     */
    public function color(): Color
    {
        return match ($this) {
            static::VIEW => Color::DEFAULT,
            static::CANCEL => Color::SECONDARY,
            static::BACK => Color::SECONDARY,
            static::ADD => Color::INFO,
            static::EDIT => Color::INFO,
            static::SUBMIT => Color::PRIMARY,
            static::VALIDATE => Color::SUCCESS,
            static::DELETE => Color::DANGER,
            static::ACTIVATE => Color::WARNING,
            static::DEACTIVATE => Color::SECONDARY,
            static::SPECIAL => Color::WARNING,
            static::REPORT => Color::SUCCESS,
            static::SEARCH => Color::PRIMARY,
            static::ROOT => Color::INDIGO,
            static::DEFAULT => Color::DEFAULT,
            default => Color::DEFAULT,
        };
    }

    /**
     * @param string|null $extra
     * @param bool $outline
     * @return string
     */
    public function btn(?string $extra = null, bool $outline = false): string
    {
        $output = implode(' ', [
            $this->color()->btn($outline),
            'btn-flat',
            $extra,
        ]);

        return trim($output);
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->color()->text();
    }
}
