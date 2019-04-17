<?php
require_once '../bootloader.php';

$db = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345'
        ]);

$pdo = $db->getPDO();
//$query = $pdo->prepare("INSERT INTO `my_db`.`users`"
//        . "(`email`, `password`, `full_name`, `age`, `gender`, `photo`)" .
//        "VALUES(:email, :password, :full_name, :age, :gender, :photo)");
//
//$data = [
//    'email' => 'augis@gmail.com',
//    'password' => 'deasfds',
//    'full_name' => 'augis papa',
//    'age' => 2,
//    'gender' => 'm',
//    'photo' => 'augis.jpg'
//];
//
//foreach ($data as $key => &$value) {
//    $query->bindParam(':' . $key, $value);
//}
//
//$query->execute();

$query = $pdo->query("SELECT * FROM `my_db`.`users`");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
    <head>
        <title>DB</title>
    </head>
    <body>
        <?php foreach ($data as $row): ?>
            <ul>
                <li>Email: <?php print $row['email']; ?></li>
                <li>Password: <?php print $row['password']; ?></li>
                <li>Full Name: <?php print $row['full_name']; ?></li>
                <li>Age: <?php print $row['age']; ?></li>
                <li>Gender: <?php print $row['gender']; ?></li>
                <li>Created at: <?php print $row['created_at']; ?></li>
                <li>Updated at: <?php print $row['updated_at']; ?></li>
            </ul>
        <?php endforeach; ?>
    </body>
</html>






