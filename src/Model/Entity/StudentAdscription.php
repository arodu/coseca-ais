<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\AdscriptionPrincipal;
use App\Model\Field\AdscriptionStatus;
use Cake\ORM\Entity;

/**
 * StudentAdscription Entity
 *
 * @property int $id
 * @property int $student_id
 * @property int $institution_project_id
 * @property int $lapse_id
 * @property int $tutor_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\InstitutionProject $institution_project
 * @property \App\Model\Entity\Lapse $lapse
 * @property \App\Model\Entity\Tutor $tutor
 */
class StudentAdscription extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'student_id' => true,
        'institution_project_id' => true,
        'tutor_id' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'institution_project' => true,
        'tutor' => true,
        'status' => true,
        'principal' => true,
    ];
    
    protected $_virtual = [
        'label_status',
    ];

    /**
     * @return AdscriptionStatus|null
     */
    public function getStatus(): ?AdscriptionStatus
    {
        return AdscriptionStatus::tryFrom($this->status ?? '');
    }

    protected function _getLabelStatus(): string
    {
        return $this->getStatus()?->label() ?? '';
    }

    /**
     * @return AdscriptionPrincipal|null
     */
    public function getPrincipal(): ?AdscriptionPrincipal
    {
        return AdscriptionPrincipal::get($this->principal ?? false);
    }
}
