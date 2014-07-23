<?
/**
 * PDO через MySQL
 */
class MySQL {
    private $link;

    private $host="localhost";
    private $user="root";
    private $pass="";
    private $db="board";

    /**
     * @var bool
     */
    private static $me = false;

    /**
     * @return bool|MySQL
     */
    public static function getInstance() {
        if (!self::$me) self::$me = new self;
        return self::$me;
    }

    /**
     *
     */
    public function __construct() {
        $this->link = mysql_connect($this->host, $this->user, $this->pass);
        if ($this->link) {
            $this->query("USE " . $this->db, $this->link);
        }
    }

    /**
     * @param $query
     * @return resource
     */
    public function query($query) {
        $res = mysql_query($query, $this->link);
        if (!$res) {
            Errors::log("Error " . mysql_error() . " in query: " . $query);
        }
        return $res;
    }

    /**
     * @return int
     */
    public function lastInsertId() {
        $res = mysql_insert_id($this->link);
        if (!$res) {
            Errors::log("Error " . mysql_error() . " while trying to get mysql_insert_id");
        }
        return $res;
    }

    /**
     * Return array of elements or
     * false if error in query
     * @param $query
     * @return array|bool
     */
    public function getResultAssoc($query) {
        $result = array();
        $q_res = $this->query($query);
        if (!$q_res) {
            return false;
        }
        while ($row = mysql_fetch_assoc($q_res)) $result[] = $row;

        return $result;
    }
}
