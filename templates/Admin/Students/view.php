<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

use App\Model\Field\StageStatus;

?>

<?php
$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => 'List Students', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center"><?= $student->full_name ?></h3>

                <p class="text-muted text-center"><?= h($student->dni) ?></p>


                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Programa</b>
                        <a class="float-right"><?= h($student->tenant->name) ?></a>
                    </li>
                    <li class="list-group-item">
                        <b><?= __('Tipo') ?></b>
                        <a class="float-right"><?= $student->getType()->label() ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>email</b>
                        <a class="float-right"><?= $student->app_user->email ?></a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= __('Etapa Actual') ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Nombre</b>
                        <a class="float-right"><?= h($student->last_stage->stage_label) ?></a>
                    </li>
                    <li class="list-group-item">
                        <b><?= __('Lapso Académico') ?></b>
                        <a class="float-right"><?= $student->last_stage->lapse->name ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Estado</b>
                        <a class="float-right">
                            <?= $this->Html->tag(
                                'span',
                                $student->last_stage->status_label,
                                ['class' => [$student->last_stage->getStatus()->color()->cssClass('badge'), 'ml-2']]
                            ) ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab"><?= __('General') ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="general">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse">
                            <?php foreach ($listStages as $stage) : ?>
                                <?php
                                $studentStage = $studentStages[$stage->value] ?? null;
                                ?>

                                <!-- timeline item -->
                                <?php if (empty($studentStage)) : ?>
                                    <div>
                                        <?= StageStatus::PENDING->icon()->render() ?>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><strong><?= $stage->label() ?></strong></h3>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php
                                    $element = 'admin/general/register';

                                    echo $this->element($element, [
                                        'stage' => $stage,
                                        'studentStages' => $studentStage,
                                    ]);
                                    ?>
                                <?php endif; ?>
                                <!-- END timeline item -->

                                <?php
                                // debug($studentStages);
                                /*
                                    <tr>
                                        <td><?= h($studentStages->id) ?></td>
                                        <td><?= h($studentStages->student_id) ?></td>
                                        <td><?= h($studentStages->stage) ?></td>
                                        <td><?= h($studentStages->lapse_id) ?></td>
                                        <td><?= h($studentStages->status) ?></td>
                                        <td><?= h($studentStages->created) ?></td>
                                        <td><?= h($studentStages->created_by) ?></td>
                                        <td><?= h($studentStages->modified) ?></td>
                                        <td><?= h($studentStages->modified_by) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'StudentStages', 'action' => 'view', $studentStages->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'StudentStages', 'action' => 'edit', $studentStages->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentStages', 'action' => 'delete', $studentStages->id], ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $studentStages->id)]) ?>
                                        </td>
                                    </tr>
                                    */ ?>
                            <?php endforeach; ?>
                            <div>
                                <i class="far fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="timeline">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                    <a href="#">Jonathan Burke Jr.</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                    <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                    </a>
                                </span>
                            </p>

                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                <span class="username">
                                    <a href="#">Sarah Ross</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" placeholder="Response">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                <span class="username">
                                    <a href="#">Adam Jones</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                    <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                    </a>
                                </span>
                            </p>

                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<?php /*

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($student->id) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('App User') ?></th>
                <td><?= $student->has('app_user') ? $this->Html->link($student->app_user->username, ['controller' => 'AppUsers', 'action' => 'view', $student->app_user->id]) : '' ?></td>
            </tr>
            <tr>
                <th><?= __('Dni') ?></th>
                <td><?= h($student->dni) ?></td>
            </tr>
            <tr>
                <th><?= __('Created By') ?></th>
                <td><?= h($student->created_by) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified By') ?></th>
                <td><?= h($student->modified_by) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($student->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($student->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($student->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $student->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $student->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>


<div class="related related-studentStages view card">
    <div class="card-header d-sm-flex">
        <h3 class="card-title"><?= __('Related Student Stages') ?></h3>
        <div class="card-toolbox">
            <?= $this->Html->link(__('New'), ['controller' => 'StudentStages', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Html->link(__('List '), ['controller' => 'StudentStages', 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Student Id') ?></th>
                <th><?= __('Stage') ?></th>
                <th><?= __('Lapse Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Created By') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Modified By') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($student->student_stages)) { ?>
                <tr>
                    <td colspan="10" class="text-muted">
                        Student Stages record not found!
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($student->student_stages as $studentStages) : ?>
                    <tr>
                        <td><?= h($studentStages->id) ?></td>
                        <td><?= h($studentStages->student_id) ?></td>
                        <td><?= h($studentStages->stage) ?></td>
                        <td><?= h($studentStages->lapse_id) ?></td>
                        <td><?= h($studentStages->status) ?></td>
                        <td><?= h($studentStages->created) ?></td>
                        <td><?= h($studentStages->created_by) ?></td>
                        <td><?= h($studentStages->modified) ?></td>
                        <td><?= h($studentStages->modified_by) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'StudentStages', 'action' => 'view', $studentStages->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'StudentStages', 'action' => 'edit', $studentStages->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentStages', 'action' => 'delete', $studentStages->id], ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $studentStages->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </table>
    </div>
</div>

*/
?>

<?php debug($student) ?>