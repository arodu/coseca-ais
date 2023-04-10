<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Cache\Cache;
use Cake\ORM\Locator\LocatorAwareTrait;

trait SysActionsTrait
{
    use LocatorAwareTrait;

    public function getList(string $repository, string $field = null, string $reference = null)
    {
        $cacheKey = 'sys_actions_' . $repository . '_' . $field . '_' . $reference;
        $data = Cache::remember($cacheKey, function () use ($repository, $field, $reference) {
            $table = $this->fetchTable($repository);

            if (empty($reference) || empty($field)) {
                return $table->find('list')->toArray();
            }

            return $table->find('list')->where([$table->aliasField($field) => $reference])->toArray();
        });

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
