<?php

namespace Sandfox\KDTree;

/**
 * Description of SearchResults
 *
 * @author sandfox
 */
class SearchResults extends \SplPriorityQueue
{

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
		$this->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
	}

	public function compare($distanceA, $distanceB)
	{
		return $distanceB - $distanceA;
	}

	/**
	 * [insertResult description]
	 * @param  [type] $node     [description]
	 * @param  [type] $distance [description]
	 * @return [type]           [description]
	 */
	public function insertResult($node, $distance)
	{
		$this->insert($node, $distance);
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
	public function showNearestNode()
	{
		return $this->top();
	}

	/**
	 * [countResults description]
	 * @return [type] [description]
	 */
	public function countResults()
	{
		return $this->count();
	}
}


