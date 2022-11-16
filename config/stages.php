<?php

use App\Enum\StageField;
use App\Enum\StageStatus;
use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;

return [
    'Stages' => [
        StageField::REGISTER->value => [
            'label' => __('Registro'),
            'class' => RegisterStage::class,
            'status' => StageStatus::IN_PROGRESS,
        ],
        StageField::COURSE->value => [
            'label' => __('Taller'),
            'class' => CourseStage::class,
            'status' => StageStatus::WAITING,
        ],
        StageField::ADSCRIPTION->value => [
            'label' => __('Adscripción'),
            'class' => CourseStage::class,
            'status' => StageStatus::WAITING,
        ],
        StageField::TRACKING->value => [
            'label' => __('Seguimiento'),
            'class' => CourseStage::class,
            'status' => StageStatus::IN_PROGRESS,
        ],
        StageField::ENDING->value => [
            'label' => __('Conclusión'),
            'class' => EndingStage::class,
            'status' => StageStatus::WAITING,
        ],
        StageField::VALIDATION->value => [
            'label' => __('Convalidación'),
            'class' => ValidationStage::class,
            'status' => StageStatus::WAITING,
        ],
    ]
];
