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
            <?= strtoupper($this?->program?->area_print_label) ?><br>
            <?= __('COORDINACIÓN SERVICIO COMUNITARIO (COSECA)') ?><br>
        </td>
        <td class="logo">
            <?= $this->Html->image($this?->program?->area_print_logo, ['fullBase' => true]); ?>
        </td>
    </tr>
</table>