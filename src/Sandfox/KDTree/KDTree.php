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
	 * [build description]
	 * @param  array   $points [description]
	 * @param  integer $depth  [description]
	 * @return [type]          [description]
	 */
	static public function build(array $points, $depth = 0)
	{

		//Can't build add a node with no points
		if(empty($points)) {
			return;
		}

		$node = new Node();

		$numDimensions = $points[0]->getNumDimensions();

		$axis = $depth % $numDimensions;

		//ugly but high perfomance array sort - usort is cleaner for small number of points
		for($i = 0; $i < $numDimensions; $i++) {

			$coords = array();
			foreach ($points as $point) {
				$coords[] = $point[$i];

				//for use in our multisort
				if($i == $axis) {
					$sortCoords[] = $point[$i];
				}
			}

			$numPointsInDimension = count($coords);

			$node->hyperRectangle[$i]= array(
				'min' => $coords[0],
				'max' => $coords[$numPointsInDimension - 1]
				);
		}


		array_multisort($sortCoords, SORT_ASC, $points);



		$median = count($points) / 2;


		$node->setPoint($points[$median]);


		//lets split the array in half
		$leftArray = array_slice($points, 0, $median -1);
		$rightArray= array_slice($points, $median +1, null);

		$node->setLeftChild(self::build($leftArray, $depth+1));
		$node->setRightChild(self::build($rightArray, $depth+1));

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
		$numDimensions = count($originPoint);

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
					if($originPoint[$i] < $oppositeNode->getHyperRectangle()[$i]['min']) {
						$tempSearchPoint[$i] = $oppositeNode->getHyperRectangle()[$i]['min'];
					}
					elseif($originPoint[$i] < $oppositeNode->getHyperRectangle()[$i]['max']) {
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
	 *
	 * @param array $pointA
	 * @param array $pointB
	 * @return type
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
