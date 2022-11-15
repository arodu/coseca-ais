<?php

use App\Enum\Stage;
use App\Enum\StageStatus;
use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;

return [
    'Stages' => [
        Stage::REGISTER->value => [
            'label' => __('Registro'),
            'class' => RegisterStage::class,
            'status' => StageStatus::IN_PROGRESS,
        ],
        Stage::COURSE->value => [
            'label' => __('Taller'),
            'class' => CourseStage::class,
            'status' => StageStatus::WAITING,
        ],
        Stage::ADSCRIPTION->value => [
            'label' => __('Adscripción'),
            'class' => CourseStage::class,
            'status' => StageStatus::WAITING,
        ],
        Stage::TRACKING->value => [
            'label' => __('Seguimiento'),
            'class' => CourseStage::class,
            'status' => StageStatus::IN_PROGRESS,
        ],
        Stage::ENDING->value => [
            'label' => __('Conclusión'),
            'class' => EndingStage::class,
            'status' => StageStatus::WAITING,
        ],
        Stage::VALIDATION->value => [
            'label' => __('Convalidación'),
            'class' => ValidationStage::class,
            'status' => StageStatus::WAITING,
        ],
    ]
];
