<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\JsonView;

trait SysActionsTrait
{
    use LocatorAwareTrait;

    public function getList(string $repository, string $field = null, string $reference = null)
    {
        $this->RequestHandler->renderAs($this, 'json');

        $table = $this->fetchTable($repository);

        if (empty($reference) || empty($field)) {
            $data = $table->find('list');
        } else {
            $data = $table->find('list', [
                'conditions' => [$table->aliasField($field) => $reference],
            ]);
        }

        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
