<div class="wrap report">
    <table class="document">
        <tr>
            <td>
                <img src="<?= DCMS_WPFORMS_URL . '/assets/logo.png' ?>" alt="logo-caes" width="200">
            </td>
            <td>
                <h3>
                    EVALUACIÓN ACCIÓN FORMATIVA (ONLINE)
                </h3>
            </td>
            <td>
                <strong>
                    Version 2.0
                </strong>
            </td>
        </tr>
        <tr>
            <td>
                Académico
            </td>
            <td>
                <strong>
                    FO-AC-04
                </strong>
            </td>
            <td>
                <span>
                    Fecha de aprobación
                    <br>26-01-2024
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="header-bottom">
                    <div>
                        <div>
                            <span>Entrenamiento:</span>
                            <span>CURSO DE EJEMPLO PARA EMPRENDEDORES</span>
                        </div>
                        <div>
                            <span>Formador:</span>
                            <span>Jhon Marreros Guzmán</span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Fecha culminación:</span>
                            <span>10/01/2024</span>
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
        <tr>
            <td>En término general, como ha sido su
                experiencia con las clases en línea
            </td>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Promedio</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>4</strong></td>
            <td><strong>5</strong></td>
        </tr>
        <tr>
            <td><strong>Evaluación</strong></td>
            <td colspan="5"><strong>90%</strong></td>
        </tr>

    </table>
    <br>
    <table class="document tbl-yesno">
        <tr>
            <th>Question 1?</th>
            <td><strong>Si</strong></td>
            <td>1</td>
            <td><strong>No</strong></td>
            <td>0</td>
        </tr>
    </table>

    <br>
    <table class="document tbl-comments">
        <tr>
            <th>Comentarios</th>
        </tr>
        <tr>
            <td></td>
        </tr>
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
    </style>
</div>