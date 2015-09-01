<?php
include_once("config.php");
?>

<?php
if (!(isset($_POST['register']) )) {
    session_start();
    if ($_SESSION["name"]) {
        ?>


        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>Registro de Asociado</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                <link rel="stylesheet" href="/resources/demos/style.css">
                <script src="jsFiles/myjs.js" type="text/javascript"></script>
                <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <script>
                    $(function () {
                        $("#tabs").tabs();
                    });
                </script>
            </head>

            <body>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Gestionar Asociados</a></li>
                        <li><a href="#tabs-2">Gestionar Movimientos</a></li>
                        <li><a href="#tabs-3">Registrar Tarjetas</a></li>
                    </ul>
                    <div id="tabs-1">
                        <div id="main-wrapper">
                            <table id="records_table" class="table-bordered table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th class="tg-031e">Codigo Asociado</th>
                                        <th class="tg-031e">Nombre</th>
                                        <th class="tg-031e">Nombre Usuario</th>
                                        <th class="tg-031e">Tipo Usuario</th>
                                        <th class="tg-031e">Cod. Tarjeta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $sql = "SELECT codigo_asociado,nombres_completos,usuario,tipo_usuario,codigo_tarjeta FROM asociado";

                                        $stmt = $con->prepare($sql);
                                        $stmt->execute();
                                        ?>
                                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td class="tg-z2zr"><?php echo $row['codigo_asociado']; ?></td>
                                                <td class="tg-z2zr"><?php echo $row['nombres_completos']; ?></td>
                                                <td class="tg-z2zr"><?php echo $row['usuario']; ?></td>
                                                <td class="tg-z2zr"><?php echo $row['tipo_usuario']; ?></td>
                                                <td class="tg-z2zr"><?php echo $row['codigo_tarjeta']; ?></td>
                                            </tr>

                                            <?php
                                        }
                                        $con = null;
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>
                                </tbody>

                            </table>
                            </br>
                            <form id="form-register" method="post">
                                <fieldset>
                                    <table border="0">
                                        <tr>
                                            <td><b>Nombre Completo: </b></td>
                                            <td><input type="text" id="name" class="form-control" placeholder="nombre" size="50" maxlength="100" required autofocus name="name" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Codigo de Asociado: </b></td>
                                            <td>
                                                <input type="text" id="asocode" class="form-control" placeholder="codigo asociado" maxlength="100" required name="asocode" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Nombre de Usuario: </b></td>
                                            <td>
                                                <input type="text" id="usn" class="form-control" placeholder="marca" maxlength="30" required name="username" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Tipo de Usuario: </b></td>
                                            <td>
                                                <select id="usrtype" name="usrtype" class="form-control" required="">
                                                    <option value="Asociado">Asociado</option>
                                                    <option value="Administrador">Administrador</option>
                                                </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Contraseña: </b></td>
                                            <td>
                                                <input type="password" id="passwd" class="form-control" placeholder="contraseña" maxlength="30" required name="password" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Confirmar Contraseña: </b></td>
                                            <td>
                                                <input type="password" id="conpasswd" class="form-control" placeholder="confirmar contraseña" maxlength="30" required name="conpassword" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Codigo de Tarjeta: </b></td>
                                            <td>
                                                <select id="card" name="cardcode" class="form-control" required>
                                                    <?php
                                                    try {
                                                        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                                                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                        $sql = "SELECT codigo_tarjeta FROM tarjeta";

                                                        $stmt = $con->prepare($sql);
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option value="' . $row['codigo_tarjeta'] . '">' . $row['codigo_tarjeta'] . '</option>';
                                                        }
                                                        $con = null;
                                                    } catch (PDOException $e) {
                                                        echo $e->getMessage();
                                                    }
                                                    ?>
                                                </select> 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <br>
                                                <button type="submit" id="btnSave" name="register" class="btn btn-default btn-lg" value="Registrar">
                                                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span> REGISTRAR
                                                </button>
                                                <button type="button" id="btnClear" name="clear" class="btn btn-default btn-lg" value="Limpiar">
                                                    <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> LIMPIAR CAMPOS
                                                </button>
                                                <button type="button" id="btnUpdate" name="cancel" class="btn btn-default btn-lg edicion" value="Cancelar"
                                                        onclick="location.href = 'index.php'">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> CANCELAR
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </form>
                        </div>
                    </div>


                    <div id="tabs-2">
                        <div id="main-wrapper">
                            <div id="register-wrapper">
                                <form method="post">
                                    <ul>
                                        <li>
                                            <label for="cardcode">Codigo de Tarjeta : </label>
                                            <input type="text" id="card" maxlength="50" required autofocus name="cardcode" />
                                        </li>
                                        <li>
                                            <label for="valor">Valor : </label>
                                            <input type="text" id="valor" maxlength="100" required name="valor" />
                                        </li>


                                        <li class="buttons">
                                            <input type="submit" name="register" value="Registrar" />
                                            <input type="button" name="cancel" value="Cancelar" onclick="location.href = 'index.php'" />
                                        </li>

                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="tabs-3">
                        <div id="tabs-2">
                            <div id="main-wrapper">
                                <div id="register-wrapper">
                                    <form method="post">
                                        <ul>
                                            <li>
                                                <label for="cardcode">Codigo de Tarjeta : </label>
                                                <input type="text" id="card" maxlength="50" required autofocus name="cardcode" />
                                            </li>
                                            <li>
                                                <label for="valor">Valor : </label>
                                                <input type="text" id="valor" maxlength="100" required name="valor" />
                                            </li>


                                            <li class="buttons">
                                                <input type="submit" name="register" value="Registrar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="location.href = 'index.php'" />
                                            </li>

                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
        </html>

        <?php
    }else{
        header("Location:userlogout.php");
    }
} else {
    $usr = new Users;
    $usr->storeFormValues($_POST);

    if ($_POST['password'] == $_POST['conpassword']) {
        echo $usr->register($_POST);
    } else {
        echo "Password and Confirm password not match";
    }
}
?>