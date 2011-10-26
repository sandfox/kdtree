<?php


include 'src/KDTree/KDTree.php';
include 'src/KDTree/Node.php';
include 'src/KDTree/HyperRectangle.php';
include 'src/KDTree/Point.php';
include 'src/KDTree/SearchResults.php';


$points = array();


$factor = 2;
$dimensions = 2;
$numPoints = 60000;
$max = $numPoints * $factor;
$min = -$max;


for($i = 0; $i < $numPoints; $i++) {
	
	$point = new KDTree\Point;
	
	for($n = 0; $n < $dimensions; $n++) {
		$point[$n] = mt_rand($min, $max);
	}
	
	$points[] = $point;
	$max = $max - ($factor);
	$min = -$max;
}


echo "Building Tree\n";
$startTime = microtime(true);

$myTree = KDTree\KDTree::build($points);

$stopTime = microtime(true);
echo "Finished building tree in ".($stopTime - $startTime)." seconds\n\n";

$originPoint = new \KDTree\Point();

$originPoint[] = 50;
$originPoint[] = 20;

$results = new \KDTree\SearchResults(1);

echo "Finding nearest X nodes\n";
$startTime = microtime(true);

$result = KDTree\KDTree::nearestNeighbour($myTree, $originPoint, $results);

$stopTime = microtime(true);
echo "Finished search ".($stopTime - $startTime)." seconds\n\n";

$nearest = $results->getNearestNode();

var_dump($nearest['node']->point, $nearest['distance']);