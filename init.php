<?
//phpinfo();
define("ROOT_DIR", __DIR__);

define("PACKAGES_DIR", ROOT_DIR . "/.packages");
define("TEMPLATES_DIR", ROOT_DIR . "/.templates");
define("TEMPORARY_DIR", ROOT_DIR . "/.temp");
define("CONFIG_DIR", ROOT_DIR . "/.config");

define("SMARTY_CONFIG_DIR", CONFIG_DIR . "/smarty/");
define("SMARTY_TEMPLATES_DIR", TEMPLATES_DIR);
define("SMARTY_TEMPLATES_C_DIR", TEMPORARY_DIR . "/smarty/templates_c/");
define("SMARTY_CACHE_DIR", TEMPORARY_DIR . "/smarty/cache/");

if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Moscow');
header("Content-Type:text/html;charset=utf-8");

function default_autoloader($class_name) {
    if (file_exists(PACKAGES_DIR . "/Core/$class_name.class.php")) {
        require_once PACKAGES_DIR."/Core/$class_name.class.php";
        return;
    }

    if (file_exists(PACKAGES_DIR . "/$class_name/$class_name.class.php")) {
        require_once PACKAGES_DIR."/$class_name/$class_name.class.php";
        return;
    }

    $names = explode('_', $class_name);
    if (count($names) > 0 && $names[0] == 'Smarty') return;

    if (count($names) == 2 && file_exists(PACKAGES_DIR."/{$names[0]}/{$names[1]}.class.php")) {
        require_once PACKAGES_DIR."/{$names[0]}/{$names[1]}.class.php";
        return;
    }

    die("Can not find class $class_name");
}

spl_autoload_register('default_autoloader');

set_error_handler(array("Errors","error_handler"));
error_reporting(E_ALL);
ini_set("display_errors",1);

function varlog() {
    foreach (func_get_args() as $text) {
        if (!is_string($text)) $text = var_export($text, true);
        error_log($text);
    }
}