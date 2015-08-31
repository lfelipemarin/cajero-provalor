<?php

session_start();
unset($_SESSION["name"]);
unset($_SESSION["id"]);
unset($_SESSION["cod_tarjeta"]);
header("Location:index.php");