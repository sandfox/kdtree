<?php


namespace KDTree;

/**
 * Description of HyperRectangle
 * 
 * Each key represents a plan and should take an array of 'min', 'max'
 * FIXME - should the compenents of a hyper rectangle be represented by a plane or something else?
 *
 * @author grapple
 */
class HyperRectangle implements \ArrayAccess
{
	protected $_axis = array();
	
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_axis[] = $value;
        } else {
            $this->_axis[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->_axis[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->_axis[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->_axis[$offset]) ? $this->_axis[$offset] : null;
    }
}
