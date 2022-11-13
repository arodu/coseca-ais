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
            Stages::DATA_LABEL => __('Taller'),
            Stages::DATA_CLASS => CourseStage::class,
            Stages::DATA_STATUS => Stages::STATUS_WAITING
        ],
        Stages::STAGE_ADSCRIPTION => [
            Stages::DATA_LABEL => __('Adscripción'),
            Stages::DATA_CLASS => CourseStage::class,
            Stages::DATA_STATUS => Stages::STATUS_WAITING,
        ],
        Stages::STAGE_TRACKING => [
            Stages::DATA_LABEL => __('Seguimiento'),
            Stages::DATA_CLASS => CourseStage::class,
            Stages::DATA_STATUS => Stages::STATUS_IN_PROGRESS,
        ],
        Stages::STAGE_ENDING => [
            Stages::DATA_LABEL => __('Conclusión'),
            Stages::DATA_CLASS => EndingStage::class,
            Stages::DATA_STATUS => Stages::STATUS_WAITING,
        ],
        Stages::STAGE_VALIDATION => [
            Stages::DATA_LABEL => __('Convalidación'),
            Stages::DATA_CLASS => ValidationStage::class,
            Stages::DATA_STATUS => Stages::STATUS_WAITING,
        ],
    ]
];
