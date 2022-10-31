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
        ],
        Stages::STAGE_COURSE => [
            Stages::DATA_LABEL => __('Curso de Servicio Comunitario'),
            Stages::DATA_CLASS => CourseStage::class,
        ],
        Stages::STAGE_ENDING => [
            Stages::DATA_LABEL => __('Finalización'),
            Stages::DATA_CLASS => EndingStage::class,
        ],
    ]
];
