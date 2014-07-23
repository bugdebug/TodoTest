<?
class Errors {
    /**
     * @param $err
     */
    public static function log($err) {
        if (!is_string($err)) {
            $err = var_export($err, true);
        }
        echo htmlspecialchars($err) . "\n<br>";
        syslog(LOG_NOTICE, $err);
    }

    /**
     * @param $errno
     * @param $errmsg
     * @param $errfile
     * @param $errline
     * @param $vars
     */
    public static function error_handler($errno, $errmsg, $errfile, $errline, $vars) {
        if (defined('E_STRICT') && $errno == E_STRICT) return;

        ignore_user_abort(1);

        //$dt = date("Y-m-d H:i:s");
        //$tm = time();

        $errortype = array (
            E_WARNING         => "Warning",
            E_NOTICE          => "Notice",
            E_USER_ERROR      => "User Error",
            E_USER_WARNING    => "User Warning",
            E_USER_NOTICE     => "User Notice",
            E_STRICT          => "Strict Standards",
            E_RECOVERABLE_ERROR => "Catchable Fatal Error",
        );

        $err = $errortype[$errno] . ': ' . $errmsg . ' in ' . $errfile . ' on line ' . $errline . "\n";

        $err .= "Trace:\n";
        $trace = debug_backtrace();
        foreach ($trace as $row) {
            $file = isset($row['file']) ? $row['file'] : "noFile";
            $line = isset($row['line']) ? $row['line'] : "noLine";
            $class = isset($row['class']) ? $row['class'] : "noClass";
            $type = isset($row['type']) ? $row['type'] : "::";
            $function = isset($row['function']) ? $row['function'] : "noFunction";
            $err .= $file . ':' . $line . "\t" . $class . $type . $function . "()\n";
        }

        error_log($err);
    }
}