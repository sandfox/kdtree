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

	public function testBuildKDTreeMovesAllMedianPointsIntoHyperRectangle() {
		$lowPoint = new KDTree\Point;
		$midlowPoint = new KDTree\Point;
		$midmidPoint = new KDTree\Point;
		$midhighPoint = new KDTree\Point;
		$highPoint = new KDTree\Point;

		$lowPoint[] = 1;
		$midlowPoint[] = 2;
		$midmidPoint[] = 2;
		$midhighPoint[] = 2;
		$highPoint[] = 3;

		// make the points not actually unique
		$lowPoint[] = 1;
		$midlowPoint[] = 2;
		$midmidPoint[] = 3;
		$midhighPoint[] = 4;
		$highPoint[] = 5;

		$tree = KDTree\KDTree::build([$lowPoint, $midlowPoint, $midmidPoint, $midhighPoint, $highPoint]);

		$this->assertEquals($midlowPoint, $tree->getPoint());
		$this->assertEquals($lowPoint, $tree->getLeftChild()->getPoint());
		$this->assertEquals($midhighPoint, $tree->getRightChild()->getPoint());
	}

	/** Test finding & among * coordinates
	 *
	 *   1 2 3 4
	 * 1     *
	 * 2 *---|
	 * 3     |
	 * 4     |
	 * 5   & |-*
	 * 6     |
	 *
	 * Notice that we need to backtrack up the tree
	 */
	public function testBacktrackInNearestNeighborSearch() {

		$this->pointsData = [
			[3, 1],
			[1, 2],
			[4, 5]
		];

		$this->runNNSearch([2, 5], 2);
	}

	/** Test finding & among * coordinates
	 *
	 *   1 2 3 4
	 * 1     *
	 * 2 *---|
	 * 3     |
	 * 4     *--
	 * 5   & |
	 * 6     |
	 *
	 * Notice that we need to backtrack up the tree
	 */
	public function testFindDualPivotPointNearestNeighborSearch() {

		$this->pointsData = [
			[3, 1],
			[1, 2],
			[3, 4]
		];

		$this->runNNSearch([2, 5], 2);
	}

	public function runNNSearch($searchCoords, $expectedIndex) {
		$this->setUp();

		$searcher = new KDTree\Point;
		foreach($searchCoords as $dimval) $searcher[] = $dimval;

		$tree = KDTree\KDTree::build($this->points);

		$results = new KDTree\SearchResults(1);
		KDTree\KDTree::nearestNeighbour($tree, $searcher, $results);

		$this->assertEquals($this->points[$expectedIndex], $results->getNearestNode()['data']->getPoint());
	}

	public function testDepthGreaterThanMaxDepthThrowsException() {
		try {
			KDTree\KDTree::build([1], 501, 500);
			$this->fail("no exception thrown");
		} catch(OverflowException $e) {
			$this->assertEquals("Depth exceeded maximum of 500. Check for exact duplicate points, which cause infinite recursion, or specify the optional maxdepth argument.", $e->getMessage());
		}
	}

}
