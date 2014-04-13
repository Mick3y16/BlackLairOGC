<?php

class User extends Model
{

    /*
        PLEASE READ!!!
        This is a map for the functions inside this class, they are ordered alphabetically and have a small explanation...
        activateaccount() - Activates the user account.
        checkactivation() - Checks if the account is already activated.
        checkemailexists() - Checks if email already exists in the database.
        checkuserexists() - Checks if user already exists in the database.
        loginuser() - Validates the user input against the database.
        registeruser() - Registers the user in the database.
    */

    public function activateaccount($username, $activation)
    {
        $sth = $this->ogcdb->prepare("SELECT `email` FROM `ogc_users` WHERE `username`=:username AND `activation`=:activation");
        $sth->bindParam(":username", $username);
        $sth->bindParam(":activation", $activation);
        $sth->execute();
        $count = $sth->rowCount();

        if ($count == 1) {
            $sth = $this->ogcdb->prepare("UPDATE `ogc_users` SET `activation`=0, `level`=1 WHERE `username`=:username AND `activation`=:activation");
            $sth->bindParam(":username", $username);
            $sth->bindParam(":activation", $activation);
            $result = $sth->execute();
            return $result;
        } else {
            return false;
        }
    }

    public function checkactivation($email, $password)
    {
        $sth = $this->ogcdb->prepare("SELECT * FROM `ogc_users` WHERE `email`=:email AND `password`=:password AND `level`=1");
        $sth->bindParam(":email", $email);
        $sth->bindParam(":password", $password);
        $sth->execute();
        $result = $sth->rowCount();
        return $result;
    }

    public function checkemailexists($email)
    {
        $sth = $this->ogcdb->prepare("SELECT `email` FROM `ogc_users` WHERE `email`=:email");
        $sth->bindParam(":email", $email);
        $sth->execute();
        $result = $sth->rowCount();
        return $result;
    }

    public function checkuserexists($username)
    {
        $sth = $this->ogcdb->prepare("SELECT `username` FROM `ogc_users` WHERE `username`=:username");
        $sth->bindParam(":username", $username);
        $sth->execute();
        $result = $sth->rowCount();
        return $result;
    }

    public function getuser($email)
    {
        $sth = $this->ogcdb->prepare("SELECT `username` FROM `ogc_users` WHERE `email`=:email");
        $sth->bindParam(":email", $email);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }

    public function loginuser($email, $password)
    {
        $sth = $this->ogcdb->prepare("SELECT * FROM `ogc_users` WHERE `email`=:email AND `password`=:password");
        $sth->bindParam(":email", $email);
        $sth->bindParam(":password", $password);
        $sth->execute();
        $result = $sth->rowCount();
        return $result;
    }

    public function registeruser($email, $password, $username, $activation)
    {
        $sth = $this->ogcdb->prepare("INSERT INTO `ogc_users` (email, password, username, activation) VALUES (:email,:password,:username,:activation)");
        $sth->bindParam(":email", $email);
        $sth->bindParam(":password", $password);
        $sth->bindParam(":username", $username);
        $sth->bindParam(":activation", $activation);
        $result = $sth->execute();
        return $result;
    }

}
