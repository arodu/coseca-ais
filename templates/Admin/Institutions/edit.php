<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */

use System\Utility\Lists;

?>
<?php
$this->assign('title', __('Edit Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('View'), 'url' => ['action' => 'view', $institution->id, 'prefix' => 'Admin']],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($institution) ?>
    <div class="card-body">
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('active', ['custom' => true]) ?>
        <?= $this->Form->control('contact_person') ?>
        <?= $this->Form->control('contact_phone') ?>
        <?= $this->Form->control('contact_email') ?>
        <?= $this->Form->control('tenant_id', ['options' => $tenants]) ?>
        <?= $this->DependentSelector->control('state_id', [
            'options' => Lists::states(),
            'data-target' => '#municipality-select',
        ]) ?>
        <?= $this->DependentSelector->control('municipality_id', [
            'id' => 'municipality-select',
            'options' => $institution->state_id ? Lists::municipalities($institution->state_id) : [],
            'data-target' => '#parish-select',
            'data-url' => $this->Url->build(['plugin' => 'System', 'controller' => 'Lists', 'action' => 'municipalities', 'prefix' => false]),
        ]) ?>
        <?= $this->DependentSelector->control('parish_id', [
            'id' => 'parish-select',
            'options' => $institution->municipality_id ? Lists::parishes($institution->municipality_id) : [],
            'data-url' => $this->Url->build(['plugin' => 'System', 'controller' => 'Lists', 'action' => 'parishes', 'prefix' => false]),
        ]) ?>
    </div>
    <div class="card-footer d-flex">
        <div>
            <?= $this->Button->save() ?>
        </div>
        <div class="ml-auto">
            <?= $this->Button->cancel(['url' => ['action' => 'view', $institution->id, 'prefix' => 'Admin']]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?= $this->DependentSelector->script() ?>