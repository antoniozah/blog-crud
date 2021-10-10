<?php
    //Connection to Database through PDO (for Development purpose only)

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=my_app_blog', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>