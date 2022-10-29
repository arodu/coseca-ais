<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Field\Stages;
use Cake\View\Helper;
use Cake\View\View;

/**
 * App helper
 */
class AppHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];


    public function statusIcon($status = null)
    {
        switch ($status) {
            case Stages::STATUS_IN_PROGRESS: 
                return 'fas fa-cogs';
                break;
            case Stages::STATUS_WAITING: 
                return 'fas fa-pause-circle';
                break;
            case Stages::STATUS_SUCCESS: 
                return 'fas fa-check';
                break;
            case Stages::STATUS_PENDING:
            default:
                return 'fas fa-lock';
                break;
        }
    }

    public function statusColor($status = null)
    {
        switch ($status) {
            case Stages::STATUS_IN_PROGRESS: 
                return 'warning';
                break;
            case Stages::STATUS_WAITING: 
                return 'info';
                break;
            case Stages::STATUS_SUCCESS: 
                return 'success';
                break;
            case Stages::STATUS_FAIL:
                return 'danger';
                break;
            case Stages::STATUS_PENDING:
            default:
                return 'gray';
                break;
        }
    }

    public function statusShow($status = null)
    {
        switch($status) {
            case Stages::STATUS_IN_PROGRESS:
            case Stages::STATUS_WAITING:
                return 'show';
                break;

            default:
                return '';
                break;
        }
    }
}
