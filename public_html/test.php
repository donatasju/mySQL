<?php
require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();

$row = [
    'email' => 'fokacija@gmail.com',
    'password' => '123456',
    'full_name' => 'Augis Raugis',
    'gender' => 'f',
    'age' => 23,
    'photo' => 'augis.jpg'
];

$sql = strtr("INSERT INTO @db.@table (@columns) VALUES (@values)", [
            '@db' => SQLBuilder::schema('my_db'),
            '@table' => SQLBuilder::table('users'),
            '@columns' => SQLBuilder::columns(array_keys($row)),
            '@values' => SQLBuilder::values(array_values($row)),
            
        ]);

$pdo->exec($sql);
var_dump($sql);





