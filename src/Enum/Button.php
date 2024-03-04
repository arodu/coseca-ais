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
    case EXPORT = 'export';
    case SEARCH = 'search';
    case VIEW = 'view';
    case REPORT = 'report';
    case FILE_REPORT = 'fileReport';
    case STATISTICS = 'statistics';
    case ADD = 'add';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case REMOVE = 'remove';
    case CONFIRM = 'confirm';

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
            self::EXPORT => [
                'type' => 'submit',
                'name' => 'export',
                'value' => 'csv',
                'icon' => 'file-csv',
                'label' => __('Exportar'),
                'actionColor' => ActionColor::REPORT,
                'render' => self::RENDER_BUTTON,
            ],
            self::SEARCH => [
                'type' => 'submit',
                'name' => 'action',
                'value' => 'search',
                'icon' => 'search',
                'label' => __('Buscar'),
                'actionColor' => ActionColor::SEARCH,
                'render' => self::RENDER_BUTTON,
            ],
            self::VIEW => [
                'icon' => 'view',
                'label' => false,
                'escape' => false,
                'actionColor' => ActionColor::VIEW,
                'override' => false,
                'outline' => true,
                'render' => self::RENDER_LINK,
            ],
            self::REPORT => [
                'icon' => 'report',
                'label' => false,
                'escape' => false,
                'actionColor' => ActionColor::REPORT,
                'override' => false,
                'outline' => false,
                'target' => '_blank',
                'render' => self::RENDER_LINK,
            ],
            self::FILE_REPORT => [
                'icon' => 'report',
                'label' => false,
                'escape' => false,
                'actionColor' => ActionColor::REPORT,
                'override' => false,
                'outline' => false,
                'target' => '_blank',
                'render' => self::RENDER_LINK,
            ],
            self::STATISTICS => [
                'icon' => 'chart-bar',
                'label' => __('Reportes'),
                'escape' => false,
                'actionColor' => ActionColor::REPORT,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            self::ADD => [
                'icon' => 'add',
                'label' => __('Agregar'),
                'escape' => false,
                'actionColor' => ActionColor::ADD,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            self::EDIT => [
                'icon' => 'edit',
                'label' => false,
                'escape' => false,
                'actionColor' => ActionColor::EDIT,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            self::DELETE => [
                'icon' => 'delete',
                'label' => __('Eliminar'),
                'escape' => false,
                'actionColor' => ActionColor::DELETE,
                'override' => false,
                'outline' => false,
                'confirm' => __('Seguro que desea eliminar este registro?'),
                'render' => self::RENDER_POST_LINK,
            ],
            self::REMOVE => [
                'icon' => 'remove',
                'label' => __('Eliminar'),
                'escape' => false,
                'actionColor' => ActionColor::DELETE,
                'override' => false,
                'outline' => false,
                'confirm' => __('Seguro que desea eliminar este registro?'),
                'render' => self::RENDER_POST_LINK,
            ],
            self::CONFIRM => [
                'icon' => 'edit',
                'label' => false,
                'escape' => false,
                'actionColor' => ActionColor::EDIT,
                'override' => false,
                'outline' => false,
                'confirm' => __('Seguro que desea realizar esta acción?'),
                'render' => self::RENDER_POST_LINK,
            ],
            default => [],
        };
    }
}
