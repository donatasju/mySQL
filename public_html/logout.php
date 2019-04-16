<?php

require_once '../bootloader.php';

$form = [
    'fields' => [],
    'validate' => [],
    'buttons' => [
        'submit' => [
            'text' => 'Logout'
        ]
    ],
    'callbacks' => [
        'success' => [],
        'fail' => []
    ]
];

$db = new \Core\FileDB(DB_FILE);
$repository = new \Core\User\Repository($db, TABLE_USERS);
$session = new \Core\User\Session($repository);

if ($session->isLoggedIn()) {
    if (!empty($_POST)) {
        $safe_input = get_safe_input($form);
        $form_success = validate_form($safe_input, $form);

        if ($form_success) {
            $session->logout();
        }
    }
}

if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

?>
<html>

    <?php require '../core/objects/header.php'; ?>

    <body class="logout-bg">

        <?php require '../core/objects/navigation.php'; ?>

        <section class="form container-fluid">

            <!-- Content -->
            <h1>Do you really want to logout?</h1>

            <!-- Form -->
            <?php require '../core/objects/form.php'; ?>

        </section>

        <?php require '../core/objects/scripts.php'; ?>

    </body>
</html>