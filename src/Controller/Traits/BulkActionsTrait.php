<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Http\Exception\NotFoundException;

trait BulkActionsTrait
{
    public function bulkActions()
    {
        $data = $this->getRequest()->getData();

        $action = $data['action'];
        $items = array_keys($data['item']) ?? [];

        if (method_exists($this, $action)) {
            return $this->$action($items);
        }

        throw new NotFoundException(__('method {0} doesn\'t exists on class {1}', $action, $this::class));
    }
}
