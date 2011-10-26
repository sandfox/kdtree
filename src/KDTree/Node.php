<?php


namespace KDTree;


/**
 * Description of Node
 *
 * @author grapple
 */
class Node
{
	public $rightChild;
	public $leftChild;
	public $hyperRectangle;
	public $point;
	
	public function __construct()
	{
		$this->hyperRectangle = new HyperRectangle();
	}
	
	
}
