<?php

class Users {

    public $name = null;
    public $username = null;
    public $password = null;
    public $cardcode = null;
    public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

    public function __construct($data = array()) {
        if (isset($data['name']))
            $this->name = stripslashes(strip_tags($data['name']));
        if (isset($data['username']))
            $this->username = stripslashes(strip_tags($data['username']));
        if (isset($data['password']))
            $this->password = stripslashes(strip_tags($data['password']));
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

            $valid = $stmt->fetchColumn();

            if ($valid) {
                $success = true;
            }

            $con = null;
            return $success;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $success;
        }
    }

    public function register() {
        $correct = false;
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO asociado(nombres_completos, usuario, contrasena, codigo_tarjeta) "
                    . "VALUES(:name, :username, :password, :cardcode)";

            $stmt = $con->prepare($sql);
            $stmt->bindValue("name", $this->name, PDO::PARAM_STR);
            $stmt->bindValue("username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
            $stmt->bindValue("cardcode", $this->cardcode, PDO::PARAM_STR);
            $stmt->execute();
            return "Registration Successful <br/> <a href='index.php'>Login Now</a>";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCardCode() {
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
    }

}

?>