<?php

declare(strict_types=1);

namespace App\Stage;

use App\Model\Field\StageStatus;

class AdscriptionStage implements StageInterface
{
    use StageTrait;

    public function initialize(): void
    {
        $this->Adscriptions = $this->fetchTable('Adscriptions');
    }

    public function close(StageStatus $stageStatus)
    {
    }

    public function adscriptionList(): ?array
    {
        return $this->Adscriptions->find()
            ->where(['Adscriptions.student_id' => $this->getStudentId()])
            ->contain([
                'Projects' => ['Institutions'],
                'Lapses',
                'Tutors',
            ])
            ->toArray();
    }
}
