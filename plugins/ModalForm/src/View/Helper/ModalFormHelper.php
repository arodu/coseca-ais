<?php

declare(strict_types=1);

namespace ModalForm\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\View;
use ModalForm\ModalFormPlugin;

/**
 * FormModal helper
 * 
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class ModalFormHelper extends Helper
{
    /**
     * helpers
     *
     * @var array
     */
    protected $helpers = ['Html', 'Url'];

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'element' => ModalFormPlugin::FORM_CHECKBOX,
        'modalScript' => null,
        'content' => [],
    ];

    protected $modalScript = <<<MODAL_SCRIPT
    $('#:target').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let modal = $(this)
        modal.find('form').prop('action', button.data('url'));
        modal.find('.message').html(button.data('confirm'));
    })
    MODAL_SCRIPT;

    public function addModal(string $target, array $options = []): string
    {
        $modalScript = $options['modalScript'] ?? $this->getConfig('modalScript') ?? $this->modalScript;
        $element = $options['element'] ?? $this->getConfig('element');
        $content = array_merge($this->defaultContentData($element), $this->getConfig('content'), $options['content'] ?? []);

        $this->Html->scriptBlock(Text::insert($modalScript, [
            'target' => $target,
        ]), ['block' => true]);

        return $this->getView()->element($element, [
            'target' => $target,
            'content' => $content,
        ]);
    }

    public function link($title, $url = null, array $options = []): string
    {
        $options['data-url'] = $this->Url->build($url);
        $options['data-toggle'] = 'modal';
        $options['data-target'] = '#' . $options['target'];
        unset($options['target']);
        $options['data-confirm'] = $options['confirm'] ?? null;
        unset($options['confirm']);

        return $this->Html->link($title, '#', $options);
    }

    protected function defaultContentData($element): array
    {
        $content = [
            'buttonOk' => __('Submit'),
            'buttonCancel' => __('Cancel'),
        ];

        switch ($element) {
            case ModalFormPlugin::FORM_CONFIRM:
                $content['buttonOk'] = __('Yes');
                $content['buttonCancel'] = __('No');
                break;
            case ModalFormPlugin::FORM_TEXT_INPUT:
                $content['confirm'] = 'sample_text';
                $content['textTemplate'] = 'Type <code>:confirm</code> to confirm';
                break;
        }

        return $content;
    }
}
