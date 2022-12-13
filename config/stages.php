<?php

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Stage\AdscriptionStage;
use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;
use App\Stage\TrackingStage;

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
            'class' => AdscriptionStage::class,
            'status' => StageStatus::WAITING,
        ],
        StageField::TRACKING->value => [
            'label' => __('Seguimiento'),
            'class' => TrackingStage::class,
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
    ],

    'StageGroups' => [
        StudentType::REGULAR->value => [
            StageField::REGISTER,
            StageField::COURSE,
            StageField::ADSCRIPTION,
            StageField::TRACKING,
            StageField::ENDING,
        ],
        StudentType::VALIDATED->value => [
            StageField::REGISTER,
            StageField::VALIDATION,
        ],
    ],

];
