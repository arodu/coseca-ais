    <div>
        <?php
        $color = $studentStages->getStatus()->color();
        $icon = $studentStages->getStatus()->icon();
        echo $icon->render($color->cssClass('bg', false));
        ?>
        <!-- <i class="fas fa-envelope bg-primary"></i> -->
        <div class="timeline-item">
            <span class="time"><i class="far fa-clock"></i> <?= $studentStages->modified ?></span>

            <h3 class="timeline-header"><strong><?= $studentStages->stage_label ?></strong> <small> (<?= $studentStages->status_label ?>)</small></h3>

            <div class="timeline-body">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                quora plaxo ideeli hulu weebly balihoo...
            </div>
            <div class="timeline-footer">
                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                <a href="#" class="btn btn-danger btn-sm">Delete</a>
            </div>
        </div>
    </div>