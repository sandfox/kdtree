<?php

namespace Sandfox\KDTree;

/**
 * A (loosely) bounded priority queue for search results
 * Nearest node is at bottom of heap
 * Is iterable and throw out furthest node first
 * 'data' is the node, 'priority' is the distance
 *
 * @author sandfox
 */
class SearchResults extends \SplPriorityQueue
{

	/**
	 * Max size for the queue
	 * @var [type]
	 */
	protected $maxResults;

	/**
	 * [__construct description]
	 * @param integer $maxResults the maximum number of results the queue should hold
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
	 * @param  Node $node     [description]
	 * @param  [type] $distance [description]
	 * @return  null           [description]
	 */
	public function insertResult(Node $node, $distance)
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
	 * NOTE - This requires emptying the queue
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
	 * Here for legacy reasons - depreciate me
	 * @return [type] [description]
	 */
	public function countResults()
	{
		return $this->count();
	}
}


