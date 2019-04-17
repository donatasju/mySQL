<?php
require_once '../bootloader.php';

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();
$query = $pdo->query("SELECT * FROM `my_db`.`users`");
$last_gender = '';
$users = [];

while ($row = $query->fetch(PDO::FETCH_LAZY)) {
    $gender = $row['gender'];

    if ($gender == $last_gender && $gender == 'f') {
        break;
    } else {
        $last_gender = $gender;
        $users[] = [
            'email' => $row['email'],
            'full_name' => $row['full_name'],
            'age' => $row['age'],
            'gender' => $row['gender'],
            'photo' => $row['photo'],
        ];
    }
}

?>
<html>
    <head>
        <title>DB</title>
    </head>
    <body>
        <?php foreach ($users as $user): ?>
            <ul>
                <li><?php print $user['email']; ?></li>
                <li><?php print $user['full_name']; ?></li>
                <li><?php print $user['age']; ?></li>
                <li><?php print $user['gender']; ?></li>
                <li><?php print $user['photo']; ?></li>
            </ul>
        <?php endforeach; ?>
    </body>
</html>






