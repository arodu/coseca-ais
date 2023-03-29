<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentAdscription $student_adscription
 */

use App\Enum\ActionColor;

$this->student_id = $student->id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['_name' => 'admin:student_view', $student->id]],
    ['title' => __('Agregar Proyecto')],
]);
?>


<?= $this->Form->create($student_adscription) ?>
<div class="card-header">
    <div class="card-title"><?= __('Agregar Proyecto') ?></div>
</div>
<div class="card-body">
    <?php
    echo $this->Form->hidden('student_id', ['value' => $student->id]);
    echo $this->Form->control('institution_project_id', ['options' => $institution_projects, 'empty' => true]);
    echo $this->Form->control('tutor_id', ['options' => $tutors, 'empty' => true]);
    ?>
</div>

<div class="card-footer d-flex">
    <div>
        <?= $this->AppForm->buttonSave() ?>
    </div>
    <div class="ml-auto">
        <?= $this->Html->link(__('Cancelar'), ['_name' => 'admin:student_view', $student->id], ['class' => ActionColor::CANCEL->btn()]) ?>
    </div>
</div>

<?= $this->Form->end() ?>
