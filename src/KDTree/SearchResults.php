<?php

namespace KDTree;

/**
 * Description of SearchResults
 *
 * @author grapple
 */
class SearchResults {
	
	protected $_results = array();
	protected $_maxResults;
	
	public function __construct($maxResults = 1)
	{
		$this->_maxResults = $maxResults;
	}
	
	public function insertResult($node, $distance)
	{
		$currentLastResultIndex = count($this->_results) - 1;
		for($i = $currentLastResultIndex; $i >= 0; $i--) {
			
			$insertPoint = $i;
			if($distance > $this->_results[$i]['distance']) {
				$insertPoint++;
				break;
			}
		}
		
		//echo "inserting $distance at $insertPoint \n";
		
		$insert = array(
					'distance' => $distance,
					'node' => $node
					);
		
		array_splice(
				$this->_results,
				$insertPoint,	
				0, 
				array($insert)
				);
		
		if(count($this->_results) > $this->_maxResults) {
			array_pop($this->_results);
		}
		
		//$this->_debugDistances();
		
	}
	
	public function getLastResultDistance() {
		$currentLastResultIndex = count($this->_results) - 1;
		return $this->_results[$currentLastResultIndex]['distance'];
	}
	
	public function getNearestNode()
	{
		return $this->_results[0];
	}
	
	public function getResultDistances()
	{
		$results = array();
		foreach($this->_results as $result) {
			$results[] = $result['distance'];
		}
		
		return $results;
	}
	
	protected function _debugDistances()
	{
		var_dump($this->getResultDistances());
	}
}


