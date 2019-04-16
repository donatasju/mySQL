<?php
require_once '../bootloader.php';

$db = new \Core\FileDB(DB_FILE);
$repository = new \Core\User\Repository($db, TABLE_USERS);
$session = new \Core\User\Session($repository);
$song = new \App\Rap\Song($db, TABLE_LINES);

$user_full_name = '';

if ($session->isLoggedIn()) {
    $username = $session->getUser()->getUsername();
    $user_full_name = $session->getUser()->getFullName();
    $success_msg = strtr('@username, welcome aboard!', [
        '@username' => $username
    ]);
}

$form = [
    'fields' => [
        'line_text' => [
            'label' => 'Eilute',
            'type' => 'text',
            'placeholder' => 'Tavo line\'as',
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'user_full_name' => [
            'label' => '',
            'type' => 'hidden',
            'value' => $user_full_name,
            'validate' => []
        ]
    ],
    'buttons' => [
        'submit' => [
            'text' => 'Rap As ' . $user_full_name
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function form_success($safe_input, $form) {
    $line = new \App\Rap\Line([
        'line_text' => $safe_input['line_text'],
        'user_full_name' => $safe_input['user_full_name']
    ]);

    $db = new \Core\FileDB(DB_FILE);
    $model_line = new \App\Rap\ModelLine($db, TABLE_LINES);
    $model_line->insert($line);
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

//    if ($form_success) {
//        $success_msg = strtr('User "@user_username" successfully created!', [
//            '@user_username' => $safe_input['user_username']
//        ]);
//    }
}

?>
<html>

    <?php require '../core/objects/header.php'; ?>

    <body class="index index-bg">

        <?php require '../core/objects/navigation.php'; ?>

        <section class="content container-fluid">
            <?php if (isset($success_msg)): ?>
                <h2><?php print $success_msg; ?></h2>

                <section class="song">
                    <!-- Song -->
                    <?php foreach ($song->getSong() as $line): ?>
                        <div class="song-line" title="<?php print $line->getUserFullName(); ?>"><?php print $line->getLineText(); ?>
                        </div>
                    <?php endforeach; ?>
                </section>

                <!-- Form -->
                <?php require '../core/objects/form.php'; ?>
            <?php else: ?>
                <h2>You are not logged in.</h2>
            <?php endif; ?>
        </section>

        <?php require '../core/objects/scripts.php'; ?>
        
    </body>
</html>