<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\ORM\Query;

/**
 * Trash component
 */
class TrashComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    /**
     * checkTrashIndex method
     *
     * @param \Cake\ORM\Query $query Query
     * @return \Cake\ORM\Query
     */
    public function filterQuery(Query $query): Query
    {
        if ($this->trashed()) {
            $query = $query->find('onlyTrashed');
        }

        return $query;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        $this->getController()->set('trashed', $this->trashed());
    }

    /**
     * @return bool
     */
    protected function trashed(): bool
    {
        return (bool)$this->getController()->getRequest()->getQuery('trash') ?? false;
    }
}
