<?php

use Sandfox\KDTree;

//This assumes you have cloned this repo and run composer dumpautoload
require_once '../vendor/autoload.php';
require_once 'libs.php';

$tree = new Sandfox\KDTree\Point();


$yFactor = 3;
$numDimensions = 4;
$totalPoints = 100000;

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

$originPoint[] = 0;
$originPoint[] = 30;
//$originPoint[] = -1;




$results = new KDTree\SearchResults(5000);

echo "Finding nearest X nodes\n";
$startTime = microtime(true);

$result = KDTree\KDTree::nearestNeighbour($myTree, $originPoint, $results);

$stopTime = microtime(true);
echo "Finished search ".($stopTime - $startTime)." seconds\n\n";

var_dump($results->countResults());

$nearest = $results->getNearestNode();

var_dump($nearest['data']->getPoint(), $nearest['priority']);


