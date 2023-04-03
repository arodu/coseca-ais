<?php

declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Filters cell
 */
class FiltersCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->Students = $this->fetchTable('Students');
    }

    public function admin_students(bool $isFiltered = false, string $filterKey = 'f')
    {
        $tenants = $this->Students->Tenants->find('list');
        $lapses = $this->Students->Lapses->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ]);

        $this->set(compact('tenants', 'lapses'));
        $this->set(compact('isFiltered', 'filterKey'));
    }

    public function admin_programs(bool $isFiltered = false, string $filterKey = 'f')
    {

        $this->set(compact('isFiltered', 'filterKey'));
    }

    public function admin_institutions(bool $isFiltered = false, string $filterKey = 'f')
    {

        $this->set(compact('isFiltered', 'filterKey'));
    }

    public function admin_tutors(bool $isFiltered = false, string $filterKey = 'f')
    {

        $this->set(compact('isFiltered', 'filterKey'));
    }
}
