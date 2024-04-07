<?php

declare(strict_types=1);

namespace System\Controller\Traits;

trait TrashTrait
{
    /**
     * @return void
     */
    public function trash()
    {
        $this->Trash->handleTrashIndex();
    }

    /**
     * @return void
     */
    public function emptyTrash()
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $this->Trash->handleEmptyTrash();
        $this->Flash->success(__('The trash has been emptied.'));
        return $this->redirect(['action' => 'trash']);
    }

    /**
     * @param string|int $id
     * @return void
     */
    public function restore(string|int $id)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        if ($this->Trash->handleRestore($id)) {
            $this->Flash->success(__('The item has been restored.'));
        } else {
            $this->Flash->error(__('The item could not be restored. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param string|integer $id
     * @return void
     */
    public function delete(string|int $id)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        if ($this->Trash->handleDelete($id)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param string|integer $id
     * @return void
     */
    public function hardDelete(string|int $id)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        if ($this->Trash->handleHardDelete($id)) {
            $this->Flash->success(__('The item has been deleted permanently.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'trash']);
    }
}
