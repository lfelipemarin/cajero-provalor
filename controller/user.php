<?php

class Users {

    public $asocode = null;
    public $name = null;
    public $username = null;
    public $password = null;
    public $usrtype = null;
    public $cardcode = null;
    public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

    public function __construct($data = array()) {

        if (isset($data['asocode']))
            $this->asocode = stripslashes(strip_tags($data['asocode']));
        if (isset($data['name']))
            $this->name = stripslashes(strip_tags($data['name']));
        if (isset($data['username']))
            $this->username = stripslashes(strip_tags($data['username']));
        if (isset($data['password']))
            $this->password = stripslashes(strip_tags($data['password']));
        if (isset($data['usrtype']))
            $this->usrtype = stripslashes(strip_tags($data['usrtype']));
        if (isset($data['cardcode']))
            $this->cardcode = stripslashes(strip_tags($data['cardcode']));
    }

    public function storeFormValues($params) {
        //store the parameters
        $this->__construct($params);
    }

    public function userLogin() {
        $success = false;
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM asociado WHERE usuario = :username AND contrasena = :password LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->execute();

            $valid = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($valid && $valid["tipo_usuario"] == "Asociado") {
                session_start();
                $_SESSION["name"] = $valid["nombres_completos"];
                $_SESSION["id"] = $valid["codigo_asociado"];
                $_SESSION["cod_tarjeta"] = $valid["codigo_tarjeta"];
                $_SESSION["cod_asociado"] = $valid["codigo_asociado"];
                $success = true;
            } else {
                $success = false;
            }
            $con = null;
            return $success;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $success;
        }
    }

    public function adminLogin() {
        $success = false;
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM asociado WHERE usuario = :username AND contrasena = :password LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->execute();

            $valid = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($valid && $valid["tipo_usuario"] == "Administrador") {
                session_start();
                $_SESSION["name_admin"] = $valid["nombres_completos"];
                $_SESSION["id_admin"] = $valid["codigo_asociado"];
                $_SESSION["cod_tarjeta_admin"] = $valid["codigo_tarjeta"];
                $_SESSION["cod_asociado_admin"] = $valid["codigo_asociado"];
                $success = true;
            } else {
                $success = false;
            }
            $con = null;
            return $success;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $success;
        }
    }

    public function register() {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO asociado(codigo_asociado, nombres_completos, usuario, contrasena, tipo_usuario, "
                    . "codigo_tarjeta) VALUES(:asocode, :name, :username, :password, :usrtype, :cardcode)";

            $stmt = $con->prepare($sql);
            $stmt->bindValue("asocode", $this->asocode, PDO::PARAM_STR);
            $stmt->bindValue("name", $this->name, PDO::PARAM_STR);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->bindValue("usrtype", $this->usrtype, PDO::PARAM_STR);
            $stmt->bindValue("cardcode", $this->cardcode, PDO::PARAM_STR);
            $stmt->execute();
            return "Registration Successful <br/> <a href='index.php'>Login Now</a>";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updatePass() {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE asociado SET contrasena = :password WHERE codigo_tarjeta = :cardcode";

            $stmt = $con->prepare($sql);
            session_start();
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->bindValue("cardcode", $_SESSION[cod_tarjeta], PDO::PARAM_STR);
            $stmt->execute();
            return "Contrase\u00f1a Cambiada Correctamente. Vuelva a ingresar con su nueva contrase\u00f1a";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}