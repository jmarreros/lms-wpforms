<?php
/** @var array $dates */
/** @var array $entries */
?>

<style>
    .table-report.table-weighted {
        width: 100%;
        max-width: 100%;
    }

    .table-weighted td,
    .table-weighted th {
        padding: 5px !important;
    }

    .table-weighted tr td:nth-child(3),
    .table-weighted tr td:nth-child(4),
    .table-weighted tr td:nth-child(5),
    tfoot td {
        text-align: center;
    }

</style>

<div class="wrap">
    <h2><?php _e( 'Reporte Ponderado Evaluaciones', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <div id="container-report">

        <form id="form-weighted-report" method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>">

            <table class="filter-table form-table">
                <tbody>
                <tr>
                    <th scope="row">
						<label for="form-id">Formulario:</label>
					</th>
					<td>
						<select name="form_id" id="form-id">
							<?php foreach ( $report_forms as $form_id => $form_name ) : ?>
								<option value="<?= esc_attr( $form_id ) ?>" <?= selected( $selected_form_id, $form_id, false ) ?>><?= esc_html( $form_name ) ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
                        <label for="date-range">Fechas fin entrenamientos:</label>
                    </th>
                    <td>
                        <label for="date-from">Desde:</label>
                        <input type="date" name="dateFrom" id="date-from" value="<?= $dates['from'] ?>">
                        <label for="date-to">Hasta:</label>
                        <input type="date" name="dateTo" id="date-to" value="<?= $dates['to'] ?>">
                    </td>
                    <td>
                        <input type="hidden" name="action" value="process_weighted_report">
                        <input class="button button-primary" type="submit" id="search-courses-weighted" value="Buscar">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <hr>
        <h2 class="title">Detalle</h2>
        <table class="table-report table-weighted">
            <thead>
            <tr>
                <th>Profesor</th>
                <th>Módulo</th>
                <th>Acción Formativa</th>
                <th>Formador</th>
                <th>Atención Participante</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$sum04 = 0;
			$sum05 = 0;
			$sum06 = 0;
			$count04 = 0;
			$count05 = 0;
			$count06 = 0;
			?>
			<?php foreach ( $entries as $entry ) : ?>
				<?php
				$foac04 = $entry['ideal_foac04'] > 0 ? $entry['foac04'] * 100 / $entry['ideal_foac04'] : null;
				$foac05 = $entry['ideal_foac05'] > 0 ? $entry['foac05'] * 100 / $entry['ideal_foac05'] : null;
				$foac06 = $entry['ideal_foac06'] > 0 ? $entry['foac06'] * 100 / $entry['ideal_foac06'] : null;
				$sum04  += $foac04 ?? 0;
				$sum05  += $foac05 ?? 0;
				$sum06  += $foac06 ?? 0;
				$count04 += null === $foac04 ? 0 : 1;
				$count05 += null === $foac05 ? 0 : 1;
				$count06 += null === $foac06 ? 0 : 1;
				?>
                <tr>
                    <td><?= $entry['author_name'] ?></td>
                    <td><?= $entry['course_name'] ?></td>
                    <td><?= null === $foac04 ? '-' : round( $foac04 ) ?></td>
                    <td><?= null === $foac05 ? '-' : round( $foac05 ) ?></td>
                    <td><?= null === $foac06 ? '-' : round( $foac06 ) ?></td>
                </tr>
			<?php endforeach; ?>
			<?php if ( count( $entries ) != 0 ) : ?>
			<?php
			$total04 = $count04 ? round( $sum04 / $count04 ) : '-';
			$total05 = $count05 ? round( $sum05 / $count05 ) : '-';
			$total06 = $count06 ? round( $sum06 / $count06 ) : '-';
			?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2"><strong>Puntuación Promedio</strong></th>
                <td><strong><?= $total04 ?></strong></td>
                <td><strong><?= $total05 ?></strong></td>
                <td><strong><?= $total06 ?></strong></td>
            </tr>
            </tfoot>
			<?php endif ?>
        </table>
    </div>

</div>
