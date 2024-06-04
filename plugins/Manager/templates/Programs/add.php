<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $program
 */

use App\Model\Field\ProgramRegime;

?>
<?php
$this->assign('title', __('Add Program'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Programs'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($program, ['valueSources' => ['data', 'query', 'context']]) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('area_id', ['options' => $areas, 'empty' => true, 'required' => true]);
        echo $this->Form->control('name');
        echo $this->Form->control('regime', ['options' => ProgramRegime::toListLabel(), 'empty' => true, 'required' => true]);
        echo $this->Form->control('abbr');
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), $redirect ?? ['action' => 'index'], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>