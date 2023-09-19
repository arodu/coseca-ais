<?php
$this->assign('contentFooter', $this->element('Documents/format007Footer'));
$numItems = count($adscriptions);
$i = 0;
?>
<?php foreach ($adscriptions as $adscription) : ?>
    <?php
    $student = $adscription->student;
    $project = $adscription->institution_project;
    $tutor = $adscription->tutor;
    $institution = $project->institution;
    ?>
    <table border="0">
        <thead>
            <tr>
                <td colspan=4>
                    <table style="width:100%" class="truncate">
                        <tr>
                            <td colspan="3" class="text-right">
                                <strong>MFS-007</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <?= __('Apellidos y Nombres') ?>: <?= __('{0}, {1}', $student->last_name, $student->first_name) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <?= __('Cedula') ?>: <?= h($student->dni) ?>
                            </td>
                            <td>
                                <?= __('Lapso Académico') ?>: <?= h($student->lapse->name) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=3>
                                <?= __('Nombre de la Comunidad/Institución/Dependencia Beneficiaria') ?>: <?= h($institution->name) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=3>
                                <?= __('Título del proyecto') ?>: <?= h($project->name) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= __('Tutor(a) Académico(a)') ?>: <?= h($tutor->name) ?>
                            </td>
                            <td>
                                <?= __('Cedula') ?>: <?= h($tutor->dni) ?>
                            </td>
                            <td>
                                <?= __('Teléfono') ?>: <?= h($tutor->phone) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= __('Tutor(a) Comunitario(a)') ?>: <?= h($institution->contact_person) ?>
                            </td>
                            <td>
                                <?= __('Cedula') ?>: <?= h('') ?>
                            </td>
                            <td>
                                <?= __('Teléfono') ?>: <?= h($institution->contact_phone) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="border-cells">
                <th>#</th>
                <th><?= __('Fecha') ?></th>
                <th><?= __('Actividades realizadas') ?></th>
                <th><?= __('Horas cumplidas') ?></th>
            </tr>
        </thead>
        <tbody class="border-cells">
            <?php
            $tracking = $adscription->student_tracking;
            $num = 1;
            ?>
            <?php foreach ($tracking as $track) : ?>
                <tr>
                    <td class="text-center"><?= h($num) ?></td>
                    <td class="text-center"><?= h($track->date) ?></td>
                    <td><?= h($track->description) ?></td>
                    <td class="text-center"><?= h($track->hours) ?></td>
                </tr>
                <?php $num++; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="3" class="text-right"><?= __('Total horas del proyecto') ?></th>
                <th><?= h($adscription->totalHours) ?></th>
            </tr>
        </tbody>
    </table>

    <?= $this->Pdf->conditionalPageBreak(++$i, $numItems) ?>
<?php endforeach; ?>