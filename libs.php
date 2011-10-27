<?php


function generatePoints($totalPoints, $numDimensions = 2, $yFactor = 2)
{
	$points = array();
	
	$max = $totalPoints * $yFactor;
	$min = -$max;
	
	for($i = 0; $i < $totalPoints; $i++) {
	
		$point = new KDTree\Point;

		for($n = 0; $n < $numDimensions; $n++) {
			$point[$n] = mt_rand($min, $max);
		}

		$points[] = $point;
		$max = $max - ($yFactor);
		$min = -$max;
	}
	
	return $points;
}

function cacheTree(KDTree\Node $node)
{
	$data = serialize($node);
	
	return file_put_contents('TreeCache.dat', $data);
}

function getCachedTree()
{
	if(file_exists('TreeCache.dat')) {
		$data = file_get_contents('TreeCache.dat');
	} else {
		return;
	}
	
	return unserialize($data);
}