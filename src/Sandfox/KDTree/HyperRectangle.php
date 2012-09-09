<?php


namespace Sandfox\KDTree;

/**
 * Description of HyperRectangle
 * 
 * Each key represents a plan and should take an array of 'min', 'max'
 * FIXME - should the compenents of a hyper rectangle be represented by a plane or something else?
 *
 * @author sandfox
 */
class HyperRectangle implements \ArrayAccess
{
	protected $axis = array();
	
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->axis[] = $value;
        } else {
            $this->axis[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->axis[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->axis[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->axis[$offset]) ? $this->axis[$offset] : null;
    }
}
