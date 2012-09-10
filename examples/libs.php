<?php

/**
 * Generates points to build a KDtree with
 * @param  integer  $totalPoints   total number of points to generate
 * @param  integer $numDimensions The number of dimensions these points exist in
 * @param  integer $yFactor       Factor for roughly how spread apart the fartest points will be
 * @return array                 Array of points
 */
function generatePoints($totalPoints, $numDimensions = 2, $yFactor = 2)
{
	$points = array();

	$max = $totalPoints * $yFactor;
	$min = -$max;

	for($i = 0; $i < $totalPoints; $i++) {

		$point = new Sandfox\KDTree\Point;

		for($n = 0; $n < $numDimensions; $n++) {
			$point[$n] = mt_rand($min, $max);
		}

		$points[] = $point;
		$max = $max - ($yFactor);
		$min = -$max;
	}

	return $points;
}

/**
 * Caches a node and all of its children
 * @param  Sandfox\KDTree\Node $node The node you would like cached
 * @return integer/bool                    number of bytes written when caching or false if caching failed
 */
function cacheTree(Sandfox\KDTree\Node $node)
{
	$data = serialize($node);

	return file_put_contents('TreeCache.dat', $data);
}

/**
 * Returned the cached tree if found as a node
 * @return [type] [description]
 */
function getCachedTree()
{
	if(file_exists('TreeCache.dat')) {
		return unserialize(file_get_contents('TreeCache.dat'));
	} else {
		return;
	}
}