<?php

interface DbInterface {

    const HOST = "localhost";
    const UNAME = "root";
    const PW = "isa123bel!@#";
    const DBNAME = "Igitur";

    public static function doConnect();
}

class DbController implements DbInterface {

    private static $server = DbInterface::HOST;
    private static $currentDB = DbInterface::DBNAME;
    private static $user = DbInterface::UNAME;
    private static $pass = DbInterface::PW;
    private static $hookup;

    public static function doConnect() {
        self::$hookup = mysqli_connect(self::$server, self::$user, self::$pass, self::$currentDB);
        if (self::$hookup) { 
        } elseif (mysqli_connect_error(self::$hookup)) {
            echo('Contact Administrator ' . mysqli_connect_error());
        }
        return self::$hookup;
    } 
} 

