<?php
include_once("model/config.php");
?>

<?php if (!(isset($_POST['login']) )) { ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
            <title>Asociados Provalor</title>
        </head>

        <body>

            <header id="head" >
                <p>Aplicación Para Manejo de Transacciones - Provalor</p>
            </header>

            <div id="main-wrapper">
                <div id="login-wrapper">
                    <form method="post" action="">
                        <ul>
                            <li>
                                <label for="usn">Nombre de Usuario : </label>
                                <input id="usn"type="text" maxlength="30" required autofocus name="username" />
                            </li>

                            <li>
                                <label for="usrtype">Tipo de Usuario : </label>
                                <select id="usrtype" name="usrtype" class="form-control" required="">
                                    <option value="Asociado">Asociado</option>
                                    <option value="Administrador">Administrador</option>
                                </select> 
                            </li>
                            <li>
                                <label for="passwd">Contraseña : </label>
                                <input type="password" id="passwd" maxlength="30" required name="password" />
                            </li>
                            <li class="buttons">
                                <input type="submit" name="login" value="Ingresar" />
                                <input type="button" name="register" value="Registrar" onclick="location.href = 'asociado.php'" />
                            </li>

                        </ul>
                    </form>

                </div>
            </div>

        </body>
    </html>

    <?php
} else {
    $usr = new Users;
    $usr->storeFormValues($_POST);

    if ($usr->userLogin() && $_POST['usrtype'] == "Asociado") {
        header("Location: view/datosasociado.php");
    } elseif ($usr->adminLogin() && $_POST['usrtype'] == "Administrador") {
        header("Location: view/administracion.php");
    } else {
        echo "Incorrect Username/Password";
    }
}