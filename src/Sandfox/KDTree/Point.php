<?php

namespace Sandfox\KDTree;

/**
 * Description of Location
 *
 * @author sandfox
 */
class Point implements \ArrayAccess 
{

	protected $coordinates = array();

	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->coordinates[] = $value;
        } else {
            $this->coordinates[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->coordinates[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->coordinates[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->coordinates[$offset]) ? $this->coordinates[$offset] : null;
    }

	//UGGLLLYY
	public function getCoordinates()
	{
		return $this->coordinates;
	}

    //Not accurate enough
	public function getNumDimensions()
	{
		return count($this->coordinates);
	}
}
