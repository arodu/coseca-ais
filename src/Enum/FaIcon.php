<?php
declare(strict_types=1);

namespace App\Enum;

enum FaIcon
{
    case DEFAULT;

    case DOWNLOAD;
    case IN_PROGRESS;
    case WAITING;
    case SUCCESS;
    case PENDING;
    case FAILED;

    case STAR;


    /**
     * @return string
     */
    public function cssClass(): string
    {
        return match($this) {
            static::DOWNLOAD => 'fas fa-download',
            static::IN_PROGRESS => 'fas fa-cogs',
            static::WAITING => 'fas fa-pause-circle',
            static::SUCCESS => 'fas fa-check',
            static::PENDING => 'fas fa-lock',
            static::FAILED => 'fas fa-alert',
            static::STAR => 'fas fa-star',

            default => 'fas fa-flag',
        };
    }

    /**
     * Return a formated icon
     * Examp: <i class="fas fa-flag"></i>
     * 
     * @param string $extraCssClass
     * @return string
     */
    public function render(string $extraCssClass = ''): string
    {
        $class = trim(implode(' ', [
            $this->cssClass(),
            $extraCssClass
        ]));

        return '<i class="' . $class . '"></i>';
    }
}
