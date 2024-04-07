<div class="wrap">
    <h2><?php _e( 'Reporte', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <table class="filter-table form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="date-range">Fechas:</label>
            </th>
            <td>
                <label for="date-range-1">Desde:</label>
                <input type="date" name="date-range-1" id="date-range-1">
                <label for="date-range-2">Hasta:</label>
                <input type="date" name="date-range-2" id="date-range-2">
            </td>
            <td></td>
        </tr>
        <tr>
            <th scope="row">
                <label for="list-courses">Curso:</label>
            </th>
            <td>
                <select name="list-courses" id="list-courses">
                    <option value="0">Seleccione un curso</option>
                    <option value="1">Curso 1</option>
                    <option value="1">Curso 1</option>
                    <option value="1">Curso 1</option>
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
    <div id="container-report">
        <table id="table-report" class="table-report">
            <thead>
            <tr>
                <th>Curso</th>
                <th>Alumno</th>
                <th>Profesor</th>
                <th>FO-AC-04</th>
                <th>FO-AC-05</th>
                <th>FO-AC-06</th>
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
            </tr>
            </tbody>

        </table>

    </div>

</div>