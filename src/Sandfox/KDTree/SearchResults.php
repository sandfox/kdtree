<?php

namespace Sandfox\KDTree;

/**
 * Description of SearchResults
 *
 * @author sandfox
 */
class SearchResults
{
	/**
	 * [$results description]
	 * @var array
	 */
	protected $results = array();

	/**
	 * [$maxResults description]
	 * @var [type]
	 */
	protected $maxResults;

	/**
	 * [__construct description]
	 * @param integer $maxResults [description]
	 */
	public function __construct($maxResults = 1)
	{
		$this->maxResults = $maxResults;
	}

	/**
	 * [insertResult description]
	 * @param  [type] $node     [description]
	 * @param  [type] $distance [description]
	 * @return [type]           [description]
	 */
	public function insertResult($node, $distance)
	{
		$insertPoint = 0;
		$currentLastResultIndex = count($this->results) - 1;
		for($i = $currentLastResultIndex; $i >= 0; $i--) {

			$insertPoint = $i;
			if($distance > $this->results[$i]['distance']) {
				$insertPoint++;
				break;
			}
		}

		$insert = array(
					'distance' => $distance,
					'node' => $node
					);

		array_splice(
				$this->results,
				$insertPoint,
				0,
				array($insert)
				);

		if(count($this->results) > $this->maxResults) {
			array_pop($this->results);
		}

	}

	/**
	 * [getLastResultDistance description]
	 * @return [type] [description]
	 */
	public function getLastResultDistance() {
		$currentLastResultIndex = count($this->results) - 1;
		return $this->results[$currentLastResultIndex]['distance'];
	}

	/**
	 * [getNearestNode description]
	 * @return [type] [description]
	 */
	public function getNearestNode()
	{
		return $this->results[0];
	}

	/**
	 * [getResultDistances description]
	 * @return [type] [description]
	 */
	public function getResultDistances()
	{
		$results = array();
		foreach($this->results as $result) {
			$results[] = $result['distance'];
		}

		return $results;
	}

	/**
	 * [countResults description]
	 * @return [type] [description]
	 */
	public function countResults()
	{
		return count($this->results);
	}

	/**
	 * [_debugDistances description]
	 * @return [type] [description]
	 */
	protected function debugDistances()
	{
		//Fix this and make it loggable instead
		var_dump($this->getResultDistances());
	}
}


