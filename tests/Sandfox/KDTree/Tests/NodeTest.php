<?php

namespace Sandfox\KDTree\Tests;

use \Sandfox\KDTree;

class NodeTest extends \PHPUnit_Framework_TestCase
{
	public function testSetAndGetRightChild()
	{

		$node = new KDTree\Node;

		$child = new KDTree\Node;

		$node->setRightChild($child);

		$this->assertSame($node->getRightChild(), $child);
	}

	public function testSetAndGetLeftChild()
	{

		$node = new KDTree\Node;

		$child = new KDTree\Node;

		$node->setLeftChild($child);

		$this->assertSame($node->getLeftChild(),$child);
	}

	public function testSetAndGetHyperRectangle()
	{
		$node = new KDTree\Node;

		$hyperRectangle = new KDTree\HyperRectangle;

		$node->setHyperRectangle($hyperRectangle);

		$this->assertSame($node->getHyperRectangle(),$hyperRectangle);
	}

	public function testSetAndGetPoint()
	{
		$node = new KDTree\Node;

		$point = new KDTree\Point;

		$node->setPoint($point);

		$this->assertSame($node->getPoint(),$point);
	}
}