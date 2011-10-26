<?php

namespace KDTree;

/**
 * Description of Location
 *
 * @author grapple
 */
class Point implements \ArrayAccess {
	
	protected $_coordinates = array();
	
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_coordinates[] = $value;
        } else {
            $this->_coordinates[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->_coordinates[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->_coordinates[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->_coordinates[$offset]) ? $this->_coordinates[$offset] : null;
    }
	
	//UGGLLLYY
	public function getCoordinates()
	{
		return $this->_coordinates;
	}
	
	public function getNumDimensions()
	{
		return count($this->_coordinates);
	}
}
