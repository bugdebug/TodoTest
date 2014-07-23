<?
class Data_Object implements ArrayAccess {
    protected $properties = array(
    );

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public function __call($name, $value) {
        if (substr($name,0,3) == "set") {
            return $this->setProperty(strtolower(substr($name,3)), reset($value));
        } elseif (substr($name,0,3) == "get") {
            return $this->getProperty(strtolower(substr($name,3)), reset($value));
        } else {
            Errors::log("[WARNING] Call to undefined method ".get_called_class()."->$name");
            return false;
        }
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public function setProperty($name, $value) {
        if ($this->propertyExist($name)) {
            $this->properties[$name] = $value;
            return true;
        }
        Errors::log("[WARNING] Trying to set non-exist property of ".get_called_class()."->$name");
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function getProperty($name) {
        if ($this->propertyExist($name)) {
            return $this->properties[$name];
        }
        Errors::log("[WARNING] Trying to get non-exist property ".get_called_class()."->$name");
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function propertyExist($name) {
        return array_key_exists($name, $this->properties);
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->properties;
    }

    /**
     * @param $data
     */
    public function fromArray($data) {
        foreach ($data as $key => $val) {
            if ($this->setProperty($key,$val) == false)
                Errors::log("[WARNING] Trying to set non-exist property $key");
        }
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