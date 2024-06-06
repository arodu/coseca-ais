<div class="row">
    <div class="col-lg-3">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
           
        </div>
        <div class="card text-black mb-3" style="max-width: 18rem;">
            <div class="card-header bg-primary"></div>
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('area', ['label' => __('Area')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('programs', ['label' => __('Programas')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('sede', ['label' => __('Sede')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('status', ['label' => __('Estado')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('state', ['label' => __('Fase')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->Form->control('lapse', ['label' => __('Lapso')]) ?>
                        </div>
                    </div>
                       <?= $this->Button->search() ?>
                </div>
                <?= debug($this->getRequest()->getQuery()) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Report</h3><?= $data ?> </div>

        </div>
    </div>