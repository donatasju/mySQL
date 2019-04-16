<?php

/**
 * @param $field_input
 * @param $field
 * @param $safe_input
 * @return bool
 */
function validate_username_exists($field_input, &$field, &$safe_input) {
    $db = new \Core\FileDB(DB_FILE);
    $repo = new \Core\User\Repository($db, TABLE_USERS);
    $users = $repo->loadAll();

    foreach ($users as $id => $user) {
        if ($user->getUsername() == $field_input) {
            $field['error_msg'] = 'Username already exists.';

            return false;
        }
    }

    return true;
}

/**
 * @param $field_input
 * @param $field
 * @param $safe_input
 * @return bool
 */
function validate_email_not_exists($field_input, &$field, &$safe_input) {
    $db = new \Core\FileDB(DB_FILE);
    $repository = new \Core\User\Repository($db, TABLE_USERS);

    if (!$repository->load($field_input)) {
        return true;
    }

    $field['error_msg'] = 'Email already exists.';
}