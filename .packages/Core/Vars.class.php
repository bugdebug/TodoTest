<?
class Vars {
    public static function get($name, $default=false) {
        return !empty($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }
}