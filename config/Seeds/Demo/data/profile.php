<?php

declare(strict_types=1);

/**
 * Huella congelada del dataset real (`coseca_prod`, minado el 2026-10-16) y
 * objetivos del dataset demo.
 *
 * - `huella`: valores observados en producción (solo estadísticas y patrones,
 *   nunca registros ni PII). Sirve de procedencia y de referencia.
 * - `targets`: objetivos del demo a escala reducida (~60 estudiantes). Es
 *   contra esto que `bin/cake demo_validate` compara el dataset generado.
 *
 * Los ratios son proporciones (0..1); los rangos son [min, max].
 */

return [
    'seed' => 20261016,

    /** Escala objetivo del demo. */
    'scale' => [
        'students' => 60,
        'institutions' => 10,
        'tutors' => 10,
        'tenants' => 4,
    ],

    /** Valores medidos en `coseca_prod` (procedencia). */
    'huella' => [
        'tenants' => 7,
        'areas' => 2,
        'programs' => 4,
        'locations' => 6,
        'interest_areas' => 21,
        'lapses' => 26,
        'students' => 832,
        'institutions' => 45,
        'institution_projects' => 99,
        'tutors' => 41,
        'student_adscriptions' => 1042,
        'student_stages' => 4199,
        'student_courses' => 784,
        'student_tracking' => 15864,
        'student_documents' => 96,
        'lapse_dates' => 104,
        'students_per_tenant' => [1 => 522, 2 => 92, 3 => 26, 4 => 102],
        'tutors_per_tenant' => [1 => 20, 2 => 6, 3 => 3, 4 => 3],
        'institutions_per_tenant' => [1 => 28, 2 => 5, 3 => 6, 4 => 1],
        'gender' => ['F' => 164, 'M' => 626],
        'funnel' => [
            'register' => ['success' => 758, 'review' => 33, 'in-progress' => 41],
            'course' => ['success' => 740, 'review' => 17],
            'adscription' => ['success' => 725, 'waiting' => 9, 'in-progress' => 22],
            'tracking' => ['success' => 562, 'in-progress' => 132, 'review' => 36],
            'results' => ['success' => 562],
            'ending' => ['waiting' => 534, 'success' => 28],
        ],
        'adscription_status' => [
            'closed' => 813,
            'open' => 134,
            'cancelled' => 77,
            'pending' => 18,
        ],
        'email_domains' => ['gmail.com' => 729, 'hotmail.com' => 22, 'unerg.edu.ve' => 2],
        'dni' => ['min' => 20000000, 'max' => 33708425],
        'phone_length' => ['min' => 10, 'max' => 12],
        'tracking_description_length' => ['min' => 4, 'max' => 255, 'mean' => 84],
        'total_hours' => ['min' => 0, 'max' => 185, 'mean' => 89],
    ],

    /** Objetivos del demo (escala reducida). */
    'targets' => [
        // Reparto suavizado de los 60 estudiantes entre los 4 tenants activos.
        'students_per_tenant' => [1 => 30, 2 => 12, 3 => 6, 4 => 12],
        'institutions_per_tenant' => [1 => 6, 2 => 2, 3 => 1, 4 => 1],
        'tutors_per_tenant' => [1 => 6, 2 => 2, 3 => 1, 4 => 1],

        // student_data
        'gender_ratio' => ['F' => 0.22, 'M' => 0.78],
        'semester' => [
            'min' => 4,
            'max' => 10,
            'weights' => [4 => 0.05, 5 => 0.01, 6 => 0.30, 7 => 0.31, 8 => 0.16, 9 => 0.08, 10 => 0.09],
        ],
        'uc' => ['min' => 1, 'max' => 208, 'mean' => 123],
        'student_with_interest_area_ratio' => 1.0,

        // institution_projects
        'projects_per_institution' => ['min' => 1, 'max' => 4],
        'projects_with_interest_area_ratio' => 0.91,

        // student_adscriptions (demo: una única adscripción por estudiante)
        'adscriptions_per_student' => ['min' => 1, 'max' => 1, 'mean' => 1.0],
        'adscription_status_ratio' => [
            'closed' => 0.78,
            'open' => 0.13,
            'cancelled' => 0.07,
            'pending' => 0.02,
        ],

        // student_courses
        'courses_per_student' => ['min' => 1, 'max' => 3, 'mean' => 1.04],
        'course_exonerated_ratio' => 0.01,

        // student_tracking
        'tracking_hours' => ['min' => 0.25, 'max' => 12, 'mean' => 4.66, 'step' => 0.25],
        'tracking_per_adscription' => ['min' => 1, 'max' => 25, 'mean' => 8],
        'tracking_description_length' => ['min' => 40, 'max' => 180, 'mean' => 84],

        // Funnel del demo: se detiene en Seguimiento `in-progress`. No hay
        // Resultados ni Conclusión para no activar las planillas 007/008 sin el
        // seguimiento al 100% (regla de negocio; ver docs/proceso-servicio-comunitario.md).
        'funnel' => [
            'register' => ['success' => 0.91, 'review' => 0.04, 'in-progress' => 0.05],
            'course' => ['success' => 0.89, 'review' => 0.02],
            'adscription' => ['success' => 0.87, 'waiting' => 0.01, 'in-progress' => 0.03],
            'tracking' => ['success' => 0.00, 'in-progress' => 0.87],
            'results' => ['success' => 0.00],
            'ending' => ['waiting' => 0.00, 'success' => 0.00],
        ],

        // student_documents
        'document' => ['type' => 'adscription_project', 'model' => 'StudentAdscriptions'],

        // contactos
        'email_domain_ratio' => ['gmail.com' => 0.97, 'hotmail.com' => 0.02, 'unerg.edu.ve' => 0.01],

        // tolerancia del validador
        'tolerance' => 0.15,
    ],
];
