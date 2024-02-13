<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Program $program
 */

use App\Enum\ActionColor;

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
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'editProgram', $program->id], ['class' => ActionColor::EDIT->btn()]) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Button->cancel(['label' => __('Volver'), 'url' => ['action' => 'index']]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="related related-tenants view card">
            <div class="card-header d-flex">
                <h3 class="card-title"><?= __('Sedes') ?></h3>
                <div class="ml-auto">
                    <?= $this->Html->link(__('Nueva sede'), ['controller' => 'Tenants', 'action' => 'add', '?' => ['program_id' => $program->id]], ['class' => ActionColor::ADD->btn('btn-sm')]) ?>
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
                                <td><?= $this->App->yn($tenants->active) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Tenants', 'action' => 'view', $tenants->id], ['class' => ActionColor::VIEW->btn('btn-xs', true)]) ?>
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
                    <?= $this->Html->link(__('Nueva Area de Interes'), ['controller' => 'Tenants', 'action' => 'addInterestArea', $program->id], ['class' => ActionColor::ADD->btn('btn-sm')]) ?>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($program->interest_areas)) : ?>
                            <tr>
                                <td colspan="6" class="text-muted">
                                    Tenants record not found!
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($program->interest_areas as $interestArea) : ?>
                                <tr>
                                    <td><?= h($interestArea->name) ?></td>
                                    <td><?= $this->App->yn($interestArea->active) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Tenants', 'action' => 'editInterestArea', $interestArea->id], ['class' => ActionColor::EDIT->btn('btn-xs', true)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>