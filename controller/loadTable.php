<!--script que trae los datos desde la bd para la tabla de primeui-->
<?php
include_once("../model/config.php");
try {
    $result["total"] = 0;
    $result["success"] = false;
    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT COUNT(*) from asociado";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $result["total"] = $row[0];


        $sql = "SELECT codigo_asociado,nombres_completos,usuario,tipo_usuario,codigo_tarjeta FROM asociado";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if ($stmt) {
            $clients = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($clients, $row);
            }
            $result["rows"] = $clients;
            $result["success"] = true;
            $result["msg"] = 'Products successfuly requested.';
        } else {
            $result["msg"] = 'Sorry, unable to retrieve the rows from the database!';
        }
    } else {
        $result["msg"] = 'Sorry, unable to count the total number of rows!';
    }
    echo json_encode($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}

