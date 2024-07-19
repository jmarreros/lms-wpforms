<div class="wrap">
    <h2><?php _e( 'Reporte Evaluaciones', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <div id="container-report">

        <table class="filter-table form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="date-range">Fechas entrenamientos:</label>
                </th>
                <td>
                    <label for="date-from">Desde:</label>
                    <input type="date" name="date-from" id="date-from">
                    <label for="date-to">Hasta:</label>
                    <input type="date" name="date-to" id="date-to">
                </td>
                <td>
                    <input class="button button-primary" type="button" id="search-courses" value="Buscar">
                    <div class="dates-loading loading hide"></div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="list-courses">Entrenamiento:</label>
                </th>
                <td>
                    <select name="list-courses" id="list-courses">
                        <option value="0">-- Seleccione un curso --</option>
                    </select>
                </td>
                <td>
                    <input class="button button-primary" type="button" id="search-entries" value="Ver detalle">
                    <span class="msg-btn"></span>
                    <div class="course-loading loading hide"></div>
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
                <td class="documents">
					<?php $document_url = admin_url( 'admin.php?page=dcms-lms-forms-report' ) . '&view=detail&document_name=FO-AC-'; ?>
                    <a class="view-html" id="fo-ac-04" href="<?= $document_url . '04' ?>">FO-AC-04</a>
                    <a class="view-pdf" href="<?= $document_url . '04' ?>"><img src="<?= DCMS_WPFORMS_URL . '/assets/img/pdf.svg' ?>" alt="pdf" width="20"></a>

                    <a class="view-html" id="fo-ac-05" href="<?= $document_url . '05' ?>">FO-AC-05</a>
                    <a class="view-pdf" href="<?= $document_url . '05' ?>"><img src="<?= DCMS_WPFORMS_URL . '/assets/img/pdf.svg' ?>" alt="pdf" width="20"></a>

                    <a class="view-html" id="fo-ac-06" href="<?= $document_url . '06' ?>">FO-AC-06</a>
                    <a class="view-pdf" href="<?= $document_url . '06' ?>"><img src="<?= DCMS_WPFORMS_URL . '/assets/img/pdf.svg' ?>" alt="pdf" width="20"></a>
                </td>
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