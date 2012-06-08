<?php

/* path data */
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT'] .'/FroxlorBillingSystem/');
define('PATH_INCLUDES', BASE_DIR .'includes/');
define('PATH_FUNCTIONS', BASE_DIR .'functions/');
define('PATH_CLASSES', BASE_DIR . PATH_INCLUDES . 'classes/');
define('PATH_LANGUAGES', BASE_DIR . PATH_INCLUDES . 'languages/');
define('PATH_IMAGES', BASE_DIR .'images/');

/* database section */
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_NAME','froxlor_billing');

/* SMTP / mail section */
define('SMTP_SERVER','');
define('SMTP_USER','');
define('SMTP_PASSWORD','');

?>