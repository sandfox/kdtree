<?php


include 'src/KDTree/KDTree.php';
include 'src/KDTree/Node.php';
include 'src/KDTree/HyperRectangle.php';
include 'src/KDTree/Point.php';
include 'src/KDTree/SearchResults.php';


$points = array();


$factor = 2;
$dimensions = 2;
$numPoints = 20000;
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


/*
$point = new \KDTree\Point();
$point[] = 10;
$point[] = 10;
$points[] = $point;

$point = new \KDTree\Point();
$point[] = 20;
$point[] = 20;
$points[] = $point;

$point = new \KDTree\Point();
$point[] = 30;
$point[] = 30;
$points[] = $point;

$point = new \KDTree\Point();
$point[] = 40;
$point[] = 40;
$points[] = $point;
*/

echo "Building Tree";
$startTime = microtime();

$myTree = KDTree\KDTree::build($points);

$stopTime - microtime();
echo "Finished building tree in ".$stopTime - $startTime." microseconds";

$originPoint = new \KDTree\Point();

$originPoint[] = 50;
$originPoint[] = 20;

$results = new \KDTree\SearchResults(5);

$depth = 0;

$result = KDTree\KDTree::nearestNeighbour($myTree, $originPoint, $depth, $results);

$nearest = $results->getNearestNode();

var_dump($nearest['node']->point, $nearest['distance']);