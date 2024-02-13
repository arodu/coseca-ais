<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Traits\DocumentsTrait;

/**
 * StudentDocuments Controller
 *
 * @property \App\Model\Table\StudentDocumentsTable $StudentDocuments
 * @method \App\Model\Entity\StudentDocument[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppAdminController
{
    use DocumentsTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }
}
