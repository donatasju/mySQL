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
    'email' => 'lohatronas@gmail.com',
    'password' => 'qwer1234',
    'full_name' => 'lohas lohauskas',
    'age' => 12,
    'gender' => 'f',
    'photo' => 'loh.jpg'
];

$query->bindParam(':email', $data['email'], PDO::PARAM_STR);
$query->bindParam(':password', $data['password'], PDO::PARAM_STR);
$query->bindParam(':full_name', $data['full_name'], PDO::PARAM_STR);
$query->bindParam(':age', $data['age'], PDO::PARAM_INT);
$query->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
$query->bindParam(':photo', $data['photo'], PDO::PARAM_STR);

$query->execute();



