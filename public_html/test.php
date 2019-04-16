<?php

require_once '../bootloader.php';

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',   
    'password' => '12345'
]);

$db->connect();

