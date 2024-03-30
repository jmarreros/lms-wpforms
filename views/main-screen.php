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



    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label>Datos</label>
            </th>
            <td>
                <input class="button button-primary" type="button" id="btn-save-fields" value="Grabar">
            </td>
        </tr>
        </tbody>
    </table>

</div>