<?php
require_once '../bootloader.php';

$form = [
    'fields' => [
        'user_username' => [
            'label' => 'Username',
            'type' => 'text',
            'placeholder' => 'Your username',
            'validate' => [
                'validate_not_empty',
                'validate_username',
                'validate_username_exists'
            ]
        ],
        'user_email' => [
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'Your email',
            'validate' => [
                'validate_not_empty',
                'validate_email',
                'validate_email_not_exists'
            ]
        ],
        'user_password_first' => [
            'label' => 'Password',
            'type' => 'password',
            'placeholder' => 'Your password',
            'validate' => [
                'validate_not_empty',
                'validate_password'
            ]
        ],
        'user_password' => [
            'label' => 'Type Password Again',
            'type' => 'password',
            'placeholder' => 'Your password',
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'user_full_name' => [
            'label' => 'Full name',
            'type' => 'text',
            'placeholder' => 'Your full name',
            'validate' => [
                'validate_not_empty',
                'validate_full_name',
                'validate_is_space'
            ]
        ],
        'user_age' => [
            'label' => 'Age',
            'type' => 'number',
            'placeholder' => 'Your age',
            'validate' => [
                'validate_not_empty',
                'validate_is_number',
                'validate_age'
            ]
        ],
        'user_gender' => [
            'label' => 'Choose gender',
            'type' => 'select',
            'validate' => [
                'validate_not_empty',
                'validate_field_select'
            ],
            'options' => \Core\User\User::getGenderOptions()
        ],
        'user_orientation' => [
            'label' => 'Choose orientation',
            'type' => 'select',
            'validate' => [
                'validate_not_empty',
                'validate_field_select'
            ],
            'options' => \Core\User\User::getOrientationOptions()
        ],
        'user_photo' => [
            'label' => 'Photo',
            'placeholder' => 'file',
            'type' => 'file',
            'validate' => [
                'validate_file'
            ]
        ]
    ],
    'validate' => [
        'confirm_password',
        'validate_form_file'
    ],
    'buttons' => [
        'submit' => [
            'text' => 'Registruoti'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

/**
 * @param $field_input
 * @param $field
 * @param $safe_input
 * @return bool
 */
function validate_password($field_input, &$field, &$safe_input) {
    if (strlen($field_input) <= '7') {
        $field['error_msg'] = 'Your Password Must Contain At Least 8 Characters!';
    } elseif (!preg_match("#[0-9]+#", $field_input)) {
        $field['error_msg'] = 'Your Password Must Contain At Least 1 Number!';
    } elseif (!preg_match("#[A-Z]+#", $field_input)) {
        $field['error_msg'] = 'Your Password Must Contain At Least 1 Capital Letter!';
    } elseif (!preg_match("#[a-z]+#", $field_input)) {
        $field['error_msg'] = 'Your Password Must Contain At Least 1 Lowercase Letter!';
    } else {
        return true;
    }
}

/**
 * @param $safe_input
 * @param $form
 * @return bool
 */
function confirm_password(&$safe_input, &$form) {
    if ($safe_input['user_password_first'] !== $safe_input['user_password']) {
        $form['error_msg'] = 'Your entered passwords don\'t match.';
    } else {
        return true;
    }
}

/**
 * @param $safe_input
 * @param $form
 * @return bool
 */
function validate_form_file(&$safe_input, &$form) {
    $file_saved_url = save_file($safe_input['user_photo']);

    if ($file_saved_url) {
        $safe_input['user_photo'] = 'uploads/' . $file_saved_url;

        return true;
    } else {
        $form['error_msg'] = 'File error!';
    }
}

/**
 * @param $safe_input
 * @param $form
 */
function form_success($safe_input, $form) {
    $user = new \Core\User\User([
        'username' => $safe_input['user_username'],
        'email' => $safe_input['user_email'],
        'password' => $safe_input['user_password'],
        'full_name' => $safe_input['user_full_name'],
        'age' => $safe_input['user_age'],
        'gender' => $safe_input['user_gender'],
        'orientation' => $safe_input['user_orientation'],
        'photo' => $safe_input['user_photo'],
        'is_active' => true
    ]);

    $db = new \Core\FileDB(DB_FILE);
    $model_user = new \Core\Models\ModelUser($db, TABLE_USERS);
    $model_user->insert($user);
}

/**
 * @param $file
 * @param string $dir
 * @param array $allowed_types
 * @return bool|string
 */
function save_file($file, $dir = 'uploads', $allowed_types = ['image/png', 'image/jpeg', 'image/gif']) {
    if ($file['error'] == 0 && in_array($file['type'], $allowed_types)) {
        $target_file_name = microtime() . '-' . strtolower($file['name']);
        $target_path = $dir . '/' . $target_file_name;

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return $target_file_name;
        }
    }
    return false;
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

    if ($form_success) {
        header('Location: login.php');
        exit();
    }
}
?>
<html>

    <?php require '../core/objects/header.php'; ?>

    <body class="register-bg">

        <?php require '../core/objects/navigation.php'; ?>

        <section class="form container-fluid">

            <!-- Content -->
            <h1>User Registration</h1>
            <!-- Form -->
            <?php require '../core/objects/form.php'; ?>
        </section>

        <?php require '../core/objects/scripts.php'; ?>

    </body>
</html>