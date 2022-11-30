<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\StatusDate;
use Cake\ORM\Entity;

/**
 * LapseDate Entity
 *
 * @property int $id
 * @property int $lapse_id
 * @property string $title
 * @property string $code
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 *
 * @property \App\Model\Entity\Lapse $lapse
 */
class LapseDate extends Entity
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
        'lapse_id' => true,
        'title' => true,
        'stage' => true,
        'start_date' => true,
        'end_date' => true,
        'lapse' => true,
        'is_single_date' => true,
    ];

    protected function _getShowDates()
    {
        if ($this->is_single_date) {
            return $this->start_date;
        }
        
        if (!empty($this->start_date) && !empty($this->end_date)) {
            return __('{0} al {1}', $this->start_date, $this->end_date);
        }

        return null;
    }

    protected $_virtual = [
        'status',
    ];

    /**
     * @return StatusDate|null
     */
    protected function _getStatus(): ?StatusDate
    {
        return StatusDate::get($this->start_date, $this->end_date);
    }

}
