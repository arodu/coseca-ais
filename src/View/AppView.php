<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View;

use Authentication\IdentityInterface;
use Cake\Core\Configure;
use Cake\View\View;
use CakeLte\View\CakeLteTrait;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 * 
 * @property \App\View\Helper\AppHelper $App
 * @property \CakeLteTools\View\Helper\DependentSelectorHelper $DependentSelector
 * @property \CakeLteTools\View\Helper\BulkActionHelper $BulkAction
 * @property \ModalForm\View\Helper\ModalFormHelper $ModalForm
 * @property \App\View\Helper\ButtonHelper $Button
 * @property \App\View\Helper\PdfHelper $Pdf
 */
class AppView extends View
{
    use CakeLteTrait;

    public $layout = 'CakeLte.top-nav';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->initializeCakeLte();
        $this->loadHelper('Authentication.Identity');
        $this->loadHelper('ModalForm.ModalForm');
        $this->loadHelper('CakeLteTools.DependentSelector');
        $this->loadHelper('CakeLteTools.BulkAction');
        $this->loadHelper('Button');
        $this->loadHelper('Pdf');
    }

    /**
     * @param string|callable $info
     * @param array $options
     * @return string|null
     */
    public function devInfo(string|callable $info, array $options = []): ?string
    {
        if (!Configure::read('debug') || empty($info)) {
            return null;
        }

        if (is_callable($info)) {
            ob_start();
            $info();
            $info = ob_get_clean();
        }

        $options = array_merge([
            'tag' => 'div',
            'class' => 'alert alert-light border p-2',
        ], $options);

        $tag = $options['tag'];
        unset($options['tag']);

        return $this->Html->tag($tag, $info, $options);
    }

    public function getIdentity(): IdentityInterface
    {
        return $this->getRequest()->getAttribute('identity');
    }
}
