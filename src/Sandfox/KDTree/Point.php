<?php

namespace Sandfox\KDTree;

/**
 * Description of Point
 *
 * @author sandfox
 */
class Point extends \SplFixedArray
{

	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $offset = $this->key();
        }
        parent::offsetSet($offset, $value);
        $this->next();
    }

    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? parent::offsetGet($offset) : null;
    }

	public function getNumDimensions()
	{
		return $this->count();
	}
}
