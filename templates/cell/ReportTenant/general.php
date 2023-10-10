<div class="row">
    <div class="col-6">
        <table class="table table-sm table-hover">
            <tbody>
                <tr>
                    <th><?= __('cantidad de estudiantes - registro: sin lapso') ?></th>
                    <td><?= $studentWithoutLapse->count() ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - registro: en revision') ?></th>
                    <td><?= $reports['register-review'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - registro: completado') ?></th>
                    <td><?= $reports['register-success'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - taller: en espera') ?></th>
                    <td><?= $reports['course-waiting'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - taller: completado') ?></th>
                    <td><?= $reports['course-success'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - adscripcion: en espera') ?></th>
                    <td><?= $reports['adscription-waiting'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= __('cantidad de estudiantes - adscripcion: completado') ?></th>
                    <td><?= $reports['adscription-success'] ?? 0 ?></td>
                </tr>

                <tr>
                    <th><?= __('cantidad de estudiantes - seguimiento: en proceso') ?></th>
                    <td><?= $reports['tracking-in-progress'] ?? 0 ?></td>
                </tr>

                <tr>
                    <th><?= __('cantidad de estudiantes - seguimiento: completado') ?></th>
                    <td><?= $reports['tracking-success'] ?? 0 ?></td>
                </tr>

                <tr>
                    <th><?= __('cantidad de estudiantes - resultados: completado') ?></th>
                    <td><?= $reports['results-success'] ?? 0 ?></td>
                </tr>

                <tr>
                    <th><?= __('cantidad de estudiantes - conclusion: en espera') ?></th>
                    <td><?= $reports['ending-waiting'] ?? 0 ?></td>
                </tr>

                <tr>
                    <th><?= __('cantidad de estudiantes - conclusion: completado') ?></th>
                    <td><?= $reports['ending-success'] ?? 0 ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

