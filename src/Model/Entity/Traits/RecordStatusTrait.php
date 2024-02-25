<?php
declare(strict_types=1);

namespace App\Model\Entity\Traits;

use App\Enum\RecordStatus;

trait RecordStatusTrait
{
    /**
     * Returns the record status for the entity.
     *
     * @param array $options Additional options for retrieving the record status.
     * @return RecordStatus The record status object.
     */
    public function recordStatus(array $options = []): RecordStatus
    {
        return RecordStatus::get($this, $options);
    }
}