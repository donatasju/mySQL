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
    'email' => 'fokacija2334@gmail.com',
    'password' => '123456444',
    'full_name' => 'Augis Raugis9000',
    'gender' => 'm',
    'age' => 24,
    'photo' => 'augis2.jpg'
];

$sql = strtr("INSERT INTO @db.@table (@columns) VALUES (@values)", [
            '@db' => SQLBuilder::schema('my_db'),
            '@table' => SQLBuilder::table('users'),
            '@columns' => SQLBuilder::columns(array_keys($row)),
            '@values' => SQLBuilder::binds(array_keys($row)),
            
        ]);

$query = $pdo->prepare($sql);

foreach($row as $key => &$value) {

    $query->bindValue(SQLBuilder::bind($key), $value);
}

$query->execute();







