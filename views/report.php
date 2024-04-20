<div class="wrap">
    <h2><?php _e( 'Reporte', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <div id="container-report">

        <table class="filter-table form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="date-range">Fechas:</label>
                </th>
                <td>
                    <label for="date-from">Desde:</label>
                    <input type="date" name="date-from" id="date-from">
                    <label for="date-to">Hasta:</label>
                    <input type="date" name="date-to" id="date-to">
                </td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="list-courses">Curso:</label>
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
        <table id="table-report" class="table-report">
            <thead>
            <tr>
                <th>Curso</th>
                <th>Alumno</th>
                <th>Profesor</th>
                <th>FO-AC-04</th>
                <th>FO-AC-05</th>
                <th>FO-AC-06</th>
                <th>Detalles</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>

        </table>

    </div>

</div>