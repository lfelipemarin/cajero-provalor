<?php
include_once("config.php");
?>

<?php if (!(isset($_POST['register']) )) { ?>


    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Registro de Asociado</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
        </head>

        <body>
            <header id="head" >
                <p>Registrar un Asociado</p>
                <p><a href="asociado.php"><span id="register">Registrar Asociado</span></a></p>
            </header>

            <div id="main-wrapper">
                <div id="register-wrapper">
                    <form method="post">
                        <ul>
                            <li>
                                <label for="name">Nombre Completo : </label>
                                <input type="text" id="name" maxlength="100" required autofocus name="name" />
                            </li>

                            <li>
                                <label for="usn">Nombre de Usuario : </label>
                                <input type="text" id="usn" maxlength="30" required name="username" />
                            </li>

                            <li>
                                <label for="passwd">Contraseña : </label>
                                <input type="password" id="passwd" maxlength="30" required name="password" />
                            </li>

                            <li>
                                <label for="conpasswd">Confirmar Contraseña : </label>
                                <input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
                            </li>

                            <li>
                                <label for="card">Codigo de Tarjeta : </label>
                                <select id="card" name="cardcode" required>
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
                            </li>
                            <li class="buttons">
                                <input type="submit" name="register" value="Registrar" />
                                <input type="button" name="cancel" value="Cancelar" onclick="location.href = 'index.php'" />
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

    if ($_POST['password'] == $_POST['conpassword']) {
        echo $usr->register($_POST);
    } else {
        echo "Password and Confirm password not match";
    }
}
?>