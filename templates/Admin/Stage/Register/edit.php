<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
use App\Enum\Gender;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Students;

$this->student_id = $student->id;
$this->active = null;
$this->extend('/Admin/Common/view_student');
$stageField = StageField::REGISTER;

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id, 'prefix' => 'Admin']],
    ['title' => $stageField->label()],
    ['title' => __('Editar')],
]);
?>

<?= $this->Form->create($student) ?>
<div class="card-header">
    <div class="card-title"><?= $stageField->label() ?></div>
</div>
<div class="card-body">
    <?= $this->element('form/register', ['student' => $student]) ?>
</div>

<div class="card-footer d-flex">
    <div>
        <?= $this->AppForm->buttonSave() ?>
        <?= $this->AppForm->buttonValidate(['confirm' => __('Seguro que desea validar este registro?')]) ?>
    </div>
    <div class="ml-auto">
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Students', 'action' => 'view', $student->id, 'prefix' => 'Admin'], ['class' => ActionColor::CANCEL->btn()]) ?>
    </div>
</div>
<?= $this->Form->end() ?>