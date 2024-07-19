<div class="wrap">
	<h2><?php _e( 'Reporte Ponderado Evaluaciones', 'dcms-lms-forms' ) ?></h2>
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
					<input class="button button-primary" type="button" id="search-courses-weighted" value="Buscar">
					<div class="dates-loading loading hide"></div>
				</td>
			</tr>
			</tbody>
		</table>

		<hr>

		<h2 class="title">Detalle</h2>
		<table id="table-entries-report" class="table-report">
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
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</tbody>

		</table>

	</div>

</div>