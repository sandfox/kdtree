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

	//closest item is at bottom of queue
	public function compare($distanceA, $distanceB)
	{
		return $distanceA - $distanceB;
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

		if($this->count() > $this->maxResults) {
			$this->extract();
		}
	}

	/**
	 * Returns the distance of the top (farthest) node in the heap
	 * @return [type] [description]
	 */
	public function getLastResultDistance() {
		return $this->top()['priority'];
	}

	/**
	 * This requires emptying the queue
	 * @return [type] [description]
	 */
	public function getNearestNode()
	{
		while($this->valid()){
			$retval = $this->extract();
		};

		return $retval;
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


