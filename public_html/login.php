<?php
require_once '../bootloader.php';

$form = [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'email@gmail.com',
            'validate' => [
                'validate_not_empty',
                'validate_email'
            ]
        ],
        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'placeholder' => '********',
            'validate' => [
                'validate_not_empty'
            ]
        ]
    ],
    'validate' => [
        'validate_login'
    ],
    'buttons' => [
        'submit' => [
            'text' => 'Login!'
        ]
    ],
    'callbacks' => [
        'success' => [
        ],
        'fail' => [
            'form_fail'
        ]
    ]
];

function form_fail($safe_input, $form) {
    $cookie = new Core\Cookie('attempts_count');
    $data = $cookie->read();
    $data['attempts'] = isset($data['attempts']) ? $data['attempts'] + 1 : 1;

    $expires_in = $data['attempts'] < 3 ? 3600 : 30;
    $cookie->save($data, $expires_in);
}

function validate_login(&$safe_input, &$form) {
    $db = new Core\FileDB(DB_FILE);
    $repo = new \Core\User\Repository($db, TABLE_USERS);
    $session = new Core\User\Session($repo);

    $status = $session->login($safe_input['email'], $safe_input['password']);
    switch ($status) {
        case Core\User\Session::LOGIN_SUCCESS:
            return true;
    }

    $form['error_msg'] = 'Blogas Email/Password!';
}

$cookie = new Core\Cookie('attempts_count');
$process_from = true;

if ($cookie->exists()) {
    $data = $cookie->read();
    $attempts = $data['attempts'] ?? 0;

    if ($attempts > 2) {
        $process_from = false;
        $form['error_msg'] = 'Wrong 3 attempts, Your are timed out for 30 seconds';
    }
}

if (!empty($_POST) && $process_from) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

    if ($form_success) {
        header('Location: index.php');
        exit();
    }
}
?>
<html lang="en">
    <?php require '../core/objects/header.php'; ?>
    <body class="login-bg">
        <?php require '../core/objects/navigation.php'; ?>
        <section class="form container-fluid">
            <!-- Content -->
            <h1>Login</h1>
            <!-- Form -->
            <?php require '../core/objects/form.php'; ?>
        </section>
        <?php require '../core/objects/scripts.php'; ?>
    </body>
</html>
