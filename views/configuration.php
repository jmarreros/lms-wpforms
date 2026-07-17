
<div class="wrap">
    <h2><?php _e( 'WPForms Integration', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>">
		<?php wp_nonce_field( 'dcms_lms_forms_save_ids' ); ?>

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="id_wpform">ID formulario Genérico</label>
                </th>
                <td>
                    <input type="text" name="id_wpform" value="<?= esc_attr( $id_form ) ?>" required>

                    <input type="hidden" name="action" value="save_id_form">
                    <input class="button button-primary" type="submit" name="submit" value="Grabar">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="id_sub_wpform_foac05">ID formulario Facilitadores</label>
                </th>
                <td>
                    <input type="text" id="id_sub_wpform_foac05" name="id_sub_wpform_foac05" value="<?= esc_attr( $id_sub_form ) ?>">
                    <p class="description">Debe contener exactamente los campos configurados para FO-AC-05 y los campos ocultos course_id y course_name.</p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
	<?php if ( ( $_GET['dcms_lms_forms_error'] ?? '' ) === 'invalid-sub-form' ) : ?>
        <div class="notice notice-error"><p>El subformulario debe contener los mismos campos, tipos y opciones de FO-AC-05, además de los campos ocultos course_id y course_name.</p></div>
	<?php endif; ?>
    <hr>

    <div id="container-fields">
        <table id="table-fields" class="form-fields">
            <thead>
            <tr>
                <th>ID Field</th>
                <th>Label</th>
                <th>Type</th>
                <th>Options</th>
                <th>Document</th>
                <th>Order</th>
            </tr>
            </thead>
            <tbody>
		    <?php foreach ( $fields as $key => $field ) : ?>
                <tr id="<?= $key ?>">
                    <td class="id"><?= $key ?></td>
                    <td class="label"><?= $field['field_label'] ?></td>
                    <td class="type"><?= $field['field_type'] ?></td>
                    <td class="options"><?= $field['field_options'] ?></td>
                    <td>
                        <select class="document">
                            <option value="" >-- Ninguno --</option>
						    <?php foreach ( $groups as $group ) : ?>
                                <option value="<?= $group ?>"  <?= selected($field['field_group'], $group) ?> >
								    <?= $group ?>
                                </option>
						    <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input class="order" type="number" value="<?= $field['field_order'] ?>"/>
                    </td>
                </tr>
		    <?php endforeach; ?>
            </tbody>

        </table>

        <input class="button button-primary" type="button" id="btn-save-fields" value="Grabar">
        <span class="msg-btn"></span>
        <div class="loading hide"></div>
    </div>

</div>
