<?php

namespace Sandfox\KDTree\Tests;

use \Sandfox\KDTree;

class KDTreeTest extends \PHPUnit_Framework_TestCase
{


	protected $pointsData = [
		[1,1,1],
		[2,2,2],
		[3,3,3],
		[4,4,4],
		[5,5,5]
	];

	protected $points = [];

	public function setUp()
	{

		foreach($this->pointsData as $pointData){

			$point = new KDTree\Point;

			for($n = 0; $n < count($pointData); $n++) {
				$point[$n] = $pointData[$n];
			}

			$this->points[] = $point;
		}
	}

	public function testBuild()
	{

		$tree = KDTree\KDTree::build($this->points);

		$this->assertInstanceOf("\Sandfox\KDTree\Node", $tree);

		return $tree;

	}

	/**
	 * @depends testBuild
	 */
	public function testSearchNearestNeighbour($tree)
	{
		$highPoint = new KDTree\Point;

		$highPoint[] = 6;
		$highPoint[] = 6;
		$highPoint[] = 6;

		$highResults = new KDTree\SearchResults();

		KDTree\KDTree::nearestNeighbour($tree, $highPoint, $highResults);

		$highNearest = $highResults->getNearestNode();

		$this->assertEquals($highNearest['data']->getPoint(), $this->points[4]);

		$lowPoint = new KDTree\Point;

		$lowPoint[] = -1;
		$lowPoint[] = -1;
		$lowPoint[] = -1;

		$lowResults = new KDTree\SearchResults();

		KDTree\KDTree::nearestNeighbour($tree, $lowPoint, $lowResults);

		$lowNearest = $lowResults->getNearestNode();

		$this->assertEquals($lowNearest['data']->getPoint(), $this->points[0]);

	}
}