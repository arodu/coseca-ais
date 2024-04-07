<?php
/**
 * @var \App\View\AppView $this
 */
?>
<table class="title-header">
    <tr>
        <td class="logo">
            <?= $this->Html->image('logo-unerg.jpg', ['fullBase' => true]); ?>
        </td>
        <td class="text-center">
            <?= __('REPÚBLICA BOLIVARIANA DE VENEZUELA') ?><br>
            <?= __('MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA, CIENCIA Y TECNOLOGÍA') ?><br>
            <?= __('UNIVERSIDAD NACIONAL EXPERIMENTAL “RÓMULO GALLEGOS”') ?><br>
            <?php if ($this?->program?->area?->print_label) : ?>
                <?= strtoupper($this?->program?->area?->print_label) ?><br>
            <?php endif; ?>
            <?= __('COORDINACIÓN SERVICIO COMUNITARIO (COSECA)') ?><br>
        </td>
        <td class="logo">
            <?php if ($this?->program?->area?->logo) : ?>
                <?= $this->Html->image($this?->program?->area?->logo, ['fullBase' => true]); ?>
            <?php endif; ?>
        </td>
    </tr>
</table>