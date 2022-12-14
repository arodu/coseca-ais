<?php

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;

return [

    'Stages' => [
        StageField::REGISTER->value => [
            'label' => __('Registro'),
            'status' => StageStatus::IN_PROGRESS,
        ],
        StageField::COURSE->value => [
            'label' => __('Taller'),
            'status' => StageStatus::WAITING,
        ],
        StageField::ADSCRIPTION->value => [
            'label' => __('Adscripción'),
            'status' => StageStatus::WAITING,
        ],
        StageField::TRACKING->value => [
            'label' => __('Seguimiento'),
            'status' => StageStatus::IN_PROGRESS,
        ],
        StageField::ENDING->value => [
            'label' => __('Conclusión'),
            'status' => StageStatus::WAITING,
        ],
        StageField::VALIDATION->value => [
            'label' => __('Convalidación'),
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
