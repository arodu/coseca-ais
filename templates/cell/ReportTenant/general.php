<div class="row">
    <div class="col-6">
        <table class="table table-sm table-hover">
            <tbody>
                <tr>
                    <th><?= __('Estudiantes registrados') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Aprobados taller') ?></th>
                    <td><?= $approvedCourse->count() ?></td>
                </tr>
                <tr>
                    <th><?= __('Proyectos activos') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Actividades registradas') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Horas registradas') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudiantes seguimiento iniciado') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudiantes seguimiento finalizado') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudiantes con servicio aprobado') ?></th>
                    <td><?= $this->App->nan() ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

