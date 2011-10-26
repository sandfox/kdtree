<?php

namespace KDTree;

/**
 * Description of KDTree
 *
 * @author grapple
 */
class KDTree
{
	static public function build(array $points, $depth = 0)
	{
		
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
			//var_dump($numPointsInDimension, $coords);die;
			$node->hyperRectangle[$i]= array(
				'min' => $coords[0],
				'max' => $coords[$numPointsInDimension - 1]
				);
		}
		
		
		array_multisort($sortCoords, SORT_ASC, $points);
		
		
		
		$median = count($points) / 2; 
		
		
		$node->point = $points[$median]; 
		
		
		//lets split the array in half
		$leftArray = array_slice($points, 0, $median -1);
		$rightArray= array_slice($points, $median +1, null);
		
		$node->leftChild = self::build($leftArray, $depth+1);
		$node->rightChild = self::build($rightArray, $depth+1);
		
		return $node;
		
	}
	
	static public function nearestNeighbour(Node $node, Point $originPoint, $depth, SearchResults $results)
	{
		$numDimensions = count($originPoint);
		
		$axis = $depth % $numDimensions;
		
		$originToNodeDistance = self::euclidianDistance($originPoint, $node->point);
		
		$results->insertResult($node, $originToNodeDistance);
		
		$originNodeSplittingCoordinate = $originPoint[$axis];
		$currentNodeSplittingCoordinate = $node->point[$axis];
		
		$searchDirection = $originNodeSplittingCoordinate < $currentNodeSplittingCoordinate ? 'left' : 'right';
		
		switch($searchDirection) {
			case 'left':
				$targetNode = $node->leftChild;
				$oppositeNode = $node->rightChild;
				break;
			case 'right':
				$targetNode = $node->rightChild;
				$oppositeNode = $node->leftChild;
				break;
		}
		
		if($targetNode) {
			self::nearestNeighbour($targetNode, $originPoint, $depth + 1, $results);
		}
		
		if($oppositeNode) {
			
			$tempSearchPoint = new Point();
			
			for($i = 0; $i < $numDimensions; $i++) {
			
				if($i == $axis) {
					$tempSearchPoint[$i] = $node->point[$i];
				} else {
					if($originPoint[$i] < $oppositeNode->hyperRectangle[$i]['min']) {
						$tempSearchPoint[$i] = $oppositeNode->hyperRectangle[$i]['min'];
					} 
					elseif($originPoint[$i] < $oppositeNode->hyperRectangle[$i]['max']) {
						$tempSearchPoint[$i] = $oppositeNode->hyperRectangle[$i]['max'];
					}
				}
			}
			
			$tempDistance = self::euclidianDistance($tempSearchPoint, $originPoint);
			if($tempDistance <= $results->getLastResultDistance()) {
				self::nearestNeighbour($oppositeNode, $originPoint, $depth + 1, $results);
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
		//Lets assume they have the same number of dimensions
		$numDimensions = $pointA->getNumDimensions();
		
		$total = 0;
		for ($i = 0; $i < $numDimensions; $i++) {
			$total += pow(($pointB[$i] - $pointA[$i]), 2);
		}
		
		return sqrt($total);
		
	}
}
