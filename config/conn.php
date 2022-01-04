<?php
try {
    @DEFINE('HOST', 'us-cdbr-east-05.cleardb.net');
    @DEFINE('DB', 'heroku_d2ec27f6d5cb108');
    @DEFINE('USER', 'b9a57c5165c17f');
    @DEFINE('PASS', 'c59c32fe');

    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo '<strong>ERRO DE PDO</strong>' . $ex->getMessage();
}

/* 

Banco de dados MYSQL HEROKU  
                                      
usuario : b9a57c5165c17f 
senha:c59c32fe 
@hostname: us-cdbr-east-05.cleardb.net/ 
schema: heroku_d2ec27f6d5cb108?reconnect=true


*/