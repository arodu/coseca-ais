<?php $this->footerHeight = 200; ?>

<table>
    <tr>
        <th>
            _____________________
        </th>
        <th>
            _____________________
        </th>
        <th>
            _____________________
        </th>
    </tr>
    <tr>
        <th>
            <?= __('TUTOR(A) ACADÉMICO(A)') ?>
        </th>
        <th>
            <?= __('DECANO(A)') ?>
        </th>
        <th>
            <?= __('COORDINADOR(A) COSECA {0}', strtoupper($this->program->area->abbr)) ?>
        </th>
    </tr>
</table>