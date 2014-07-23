<?
class Data_Collection implements ArrayAccess {
    private $container = array();

    /**
     * @param Data_Object $data
     */
    public function add(Data_Object $data) {
        $this->container[] = $data;
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->container;
    }

    /**
     * @return array
     */
    public function toArrayRecursive() {
        $data = array();
        /** @var $row Data_Object */
        foreach ($this->container as $row) $data[] = $row->toArray();
        return $data;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}