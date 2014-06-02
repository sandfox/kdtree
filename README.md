# KDTree


This is a very simple and probably non-efficient implementation of KD-Trees for PHP. At the moment this mostly just a proof of concept.
It's slightly buggy and needs some more tests written for it. Later I plan on either making this faster or producing a fast (and probably ugly) version for production usage. In the meantine if you require a speedy implementation I strongly suggest using an another language for this (node.js, C/C++, Go).

Pull Requests are more than welcome

For a road map please see the issues tracker.

Now uses a bounded SPL priority queue for results making things daftly faster when returning large result sets for nearest neigbour searches

## Installation


As this is the 21st century please use composer to install this
```bash
composer install sandfox/kdtree
```

## Usage

TO DO

## Developmet

## Tests

To run the tests

```bash
make test
```
