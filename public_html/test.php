<?php
require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();


$sql = strtr("UPDATE @db.@table SET @gender = @genderValue, @age = @ageValue", [
            '@db' => SQLBuilder::schema('my_db'),
            '@table' => SQLBuilder::table('users'),
            '@gender' => SQLBuilder::column('gender'),
            '@age' => SQLBuilder::column('age'),
            '@genderValue' => SQLBuilder::value('m'),
            '@ageValue' => SQLBuilder::value(rand(1, 99)),
            
        ]);

$pdo->exec($sql);
var_dump($sql);





