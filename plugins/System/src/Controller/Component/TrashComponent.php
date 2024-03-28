<?php

declare(strict_types=1);

namespace System\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;

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
    protected $_defaultConfig = [
        'model' => null,
        'items' => 'items',
    ];

    /**
     * @return void
     */
    public function initialize(array $config): void
    {
        if (empty($this->getConfig('model'))) {
            $this->setConfig('model', $this->getController()->fetchTable());
        }
    }


    /**
     * Get the model associated with the TrashComponent.
     *
     * @return Table The model associated with the TrashComponent.
     */
    protected function getModel(): Table
    {
        return $this->getConfig('model');
    }

    /**
     * Retrieves a trashed entity by its ID.
     *
     * @param int $id The ID of the entity to retrieve.
     * @return EntityInterface|null The trashed entity, or null if not found.
     */
    protected function getEntity($id): EntityInterface
    {
        return $this->getModel()
            ->find('onlyTrashed')
            ->where([$this->getModel()->aliasField('id') => $id])
            ->first();
    }

    /**
     * Handles the trash index action.
     *
     * Retrieves the trashed items from the model and paginates them for display.
     * The paginated items are then set in the controller's view.
     *
     * @return void
     */
    public function handleTrashIndex()
    {
        $query = $this->getModel()->find('onlyTrashed');
        $items = $this->getController()->paginate($query);
        $this->getController()->set($this->getConfig('items'), $items);
    }

    /**
     * Handles emptying the trash.
     */
    public function handleEmptyTrash()
    {
        return $this->getModel()->emptyTrash();
    }

    /**
     * Handles the restoration of a trashed entity.
     *
     * @param int $id The ID of the trashed entity to be restored.
     * @return mixed The result of the cascading restore operation.
     */
    public function handleRestore($id)
    {
        $entity = $this->getEntity($id);

        return $this->getModel()->cascadingRestoreTrash($entity);
    }

    /**
     * Handles the deletion of an entity from the trash.
     *
     * @param int $id The ID of the entity to be deleted.
     * @return bool True if the entity is successfully deleted, false otherwise.
     */
    public function handleDelete($id)
    {
        $entity = $this->getEntity($id);

        return $this->getModel()->trash($entity);
    }

    /**
     * Handles the hard deletion of an entity from the trash.
     *
     * @param int $id The ID of the entity to be hard deleted.
     * @return bool Returns true if the entity was successfully hard deleted, false otherwise.
     */
    public function handleHardDelete($id)
    {
        $entity = $this->getEntity($id);

        return $this->getModel()->delete($entity, ['purge' => true]);
    }
}
