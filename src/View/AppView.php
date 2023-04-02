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
 * @property \App\View\Helper\BulkActionHelper $BulkAction
 * @property \App\View\Helper\Button $Button
 * @property \App\View\Helper\DependentSelector $DependentSelector
 * @property \ModalForm\View\Helper\ModalFormHelper $ModalForm
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
        $this->loadHelper('DependentSelector');
        $this->loadHelper('Button');
    }
}
