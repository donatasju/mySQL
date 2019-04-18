<?php
require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();


$sql = strtr("SELECT * FROM @db.@table WHERE (@gender = @genderValue) AND (@age = @ageValue)", [
            '@db' => SQLBuilder::schema('my_db'),
            '@table' => SQLBuilder::table('users'),
            '@gender' => SQLBuilder::column('gender'),
            '@age' => SQLBuilder::column('age'),
            '@genderValue' => SQLBuilder::value('f'),
            '@ageValue' => SQLBuilder::value(23),
            
        ]);

$query = $pdo->query($sql);
$data = $query->fetchAll(PDO::FETCH_ASSOC);
var_dump($data);





