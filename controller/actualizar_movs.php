<?php
include_once("../model/config.php");
session_start();
echo $_SESSION["cod_tarjeta"];
try {
    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE movimientos SET mov_aceptado = 'SI' WHERE cod_tarjeta = :cardcode";

    $stmt = $con->prepare($sql);

    $stmt->bindValue("cardcode", $_SESSION["cod_tarjeta"], PDO::PARAM_STR);
    $stmt->execute();
    
} catch (PDOException $e) {
    return $e->getMessage();
}

