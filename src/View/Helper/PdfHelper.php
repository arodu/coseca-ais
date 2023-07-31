<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Pdf helper
 */
class PdfHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'headerHeight' => 0,
        'footerHeight' => 0,
    ];

    public function getMarginTopBase(): int
    {
        return 170 + $this->getConfig('headerHeight');
    }

    public function getHeaderTopBase(): int
    {
        return -130 - $this->getConfig('headerHeight');
    }

    public function getMarginBottonBase(): int
    {
        return 50 + $this->getConfig('footerHeight');
    }

    public function getFooterBottomBase(): int
    {
        return -0 - $this->getConfig('footerHeight');
    }
}
