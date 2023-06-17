<?php

declare(strict_types=1);

namespace System\Controller;

use Cake\Cache\Cache;
use Cake\ORM\Locator\LocatorAwareTrait;
use System\Controller\AppController;
use System\Utility\Lists;

/**
 * Lists Controller
 *
 * @method \System\Model\Entity\List[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ListsController extends AppController
{
    use LocatorAwareTrait;

    //public function countries()
    //{    
    //}

    public function states()
    {
        $data = Lists::states();

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    public function citites($state_id = null)
    {
        $data = Lists::citites($state_id);

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    public function municipalities($state_id = null)
    {
        $data = Lists::municipalities($state_id);

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    public function parishes($municipalitiy_id = null)
    {
        $data = Lists::parishes($municipalitiy_id);

        $this->RequestHandler->renderAs($this, 'json');
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
