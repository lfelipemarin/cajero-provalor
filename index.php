<?php
include_once("config.php");
?>

<?php if (!(isset($_POST['login']) )) { ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Asociados Provalor</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
        </head>

        <body>

            <header id="head" >
                <p>Asociados Provalor</p>
                <p><a href="asociado.php"><span id="register">Registrar Asociado</span></a></p>
            </header>

            <div id="main-wrapper">
                <div id="login-wrapper">
                    <form method="post" action="">
                        <ul>
                            <li>
                                <label for="usn">Nombre de Usuario : </label>
                                <input type="text" maxlength="30" required autofocus name="username" />
                            </li>

                            <li>
                                <label for="passwd">Contraseña : </label>
                                <input type="password" maxlength="30" required name="password" />
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

    if ($usr->userLogin()) {
        echo "Welcome";
    } else {
        echo "Incorrect Username/Password";
    }
}
?>