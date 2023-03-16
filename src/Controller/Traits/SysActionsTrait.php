<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\LocatorAwareTrait;

trait SysActionsTrait
{
    use LocatorAwareTrait;

    public function getStates()
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        $states = $this->fetchTable('SysStates')->find('list');

        $this->set('data', $states);
        $this->set('_serialize', ['data']);
    }

    public function getCities($state_id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        $cities = $this->fetchTable('SysCities')->find('list', [
            'conditions' => ['state_id' => $state_id],
        ]);

        $this->set('data', $cities);
        $this->set('_serialize', ['data']);
    }

    public function getMunicipalities($state_id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        $municipalities = $this->fetchTable('SysMunicipalities')->find('list', [
            'conditions' => ['state_id' => $state_id],
        ]);

        $this->set('data', $municipalities);
        $this->set('_serialize', ['data']);
    }

    public function getParishes($municipality_id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        $parishes = $this->fetchTable('SysParishes')->find('list', [
            'conditions' => ['municipality_id' => $municipality_id],
        ]);

        $this->set('data', $parishes);
        $this->set('_serialize', ['data']);
    }
}
