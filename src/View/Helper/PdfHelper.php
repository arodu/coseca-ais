<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

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
    protected array $_defaultConfig = [
        'headerHeight' => 0,
        'footerHeight' => 0,

        'header' => 'Documents/pdfHeader',
        'footer' => 'Documents/pdfFooter',
    ];

    /**
     * @return int
     */
    public function getMarginTopBase(): int
    {
        return 170 + $this->getConfig('headerHeight');
    }

    /**
     * @return int
     */
    public function getHeaderTopBase(): int
    {
        return -130 - $this->getConfig('headerHeight');
    }

    /**
     * @return int
     */
    public function getMarginBottonBase(): int
    {
        return 50 + $this->getConfig('footerHeight');
    }

    /**
     * @return int
     */
    public function getFooterBottomBase(): int
    {
        return -0 - $this->getConfig('footerHeight');
    }

    /**
     * @return string
     */
    public function pageBreak(): string
    {
        return '<div style="page-break-after: always;"></div>';
    }

    /**
     * @param int $i
     * @param int $total
     * @return string
     */
    public function conditionalPageBreak(int $i, int $total): string
    {
        if ($i === $total) {
            return '';
        }

        return $this->pageBreak();
    }
}
