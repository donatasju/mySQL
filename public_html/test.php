<?php

require_once '../bootloader.php';

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();
$query = $pdo->prepare("INSERT INTO `my_db`.`users`"
        . "(`email`, `password`, `full_name`, `age`, `gender`, `photo`)" .
        "VALUES(:email, :password, :full_name, :age, :gender, :photo)");

$data = [
    'email' => 'augis@gmail.com',
    'password' => 'deasfds',
    'full_name' => 'augis papa',
    'age' => 2,
    'gender' => 'm',
    'photo' => 'augis.jpg'
];

foreach ($data as $key => &$value) {
    $query->bindParam(':' . $key, $value);
}

$query->execute();



