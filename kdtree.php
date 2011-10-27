<?php


include 'src/KDTree/KDTree.php';
include 'src/KDTree/Node.php';
include 'src/KDTree/HyperRectangle.php';
include 'src/KDTree/Point.php';
include 'src/KDTree/SearchResults.php';

include 'libs.php';


$yFactor = 3;
$numDimensions = 2;
$totalPoints = 60000;

echo "Getting cached tree\n";
$cacheFindStartTime = microtime(true);
$myTree = getCachedTree();

if($myTree === null) {
	echo "No cached tree found\n";
	

	$points = generatePoints($totalPoints, $numDimensions, $yFactor);

	echo "Building tree\n";
	$startTime = microtime(true);

	$myTree = KDTree\KDTree::build($points);

	$stopTime = microtime(true);
	echo "Finished building tree in ".($stopTime - $startTime)." seconds\n\n";
	
	echo "Caching tree\n";
	$cacheWriteStartTime = microtime(true);
	cacheTree($myTree);
	$cacheWriteStopTime = microtime(true);
	echo "Finished caching tree in ".($cacheWriteStopTime - $cacheWriteStartTime)." seconds\n";
	
} else {
	$cacheFindStopTime = microtime(true);
	echo "Cache unserialized in ".($cacheFindStopTime - $cacheFindStartTime)." seconds\n";
}



$originPoint = new KDTree\Point();

$originPoint[] = 50;
$originPoint[] = 20;
$originPoint[] = 30;




$results = new KDTree\SearchResults(1);

echo "Finding nearest X nodes\n";
$startTime = microtime(true);

$result = KDTree\KDTree::nearestNeighbour($myTree, $originPoint, $results);

$stopTime = microtime(true);
echo "Finished search ".($stopTime - $startTime)." seconds\n\n";

$nearest = $results->getNearestNode();

var_dump($nearest['node']->point, $nearest['distance']);