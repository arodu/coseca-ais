<?php
declare(strict_types=1);

namespace App\Controller\Traits;

trait ActionValidateTrait
{
    public function actionValidate()
    {
        return $this->getRequest()->getData('action') === 'validate';
    }
}
