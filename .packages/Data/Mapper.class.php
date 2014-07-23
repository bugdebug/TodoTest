<?
class Data_Mapper {
    /**
     * @var bool
     */
    protected $table = false;
    /**
     * @var bool
     */
    protected $id = false;
    /**
     * @var bool
     */
    protected $auto_increment = false;
    /**
     * @var bool
     */
    protected $object_class = false;

    /**
     * @return Data_Mapper
     */
    public static function getInstance() {
        return new static;
    }

    /**
     * @param int $limit
     * @return array|Data_Collection
     */
    public function getAll($limit = 1000) {
        $result = new Data_ResultSet();
        if ($this->table == "") {
            Errors::log("No table set in " . __CLASS__);
            return $result->setError();
        }
        $data = MySQL::getInstance()->getResultAssoc("SELECT * FROM " . $this->table . " LIMIT $limit");
        if (!$data) {
            return $result->setError('Connection error in ' . __CLASS__);
        }
        foreach ($data as $row) {
            /** @var $obj Data_Object */
            $obj = new $this->object_class();
            $obj->fromArray($row);
            $result->add($obj);
        }
        return $result;
    }

    /**
     * @param $id
     * @return bool|Data_Object
     */
    public function getById($id) {
        if ($this->table == "") {
            Errors::log("No table set in " . __CLASS__);
            return false;
        }
        $data = MySQL::getInstance()->getResultAssoc("SELECT * FROM " . $this->table . " WHERE id = " . $id);
        if (!$data) {
            return false;
        }
        if (count($data)) {
            $row = reset($data);
            /** @var $obj Data_Object */
            $obj = new $this->object_class();
            $obj->fromArray($row);
            return $obj;
        }

        return false;
    }


    /**
     * @param Data_Object $post
     * @return bool
     */
    public function update(Data_Object $dataObject) {
        $data = $dataObject->toArray();

        $primaryKey = 0;
        $dataString = "";
        foreach ($data as $key => $value) {
            if ($key == $this->id) {
                $primaryKey = $value;
                continue;
            }

            if (is_null($value))
                $dataString .= "$key = null, ";
            elseif (is_bool($value))
                $dataString .= "$key = " . ($value ? "true" : "false") . ", ";
            elseif (is_string($value))
                $dataString .= "$key = \"" . addslashes($value) . '", ';
            else {
                Errors::log("Mapper::insert: value is not acceptable: $value");
            }
        }

        $dataString = substr($dataString, 0, -2);

        if (!$primaryKey) {
            Errors::log("Mapper::update: no primary key detected");
            return false;
        }
        if (!$dataString) {
            Errors::log("Mapper::update: no data to update");
            return false;
        }

        $query = "UPDATE " . $this->table . " SET $dataString WHERE " . $this->id . " = " . $primaryKey;

        $res = MySQL::getInstance()->query($query);
        if (!$res) {
            return false;
        }

        return true;
    }

    /**
     * @param Data_Object $post
     * @return bool
     */
    public function insert(Data_Object $dataObject) {
        $data = $dataObject->toArray();

        $keys = array();
        $values = array();
        foreach ($data as $key => $value) {
            if ($this->auto_increment && $key == $this->id) continue;

            if (is_null($value))
                $values[] = "null";
            elseif (is_bool($value))
                $values[] = $value ? "true" : "false";
            //elseif (is_numeric($value))
            //    $values[] = $value;
            elseif (is_string($value))
                $values[] = '"' . addslashes($value) . '"';
            else {
                Errors::log("Mapper::insert: value is not acceptable: $value");
                $values[] = "";
            }

            $keys[] = $key;
        }
        $keys_str = "";
        $values_str = "";
        foreach ($keys as $key) $keys_str .= "$key, ";
        foreach ($values as $val) $values_str .= "$val, ";
        $keys_str = substr($keys_str, 0, -2);
        $values_str = substr($values_str, 0, -2);

        $query = "INSERT INTO " . $this->table . " ($keys_str) VALUES ($values_str)";

        $res = MySQL::getInstance()->query($query);
        if (!$res) {
            return false;
        }

        if ($this->auto_increment) {
            return MySQL::getInstance()->lastInsertId();
        }

        return true;
    }
}