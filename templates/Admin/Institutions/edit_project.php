<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstitutionProject $institutionProject
 */
?>
<?php
$this->assign('title', __('Editar Proyecto'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Instituciones'), 'url' => ['action' => 'index']],
    ['title' => h($institution->name), 'url' => ['action' => 'view', $institution->id]],
    ['title' => __('Editar Proyecto')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($institutionProject) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('institution', ['value' => $institution->name, 'readonly' => true]);
        echo $this->Form->control('name');
        echo $this->Form->control('interest_area_id', ['options' => $interestAreas, 'empty' => true]);
        echo $this->Form->control('active', ['custom' => true]);
        ?>
    </div>
    <div class="card-footer d-flex">
        <div>
            <?= $this->AppForm->buttonSave() ?>
        </div>
        <div class="ml-auto">
            <?= $this->AppForm->buttonCancel(['url' => ['action' => 'view', $institutionProject->id]]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>