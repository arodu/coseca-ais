<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\InstitutionFactory;
use App\Test\Factory\InstitutionProjectFactory;
use App\Test\Factory\InterestAreaFactory;
use App\Test\Factory\ProgramFactory;

use App\Test\TestCase\Controller\Admin\AdminTestCase;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\InstitutionsController Test Case
 *
 * Pruebas para el controlador `InstituionsController`
 *
 * @uses \App\Controller\Admin\InstitutionsController
 */
class InstitutionsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Prueba de funcionalidad para obtener la vista y que en ella existan los datos de Instituciones.
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::index()
     */
    public function testIndex(): void
    {
        // Configuracion inicial
        $this->get('/admin/institutions');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado. // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/institutions'); // Verificar que cargue la ruta con la vista correspondiente
        $this->assertResponseCode(200);

        // Crear una Institucion asociada a un Tenant
        $intitution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        // Verificacion de resultados
        $this->get('/admin/institutions'); // Carga la vista de Institucuones
        $this->assertResponseContains($intitution->name); //Verificar que exista el nombre de la Institucion
        $this->assertResponseContains($intitution->contact_person); //Verificar que exista el contacto de la Institucion
        $this->assertResponseContains($intitution->contact_phone); //Verificar que exista el telefono de la Institucion
        $this->assertResponseContains($intitution->contact_email); //Verificar que exista el email de la Institucion
    }

    /**
     * Prueba de funcionalidad para cargar formulario de registro de una Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::addForm()
     */
    public function testAddForm(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Verificacion de acciones
        $this->get('/admin/institutions/add'); // Verificar que cargue la ruta de agregar nuevo
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para agregar una nueva Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::addPost()
     */
    public function testAddPost(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Verificacion de acciones
        $this->post('/admin/institutions/add', [
            'name' => 'Institución de prueba',
            'contact_person' => 'Persona de prueba',
            'contact_phone' => '04141234567',
            'contact_email' => 'asd@asd.com',
            'tenant_id' => $this->tenant_id,
        ]); // Envio de formulario con datos de pruebas para crear una nueva Institucion

        // Verificacion de resultados
        $this->assertResponseContains('Institución de prueba'); //Verificacion de que existe el nuevo nombre de la Institucion
        $this->assertResponseContains('Persona de prueba');  //Verificacion de que existe el nombre de la persona
        $this->assertResponseContains('04141234567'); //Verificar que existe el numero de la Institucion
        $this->assertResponseContains('asd@asd.com'); //Verificar que exista el email de la Institucion
    }

    /**
     * Prueba de funcionalidad para verificar que cargue la vista detalle de una Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::view()
     */
    public function testView(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Crear una Institucion asociada a un Tenant
        $intitution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/institutions/view/' . $intitution->id); //Verificar que cargue la vista detalle de una Institucion
        $this->assertResponseCode(200);

        // Verificacion de resultados
        $this->assertResponseContains($intitution->contact_person); //Verificar que exista el contacto en la vista
        $this->assertResponseContains($intitution->contact_phone); // Verificar que exista el telefono
        $this->assertResponseContains($intitution->contact_email); //Verificar que exista el telefono
    }

    /**
     * Prueba de funcionalidad para agregar un Proyecto a una Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::addProject()
     */
    public function testAddProject(): void
    {
        // Configuraciones iniciales
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = ProgramFactory::make()->persist(); // Creacion de un Programa
        // Creacion de un Area de interes asociado al programa
        $interes_area = InterestAreaFactory::make([
            'program_id' => $program->id
        ])->persist();

        // Creacion de una Institucion asociada a un Programa/Sede
        $institution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Verificacion de acciones
        $this->post('/admin/institutions/add-project', [
            'name' => 'Agregar a proyecto de prueba',
            'institution_id' => $institution->id,
            'interest_area_id' => $interes_area->id,
        ]); //Envio de formulario con informacion correspondiente

        // Verificacion de resultados
        $this->assertResponseContains('Agregar a proyecto de prueba'); // Verificar el nombre que se ha enviado en el post
    }

    /**
     * Prueba de funcionalidad para editar una Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion incial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creacion de una institucion
        $intitution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/institutions/edit/' . $intitution->id); //Verificar que carga la vista detalle de la Institucion creada
        $this->assertResponseCode(200);

        // Envio del formulario editadondo el registro de la Institucion en cuestion
        $this->post('/admin/institutions/edit/' . $intitution->id, [
            'name' => 'prueba edit',
        ]);
        $this->assertResponseCode(302);

        // Verificacion de resultado
        $this->get('/admin/institutions/view/' . $intitution->id); //Carga de la vista detalle de la Institucion
        $this->assertResponseContains('prueba edit'); //Verificacion del nombre actualizado de la Institucion
        $this->assertResponseNotContains($intitution->name); //Verificacion que no existe el nombre anterior a la actualizacion
    }

    /**
     * Prueba de funcionalidad para editar el Proyecto relacionado a la Institucion
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::editProject()
     */
    public function testEditProject(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = ProgramFactory::make()->persist(); //Creacion de un programa

        // Creacion de un Area de interes realcionado a un Programa
        $interes_area = InterestAreaFactory::make([
            'program_id' => $program->id
        ])->persist();

        // Creacion de una Institucion asociada a un Programa/Sede
        $institution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Creacion de un registro pivote para relacionar la Institucion con el Area de interes
        $institution_project = InstitutionProjectFactory::make([
            'institution_id' => $institution->id,
            'interest_area_id' => $interes_area->id
        ])->persist();

        // Verificacion de que la vista carga la vista con la informacion correspondiente
        $this->get('/admin/institutions/edit-project/' . $institution_project->id);
        $this->assertResponseCode(200);

        // Envio de informacion con el ID del registro que queremos actualizar
        $this->post('/admin/institutions/edit-project/' . $institution_project->id, [
            'name' => 'edit institution project',
        ]);

        // Verificacion de resultados
        $res = $this->getRecord('InstitutionProjects', $institution_project->id); //Verificar que el registro existe en Base de datos
        $this->assertEquals('edit institution project', $res->name); //Verificar que el campo y el valor sea conrrectos
    }

    /**
     * Prueba de funcionalidad de elimar un registro de Instituciones
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::delete()
     */
    public function testDelete(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creacion de una Institucion asociada a un Programa/Sede
        $institution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Envio de formulario con el ID del registro a eliminar
        $this->delete('/admin/intitutions/delete/' . $institution->id);

        // Verificacion de que el registro se elimino correctamente
        $res = $this->getRecordExists('Institutions', $institution->id);
        $this->assertTrue($res);
    }
}
