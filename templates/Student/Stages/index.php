<?php
$this->MenuLte->activeItem('home');
$this->assign('title', __('Stages'));
$this->Breadcrumbs->add([
    ['title' => 'Home'],
]);
?>

<div class="row">
    <div id="accordion" class="col-sm-8 offset-sm-2">
        <?php /** @var \App\Model\Entity\Stage $stage */ ?>
        <?php foreach ($stages as $stage) : ?>
            <div class="card card-gray">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="<?= '#collapse-' . $stage->code ?>">
                            <i class="fas fa-lock fa-fw"></i>
                            <?= $stage->name ?>
                        </a>
                    </h4>
                </div>
                <div id="<?= 'collapse-' . $stage->code ?>" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
