<?php

/* path data */
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT'] .'/FroxlorBillingSystem/');
define('PATH_INCLUDES', BASE_DIR .'includes/');
define('PATH_FUNCTIONS', BASE_DIR .'functions/');
define('PATH_CLASSES', PATH_INCLUDES . 'classes/');
define('PATH_LANGUAGES', PATH_INCLUDES . 'languages/');
define('PATH_IMAGES', BASE_DIR .'images/');

define('PATH_CUSTOMERCENTER_INCLUDES', BASE_DIR .'customercenter/includes/');
define('PATH_CUSTOMERCENTER_LANGUAGES', BASE_DIR . PATH_CUSTOMERCENTER_INCLUDES . 'languages/');
define('PATH_BACKEND_INCLUDES', BASE_DIR .'backend/includes/');
define('PATH_BACKEND_LANGUAGES', PATH_BACKEND_INCLUDES . 'languages/');


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