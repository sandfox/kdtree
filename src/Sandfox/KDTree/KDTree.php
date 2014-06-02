<?php

namespace Sandfox\KDTree;

/**
 * Description of KDTree
 *
 * @author sandfox
 */
class KDTree
{
	/**
	 * Creates a KDTree (or more accurately a node with children)
	 * @param  array   $points The points the tree is to be built from
	 * @param  integer $depth  Used by this function recursively, don't set yourself
	 * @return Sandfox\KDTree\Node          [description]
	 */
	static public function build(array $points, $depth = 0, $maxdepth = 1000)
	{
		if($depth > $maxdepth) {
			throw new \OverflowException("Depth exceeded maximum of " . $maxdepth . ". Check for exact duplicate points, which cause infinite recursion, or specify the optional maxdepth argument.");
		}

		//Can't build add a node with no points
		if(empty($points)) {
			return;
		}

		$node = new Node();

		$numDimensions = $points[0]->getNumDimensions();

		$axis = $depth % $numDimensions;

		//ugly but high perfomance array sort - usort is cleaner for small number of points
		for($i = 0; $i < $numDimensions; $i++) {
			$min = null; $max = null;

			$coords = array();
			foreach ($points as $point) {
				if($min === null || $point[$i] < $min) $min = $point[$i];
				if($max === null || $point[$i] > $max) $max = $point[$i];
				$coords[] = $point[$i];

				//for use in our multisort
				if($i == $axis) {
					$sortCoords[] = $point[$i];
				}
			}

			$numPointsInDimension = count($coords);

			$node->getHyperRectangle()[$i]= array(
				'min' => $min,
				'max' => $max
			);
		}


		array_multisort($sortCoords, SORT_ASC, $points);

		$median = floor(count($points) / 2); // bitshift for fast division
		while($median > 0 && $sortCoords[$median] == $sortCoords[$median - 1]) {
			$median--;
		}

		$node->setPoint($points[$median]);


		//lets split the array in half
		$leftArray = array_slice($points, 0, $median);
		$rightArray= array_slice($points, $median +1, null);

		$node->setLeftChild(self::build($leftArray, $depth+1, $maxdepth));
		$node->setRightChild(self::build($rightArray, $depth+1, $maxdepth));

		return $node;

	}

	/**
	 * [nearestNeighbour description]
	 * @param  Node          $node        [description]
	 * @param  Point         $originPoint [description]
	 * @param  SearchResults $results     [description]
	 * @param  integer       $depth       [description]
	 * @return [type]                     [description]
	 */
	static public function nearestNeighbour(Node $node, Point $originPoint, SearchResults $results, $depth = 0)
	{
		$numDimensions = $originPoint->getNumDimensions();

		$axis = $depth % $numDimensions;

		$originToNodeDistance = self::euclidianDistance($originPoint, $node->getPoint());

		$results->insertResult($node, $originToNodeDistance);

		$originNodeSplittingCoordinate = $originPoint[$axis];
		$currentNodeSplittingCoordinate = $node->getPoint()[$axis];

		$searchDirection = $originNodeSplittingCoordinate < $currentNodeSplittingCoordinate ? 'left' : 'right';

		switch($searchDirection) {
			case 'left':
				$targetNode = $node->getLeftChild();
				$oppositeNode = $node->getRightChild();
				break;
			case 'right':
				$targetNode = $node->getRightChild();
				$oppositeNode = $node->getLeftChild();
				break;
		}

		if($targetNode) {
			self::nearestNeighbour($targetNode, $originPoint, $results, $depth + 1);
		}

		if($oppositeNode) {

			$tempSearchPoint = new Point();

			for($i = 0; $i < $numDimensions; $i++) {

				if($i == $axis) {
					$tempSearchPoint[$i] = $node->getPoint()[$i];
				} else {
					if($originPoint[$i] <= $oppositeNode->getHyperRectangle()[$i]['min']) {
						$tempSearchPoint[$i] = $oppositeNode->getHyperRectangle()[$i]['min'];
					}
					elseif($originPoint[$i] < $oppositeNode->getHyperRectangle()[$i]['max']) {
						$tempSearchPoint[$i] = $originPoint[$i];
					} else {
						$tempSearchPoint[$i] = $oppositeNode->getHyperRectangle()[$i]['max'];
					}
				}
			}

			$tempDistance = self::euclidianDistance($tempSearchPoint, $originPoint);
			if($tempDistance <= $results->getLastResultDistance()) {
				self::nearestNeighbour($oppositeNode, $originPoint, $results, $depth + 1);
			}
		}



	}

	/**
	 * Calculate the distance between 2 points assuming euclidean geometry applies
	 * @param  Point  $pointA The first point in the comparison
	 * @param  Point  $pointB The second point in the comparison
	 * @return float         The distance between the two points
	 */
	static public function euclidianDistance(Point $pointA, Point $pointB)
	{
		//Lets assume they have the same number of dimensions - we should test
		$numDimensions = $pointA->getNumDimensions();

		$total = 0;
		for ($i = 0; $i < $numDimensions; $i++) {
			$total += pow(($pointB[$i] - $pointA[$i]), 2);
		}

		return sqrt($total);

	}
}
