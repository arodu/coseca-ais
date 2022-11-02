<?php

use App\Model\Field\Stages;
use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;

return [
    'Stages' => [
        Stages::STAGE_REGISTER => [
            Stages::DATA_LABEL => __('Registro'),
            Stages::DATA_CLASS => RegisterStage::class,
            Stages::DATA_STATUS => Stages::STATUS_IN_PROGRESS,
        ],
        Stages::STAGE_COURSE => [
            Stages::DATA_LABEL => __('Curso de Servicio Comunitario'),
            Stages::DATA_CLASS => CourseStage::class,
            Stages::DATA_STATUS => Stages::STATUS_PENDING,
        ],
        Stages::STAGE_ENDING => [
            Stages::DATA_LABEL => __('Finalización'),
            Stages::DATA_CLASS => EndingStage::class,
            Stages::DATA_STATUS => Stages::STATUS_PENDING,
        ],
    ]
];
