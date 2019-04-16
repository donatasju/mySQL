<?php

declare (strict_types=1);

define('ROOT_DIR', __DIR__);
define('DB_FILE', ROOT_DIR . '/app/files/db.txt');
define('TABLE_USERS', 'users');
define('TABLE_LINES', 'lines');

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/core/functions/form.php';
require ROOT_DIR . '/app/functions/form.php';