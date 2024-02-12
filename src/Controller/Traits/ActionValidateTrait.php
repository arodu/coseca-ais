<?php
declare(strict_types=1);

namespace App\Controller\Traits;

trait ActionValidateTrait
{
    /**
     * @return bool
     */
    public function actionValidate(): bool
    {
        return $this->getRequest()->getData('action') === 'validate';
    }
}
