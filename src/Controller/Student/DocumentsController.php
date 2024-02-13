<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\DocumentsTrait;
use Cake\Http\Response;

/**
 * StudentDocuments Controller
 *
 * @property \App\Model\Table\StudentDocumentsTable $StudentDocuments
 * @method \App\Model\Entity\StudentDocument[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppStudentController
{
    use DocumentsTrait {
        format007 as protected traitFormat007;
        format009 as protected traitFormat009;
    }

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function format007(): Response|null|null
    {
        $this->traitFormat007((string)$this->getCurrentStudent()->id);
    }

    /**
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function format009(): Response|null|null
    {
        $this->traitFormat009((string)$this->getCurrentStudent()->id);
    }
}
