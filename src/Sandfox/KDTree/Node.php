<?php


namespace Sandfox\KDTree;


/**
 * A K-dimensional point in the tree
 *
 * @author sandfox
 */
class Node
{
	/**
	 * The right child
	 * @var Node
	 */
	protected $rightChild;

	/**
	 * The left child
	 * @var Node
	 */
	protected $leftChild;

	/**
	 * The hyper rectangle
	 * @var HyperRectangle
	 */
	protected $hyperRectangle;

	/**
	 * The actual point
	 * 
	 * @var Point
	 */
	protected $point;

	/**
	 * 
	 */
	public function __construct()
	{
		$this->hyperRectangle = new HyperRectangle();
	}

	/**
	 * [getRightChild description]
	 * @return [type] [description]
	 */
	public function getRightChild()
	{
		return $this->rightChild;
	}

	/**
	 * [setRightChild description]
	 * @param [type] $child [description]
	 */
	public function setRightChild($child)
	{
		$this->rightChild = $child;
		return $this;
	}

	/**
	 * [getLeftChild description]
	 * @return [type] [description]
	 */
	public function getLeftChild()
	{
		return $this->leftChild;
	}

	/**
	 * [setLeftChild description]
	 * @param [type] $child [description]
	 */
	public function setLeftChild($child)
	{
		$this->leftChild = $child;
		return $this;
	}

	/**
	 * [getHyperRectangle description]
	 * @return [type] [description]
	 */
	public function getHyperRectangle()
	{
		return $this->hyperRectangle;
	}

	/**
	 * [setHyperRectangle description]
	 * @param [type] $hyperRectangle [description]
	 */
	public function setHyperRectangle($hyperRectangle)
	{
		$this->hyperRectangle = $hyperRectangle;
		return $this;
	}

	/**
	 * [getPoint description]
	 * @return [type] [description]
	 */
	public function getPoint()
	{
		return $this->point;
	}

	/**
	 * [setPoint description]
	 * @param Point $point [description]
	 */
	public function setPoint(Point $point)
	{
		$this->point = $point;
		return $this;
	}


}
