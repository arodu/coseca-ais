<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * Button enum
 */
enum Button: string
{
    case SAVE = 'save';
    case VALIDATE = 'validate';
    case OPEN_MODAL = 'openModal';
    case CLOSE_MODAL = 'closeModal';
    case CANCEL = 'cancel';
    case BACK = 'back';

    public const RENDER_BUTTON = 'button';
    public const RENDER_LINK = 'link';
    public const RENDER_POST_LINK = 'postLink';

    public const ICON_POSITION_LEFT = 'left';
    public const ICON_POSITION_RIGHT = 'right';

    /**
     * @return array
     */
    public function options(): array
    {
        return match ($this) {
            self::SAVE => [
                'type' => 'submit',
                'name' => 'action',
                'value' => 'save',
                'icon' => 'save',
                'actionColor' => ActionColor::SUBMIT,
                'render' => self::RENDER_BUTTON,
                'label' => __('Guardar'),
            ],
            self::VALIDATE => [
                'type' => 'submit',
                'name' => 'action',
                'value' => 'validate',
                'icon' => 'validate',
                'actionColor' => ActionColor::VALIDATE,
                'render' => self::RENDER_BUTTON,
                'confirm' => __('Seguro que desea validar este registro?'),
                'label' => __('Guardar y Validar'),
            ],
            self::OPEN_MODAL => [
                'type' => 'button',
                'data-toggle' => 'modal',
                'data-target' => '#modal',
                'icon' => 'default',
                'actionColor' => ActionColor::ADD,
                'render' => self::RENDER_BUTTON,
            ],
            self::CLOSE_MODAL => [
                'type' => 'button',
                'data-dismiss' => 'modal',
                'icon' => 'default',
                'label' => __('Cerrar'),
                'actionColor' => ActionColor::CANCEL,
                'render' => self::RENDER_BUTTON,
            ],
            self::CANCEL => [
                'icon' => null,
                'label' => __('Cancelar'),
                'escape' => false,
                'actionColor' => ActionColor::CANCEL,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            self::BACK => [
                'icon' => 'back',
                'label' => __('Volver'),
                'escape' => false,
                'actionColor' => ActionColor::CANCEL,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            default => [],
        };
    }
}
