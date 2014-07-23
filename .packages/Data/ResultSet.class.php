<?
/**
 * контейнер результата
 */
class Data_ResultSet implements ArrayAccess {
    /**
     * @var array
     */
    private $container = array();

    /**
     * @var bool
     */
    private $isError = false;

    /**
     * @var string
     */
    private $errorText = '';

    /**
     * @param Data_Object $data
     */
    public function add(Data_Object $data) {
        $this->container[] = $data;
    }

    /**
     * @param string $errorText
     * @return Data_ResultSet
     */
    public function setError($errorText = '') {
        $this->isError = true;
        $this->errorText = $errorText;
        return $this;
    }

    /**
     * @return bool
     */
    public function isError() {
        return $this->isError;
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