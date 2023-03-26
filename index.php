<?php
$start_time = microtime(true);
define('START_TIME',$start_time);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ini_set('session.cookie_secure', 1);
// ini_set('session.cookie_httponly', 1);
// ini_set('session.cookie_samesite', "Strict");
// ini_set('session.cookie_domain', DOMAIN);

session_start();

define('DB_DSN', 'mysql:host=localhost;dbname=genymicrofw;charset=utf8');
define('DB_USR', 'root');
define('DB_PWD', '12345678');

define('APP_NAME','Voyager');
define('ROOT_DIR', __DIR__);
define('APP_DIR', ROOT_DIR.'/app');
define('ASSETS_DIR', APP_DIR.'/assets');
define('CONTROLLERS_DIR', APP_DIR.'/controllers');
define('CORE_DIR', APP_DIR.'/core');
define('HELPERS_DIR', APP_DIR.'/helpers');
define('I18N_DIR', APP_DIR.'/i18n');
define('MIDDLEWARES_DIR', APP_DIR.'/middlewares');
define('THROWABLES_DIR', MIDDLEWARES_DIR.'/throwables');
define('VALIDATORS_DIR', MIDDLEWARES_DIR.'/validators');
define('QUERIES_DIR', APP_DIR.'/queries');
define('ROUTES_DIR', APP_DIR.'/routes');
define('VIEWS_DIR', APP_DIR.'/views');
define('TEMPLATE_DIR', VIEWS_DIR.'/template-parts');
define('WRAPPERS_DIR', APP_DIR.'/wrappers');

require CORE_DIR.'/app.php';
require CORE_DIR.'/router.php';
require CORE_DIR.'/controller.php';
$app = new App();
$app->registerRoute("home");

?>