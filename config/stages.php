<?php

use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;

return [

    'Stages' => [
        StageField::REGISTER->value => [
            'label' => __('Registro'),
            'status' => StageStatus::IN_PROGRESS,
            'statutes' => [
                'open' => StageStatus::IN_PROGRESS,
                'close' => StageStatus::REVIEW,
            ],
        ],
        StageField::COURSE->value => [
            'label' => __('Taller'),
            'status' => StageStatus::WAITING,
            'statutes' => [
                'open' => StageStatus::WAITING,
                'close' => StageStatus::SUCCESS,
            ],
        ],
        StageField::ADSCRIPTION->value => [
            'label' => __('Adscripción'),
            'status' => StageStatus::WAITING,
            'statutes' => [
                'open' => StageStatus::WAITING,
                'close' => StageStatus::SUCCESS,
            ],
        ],
        StageField::TRACKING->value => [
            'label' => __('Seguimiento'),
            'status' => StageStatus::IN_PROGRESS,
            'statutes' => [
                'open' => StageStatus::IN_PROGRESS,
                'close' => StageStatus::REVIEW,
            ],
        ],
        StageField::RESULTS->value => [
            'label' => __('Resultados'),
            'status' => StageStatus::IN_PROGRESS,
            'statutes' => [
                'open' => StageStatus::IN_PROGRESS,
                'close' => StageStatus::REVIEW,
            ],
        ],
        StageField::ENDING->value => [
            'label' => __('Conclusión'),
            'status' => StageStatus::WAITING,
            'statutes' => [
                'open' => StageStatus::WAITING,
                'close' => StageStatus::REVIEW,
            ],
        ],
        StageField::VALIDATION->value => [
            'label' => __('Convalidación'),
            'status' => StageStatus::WAITING,
            'statutes' => [
                'open' => StageStatus::WAITING,
                'close' => StageStatus::REVIEW,
            ],
        ],
    ],

    'StageGroups' => [
        StudentType::REGULAR->value => [
            StageField::REGISTER,
            StageField::COURSE,
            StageField::ADSCRIPTION,
            StageField::TRACKING,
            StageField::RESULTS,
            StageField::ENDING,
        ],
        StudentType::VALIDATED->value => [
            StageField::REGISTER,
            StageField::VALIDATION,
        ],
        StudentType::HISTORY->value => [
            StageField::REGISTER,
            StageField::VALIDATION
        ],
    ],
];
