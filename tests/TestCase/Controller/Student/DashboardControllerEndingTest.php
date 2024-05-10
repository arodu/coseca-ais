<?php

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\StudentAdscriptionFactory;
use App\Test\Factory\StudentStageFactory;
use App\Utility\Stages;

class DashboardControllerEndingTest extends StudentTestCase{

    //WAITING => __('En espera'),
    //IN_PROGRESS => __('En proceso'),
    //REVIEW => __('En revisión'),
    //SUCCESS => __('Realizado'),
    //FAILED => __('Fallido'),
    //LOCKED => __('Bloqueado'),

    //if status is 'En espera' without PrincipalAdscription
    public function testEndingCardStatusWaiting(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);

        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::WAITING->value,
        ])->persist();
        
        $label = $stage->get('stage');

        //!$student->hasPrincipalAdscription()

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($label);
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Ha ocurrido un problema en la consolidación de los documentos');
        $this->assertResponseNotContains('Sin información a mostrar');
    }

    public function testEndingCardStatusWaitingWithAdscription(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);

        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::WAITING->value,
        ])->persist();
        
        //  $student_adscriptions = StudentAdscriptionFactory::make([
        //      'student_id' => $student->id,
        //      'institution_project_id' => 1,
        //      'tutor_id' => 1,
        //      'status' => StageStatus::SUCCESS->value,
        //  ])->persist();
     
        $label = $stage->get('stage');        
            
        // $message = 'Estimado Prestador de Servicio Comunitario, estamos complacidos de';

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($label);
        $this->assertResponseContains('collapse-' . $label);
            
       // $this->assertResponseContains($message);
        
    }

    //if status is 'Realizado'
    public function testEndingCardStatusSuccess(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
      
        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::SUCCESS->value,
        ])->persist();

        $label = $stage->get('stage');

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }


    //if status is 'En revision'
    public function testEndingCardStatusReview(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
       
        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::REVIEW->value,
        ])->persist();

        $label = $stage->get('stage');

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }

    //if status is 'En Proceso'
    public function testEndingCardStatusInProgress(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
       
        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ])->persist();


        

        $label = $stage->get('stage');

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }

    //if status is 'Fallido'
    public function testEndingCardStatusFailed(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
      
        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::FAILED->value,
        ])->persist();

        $label = $stage->get('stage');

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }

    //if status is 'En Proceso'
    public function testEndingCardStatusLocked(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
      
        $stage = StudentStageFactory::make([
            'student_id' => $student->id,
            'stage' => StageField::ENDING->value,
            'status' => StageStatus::LOCKED->value,
        ])->persist();

        $label = $stage->get('stage');

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('collapse-' . $label);
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }
}