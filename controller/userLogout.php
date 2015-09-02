<?php

session_start();
unset($_SESSION["name"]);
unset($_SESSION["id"]);
unset($_SESSION["cod_tarjeta"]);
unset($_SESSION["cod_asociado"]);
unset($_SESSION["name_admin"]);
unset($_SESSION["id_admin"]);
unset($_SESSION["cod_tarjeta_admin"]);
unset($_SESSION["cod_asociado_admin"]);
header("Location:/index.php");