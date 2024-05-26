<?php
/** @var String[] $header_detail */
/** @var String $document_name */
/** @var String[] $versions */
/** @var String[] $dates */
/** @var Array $ratings */

/** @var Array $comments */

use dcms\lms_forms\helpers\Rating;

/**
 * @param $question
 * @param $ratings
 *
 * @return array
 */

// For ratings
///--------------------------------

// Auxiliar function to get count of each question
function get_count_question( $question, $ratings ): array {
	$current_question = array_filter( $ratings, function ( $rating ) use ( $question ) {
		return $rating['field_label'] == $question;
	} );

	// Count values
	$count_current_question = array_count_values(
		array_column( $current_question, 'field_value' )
	);

	// Complete the count with 0 values
	for ( $i = 1; $i <= 5; $i ++ ) {
		if ( ! isset( $count_current_question[ $i ] ) ) {
			$count_current_question[ $i ] = 0;
		}
	}

	ksort( $count_current_question );

	return $count_current_question;
}

// Unique column label questions
$questions = array_unique( array_column( $ratings, 'field_label' ) );

// Loop every question to get count
$rating_questions = [];
foreach ( $questions as $question ) {
	$rating_questions[ $question ] = get_count_question( $question, $ratings );
}

// Sum count rating by column
$total_by_rating = [];
foreach ( $rating_questions as $rating_question ) {
	foreach ( $rating_question as $key => $value ) {
		if ( ! isset( $total_by_rating[ $key ] ) ) {
			$total_by_rating[ $key ] = 0;
		}
		$total_by_rating[ $key ] += $value;
	}
}

// Total students
$total_students = array_sum( $total_by_rating );
$total_ideal    = $total_students * Rating::RATING_VALUES[5];

$total_real = 0;
foreach ( $total_by_rating as $key => $value ) {
	$total_real += Rating::RATING_VALUES[ $key ] * $value;
}


$percent_total = round( ( $total_real / $total_ideal ) * 100, 2 );


// For checkbox
///--------------------------------

// Unique column label questions
$questions = array_unique( array_column( $checkboxes, 'field_label' ) );

// Loop every question
$checkbox_questions = [];
foreach ( $questions as $question ) {
	$checkbox_questions[ $question ] = array_filter( $checkboxes, function ( $checkbox ) use ( $question ) {
		return $checkbox['field_label'] == $question;
	} );
}

?>
<div class="wrap report">
    <table class="document">
        <tr>
            <td>
                <img src="<?= DCMS_WPFORMS_URL . '/assets/img/logo.png' ?>" alt="logo-caes" width="200">
            </td>
            <td>
                <h3>
                    EVALUACIÓN ACCIÓN FORMATIVA (ONLINE)
                </h3>
            </td>
            <td>
                <strong>
                    Versión <?= $versions[ $document_name ] ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td>
                Académico
            </td>
            <td>
                <strong>
					<?= $document_name ?>
                </strong>
            </td>
            <td>
                <span>
                    Fecha de aprobación
                    <br>
                    <?= $dates[ $document_name ] ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="header-bottom">
                    <div>
                        <div>
                            <span><strong>Entrenamiento:</strong></span>
                            <span><?= $header_detail['course_name'] ?></span>
                        </div>
                        <div>
                            <span><strong>Formador:</strong></span>
                            <span><?= $header_detail['author_name'] ?></span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span><strong>Fecha culminación:</strong></span>
                            <span><?= $header_detail['end_date'] ?></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="document tbl-rating">
        <tr>
            <th>Descripción</th>
            <th>Pobre</th>
            <th>Regular</th>
            <th>Satisfactorio</th>
            <th>Bueno</th>
            <th>Excelente</th>
        </tr>
		<?php
		foreach ( $rating_questions as $rating_question => $rating ):
			echo "<tr>";
			echo "<td>" . $rating_question . "</td>";
			for ( $i = 1; $i <= 5; $i ++ ) {
				echo "<td>" . $rating[ $i ] . "</td>";
			}
			echo "</tr>";
		endforeach;
		?>
        <tr>
            <td><strong>Promedio</strong></td>
			<?php
			for ( $i = 1; $i <= 5; $i ++ ) {
				echo "<td><strong>" . $total_by_rating[ $i ] . "</strong></td>";
			}
			?>
        </tr>
        <tr>
            <td><strong>Evaluación</strong></td>
            <td colspan="5"><strong><?= $percent_total ?>%</strong></td>
        </tr>

    </table>
    <br>
    <table class="document tbl-yesno">
		<?php foreach ( $checkbox_questions as $question_text => $checkbox_question ): ?>
            <tr>
                <th><?= $question_text ?></th>
				<?php
				$options = explode( '|', $checkbox_question[0]['field_options'] ?? '' );

				foreach ( $options as $option ) {
					echo "<td><strong>" . $option . "</strong></td>";

					$key = array_search( $option, array_column( $checkbox_question, 'field_value' ) );
					if ( $key !== false ) {
						echo "<td>" . $checkbox_question[ $key ]['field_count'] . "</td>";
					} else {
						echo "<td>0</td>";
					}

				}
				?>
            </tr>
		<?php endforeach; ?>

    </table>

    <br>
    <table class="document tbl-comments">
        <tr>
            <th>Comentarios</th>
        </tr>
		<?php foreach ( $comments as $comment ): ?>
            <tr>
                <td>
					<?= $comment['field_value'] ?>
                </td>
            </tr>
		<?php endforeach; ?>
    </table>

    <style>
        .wrap.report {
            background-color: white;
            padding: 40px;
        }

        .document {
            font-family: Arial, Helvetica, sans-serif;
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
            background-color: white;
        }

        .document td {
            border: 1px solid grey;
            padding: 10px;
            text-align: center;
        }

        .document .header-bottom {
            display: flex;
            justify-content: space-between;
            text-align: left;
            padding: 10px;
        }

        .document .header-bottom div > div {
            padding: 10px;
        }

        .document .header-bottom div > div span:first-child {
            display: inline-block;
            width: 140px;
        }

        .tbl-yesno {
            margin-top: 16px;
            width: 80%;
        }

        .tbl-comments {
            margin-top: 16px;
        }

        .tbl-comments td {
            text-align: left;
        }

        .tbl-yesno tr th,
        .tbl-rating tr th,
        .tbl-comments tr th {
            background-color: #efefef;
            border: 1px solid grey;
            padding: 10px;
            border-top: 0;
        }

        .tbl-yesno tr th {
            border-top: 1px solid grey;
            font-weight: normal;
        }

        .tbl-yesno tr td:nth-child(even) {
            min-width: 30px;
        }

        .tbl-comments tr th {
            border-top: 1px solid grey;
            font-weight: bold;
        }

        .tbl-rating tr th {
            width: 10%;
        }

        .tbl-rating tr th:first-child {
            width: 60%;
        }

        .tbl-rating tr td:first-child {
            text-align: left;
        }

        table h3{
            font-family:Helvetica, sans-serif;
            font-size: 16px;
        }

        table tr td,
        table tr th{
            font-family:Helvetica, sans-serif;
            font-size:13px;
        }
    </style>
</div>