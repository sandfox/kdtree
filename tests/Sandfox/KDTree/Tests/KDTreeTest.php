<?php

namespace Sandfox\KDTree\Tests;

use \Sandfox\KDTree;

class KDTreeTest extends \PHPUnit_Framework_TestCase
{


	protected $pointsData = [
		[0,0,0],
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
		$originPoint = new KDTree\Point;

		$originPoint[] = 6;
		$originPoint[] = 6;
		$originPoint[] = 6;

		$results = new KDTree\SearchResults(count($this->pointsData));

		KDTree\KDTree::nearestNeighbour($tree, $originPoint, $results);

		$nearest = $results->getNearestNode();

		$this->assertEquals($nearest['node']->getPoint(), $this->points[5]);

	}
}