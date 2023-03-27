<?php

declare(strict_types=1);

namespace App\Enum;

enum Color: string
{
    case DEFAULT = 'default';

    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case DANGER = 'danger';

    case BLACK = 'black';
    case GRAY_DARK = 'gray-dark';
    case GRAY = 'gray';
    case LIGHT = 'light';
    case DARK = 'dark';

    case INDIGO = 'indigo';
    case LIGHTBLUE = 'lightblue';
    case NAVY = 'navy';
    case PURPLE = 'purple';
    case FUCHSIA = 'fuchsia';
    case PINK = 'pink';
    case MAROON = 'maroon';
    case ORANGE = 'orange';
    case LIME = 'lime';
    case TEAL = 'teal';
    case OLIVE = 'olive';

    /**
     * @param string $prefix
     * @param boolean $includePrefixClass, default true
     * @return string
     */
    public function cssClass(string $prefix = 'card', bool $includePrefixClass = true): string
    {
        return trim(implode(' ', [
            $includePrefixClass ? $prefix : null,
            $prefix . '-' . $this->value,
        ]));
    }

    /**
     * return "bg-primary"
     *
     * @return string
     */
    public function bg(): string
    {
        return $this->cssClass('bg', false);
    }

    /**
     * return "text-primary"
     *
     * @return string
     */
    public function text(): string
    {
        return $this->cssClass('text', false);
    }

    /**
     * return "badge badge-primary"
     *
     * @return string
     */
    public function badge(): string
    {
        return $this->cssClass('badge', true);
    }

    /**
     * return "card card-primary"
     *
     * @return string
     */
    public function card(): string
    {
        return $this->cssClass('card', true);
    }

    /**
     * return "btn btn-primary"
     *
     * @return string
     */
    public function btn(): string
    {
        return $this->cssClass('btn', true);
    }
}
