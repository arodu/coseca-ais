<div class="row">
    <div class="col-sm border-right">
        <div class="description-block">
            <h5 class="tracking-count description-header"><?= $trackingInfo['trackingCount'] ?? $this->App->nan() ?></h5>
            <span><?= __('Cantidad de actividades') ?></span>
        </div>
    </div>
    <div class="col-sm border-right">
        <div class="description-block">
            <h5 class="tracking-first-date description-header"><?= $trackingInfo['trackingFirstDate'] ?? $this->App->nan() ?></h5>
            <span><?= __('Primera actividad') ?></span>
        </div>
    </div>
    <div class="col-sm border-right">
        <div class="description-block">
            <h5 class="tracking-last-date description-header"><?= $trackingInfo['trackingLastDate'] ?? $this->App->nan() ?></h5>
            <span><?= __('Ultima actividad') ?></span>
        </div>
    </div>
    <div class="col-sm">
        <div class="description-block">
            <h5 class="total-hours description-header"><?= $trackingInfo['totalHours'] ?? $this->App->nan() ?></h5>
            <span><?= __('Horas completadas') ?></span>
        </div>
    </div>
</div>