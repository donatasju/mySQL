<?php

require_once '../bootloader.php';

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',   
    'password' => '12345'
]);

$pdo = $db->getPDO();
$pdo->exec("INSERT INTO `my_db`.`users`(`email`, `password`, `full_name`, `age`, `gender`, `photo`)" . 
        "VALUES('donatas.jurkusl@gmail.com', '12345', 'Donatas Jurkus', '23', 'm', 'dick.jpg')");

