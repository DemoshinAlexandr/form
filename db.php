<?php  //подключение к базе данных, вывод ошибки в случае невозможности подключения
try
{
    $pdo = new PDO("mysql:host=localhost;dbname=good", 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
    $error = 'Не получается подключится к базе   :  '.$e;
    echo $error;
    exit();
}
