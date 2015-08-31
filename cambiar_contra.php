<?php
include_once("config.php");
?>

<?php
if (!(isset($_POST['updatepass']) )) {
    session_start();
    if ($_SESSION["name"]) {
        ?>


        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>Cambio de Contraseña</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
            </head>

            <body>
                <header id="head" >
                    <p>Cambio de Contraseña</p>
                </header>

                <div id="main-wrapper">
                    <div id="register-wrapper">
                        <form method="post">
                            <ul>
                                <li>
                                    <label for="passwd">Nueva Contraseña : </label>
                                    <input type="password" id="passwd" maxlength="30" required name="password" />
                                </li>

                                <li>
                                    <label for="conpasswd">Confirmar Nueva Contraseña : </label>
                                    <input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
                                </li>

                                </li>
                                <li class="buttons">
                                    <input type="submit" name="updatepass" value="Acutalizar Contraseña" />
                                    <input type="button" name="cancel" value="Cancelar" onclick="location.href = 'datosasociado.php'" />
                                </li>

                            </ul>
                        </form>
                    </div>
                </div>

            </body>
        </html>

        <?php
    }
} else {
    $usr = new Users;
    $usr->storeFormValues($_POST);

    if ($_POST['password'] == $_POST['conpassword']) {
        echo "<script type='text/javascript'>alert('" . $usr->updatePass() . "'); window.location='datosasociado.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('Las Contraseñas no Coinciden');</script>";
        header("Refresh:0");
    }
}
?>