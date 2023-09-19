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

        'header' => 'Documents/pdfHeader',
        'footer' => 'Documents/pdfFooter',
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

    public function pageBreak(): string
    {
        return '<div style="page-break-after: always;"></div>';
    }

    public function conditionalPageBreak(int $i, int $total): string
    {
        if ($i === $total) {
            return '';
        }

        return $this->pageBreak();
    }
}
