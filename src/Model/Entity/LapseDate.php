<?php
declare(strict_types=1);

namespace App\Model\Entity;

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
    ];
}
