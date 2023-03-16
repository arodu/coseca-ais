<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Program $program
 */
?>

<?php
$this->assign('title', h($program->name));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['action' => 'index']],
    ['title' => h($program->name)],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($program->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Area') ?></th>
                <td><?= h($program->area_label) ?></td>
            </tr>
            <tr>
                <th><?= __('Regime') ?></th>
                <td><?= h($program->regime_label) ?></td>
            </tr>
            <tr>
                <th><?= __('Abbr') ?></th>
                <td><?= h($program->abbr) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="">
            <?php /*$this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $program->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $program->id), 'class' => 'btn btn-danger']
      )*/ ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Editar'), ['action' => 'editProgram', $program->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="related related-tenants view card">
            <div class="card-header d-flex">
                <h3 class="card-title"><?= __('Sedes') ?></h3>
                <div class="ml-auto">
                    <?php // $this->Html->link(__('New'), ['controller' => 'Tenants' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) 
                    ?>
                    <?php // $this->Html->link(__('List '), ['controller' => 'Tenants' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) 
                    ?>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Abbr') ?></th>
                        <th><?= __('Active') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php if (empty($program->tenants)) { ?>
                        <tr>
                            <td colspan="6" class="text-muted">
                                Tenants record not found!
                            </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($program->tenants as $tenants) : ?>
                            <tr>
                                <td><?= h($tenants->name) ?></td>
                                <td><?= h($tenants->abbr) ?></td>
                                <td><?= $tenants->active ? __('Si') : __('No') ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Tenants', 'action' => 'view', $tenants->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="related related-interest-areas view card">
            <div class="card-header d-flex">
                <h3 class="card-title"><?= __('Areas de Interes') ?></h3>
                <div class="ml-auto">
                    <?= $this->Html->link(__('Nueva Area de Interes'), ['controller' => 'Tenants' , 'action' => 'addInterestArea', $program->id], ['class' => 'btn btn-primary btn-sm']) ?>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Active') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php if (empty($program->interest_areas)) { ?>
                        <tr>
                            <td colspan="6" class="text-muted">
                                Tenants record not found!
                            </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($program->interest_areas as $interestArea) : ?>
                            <tr>
                                <td><?= h($interestArea->name) ?></td>
                                <td><?= $tenants->active ? __('Si') : __('No') ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tenants', 'action' => 'editInterestArea', $interestArea->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
