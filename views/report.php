<div class="wrap">
    <h2><?php _e( 'Reporte', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <div id="container-report">

        <table class="filter-table form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="list-courses">Entrenamiento:</label>
                </th>
                <td>
                    <select name="list-courses" id="list-courses">
                        <option value="0">-- Seleccione un curso --</option>
						<?php foreach ( $courses as $course ) : ?>
                            <option value="<?php echo $course['course_id'] ?>">
								<?php echo $course['course_name'] ?> - <?php echo $course['created'] ?>
                            </option>
						<?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input class="button button-primary" type="button" id="search-entries" value="Buscar registros">
                    <span class="msg-btn"></span>
                    <div class="loading hide"></div>
                </td>
            </tr>
            </tbody>
        </table>

        <hr>
        <h2 class="title">Resumen Evaluación</h2>
        <table id="table-summary-report" class="table-report">
            <tr>
                <th>Entrenamiento</th>
                <td id="course_name"></td>
            </tr>
            <tr>
                <th>Formador</th>
                <td id="course_author"></td>
            </tr>
            <tr>
                <th id="course_documents">Documentos</th>
                <td></td>
            </tr>

        </table>

        <h2 class="title">Detalle Evaluación</h2>
        <table id="table-entries-report" class="table-report">
            <thead>
            <tr>
                <th>Alumno</th>
                <th>Culminación</th>
                <th>Detalles</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>

        </table>

    </div>

</div>