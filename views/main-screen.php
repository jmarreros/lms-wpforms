<div class="wrap">
    <h2><?php _e( 'WPForms Integration', 'dcms-lms-forms' ) ?></h2>
    <hr>
    <form method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>">

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="url_token">ID WPForm</label>
                </th>
                <td>
                    <input type="text" name="id_wpform" value="<?= $id_form ?>" required>

                    <input type="hidden" name="action" value="save_id_form">
                    <input class="button button-primary" type="submit" name="submit" value="Grabar">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <hr>

    <table id="form-fields" class="form-fields">
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
                <td><?= $key ?></td>
                <td><?= $field['field_label'] ?></td>
                <td><?= $field['field_type'] ?></td>
                <td><?= $field['field_options'] ?></td>
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

</div>