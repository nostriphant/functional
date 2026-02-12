<?php


namespace nostriphant\Functional;

class Iterator {

    static function map(\Traversable $iterator, callable $callback): \Traversable {
        foreach ($iterator as $key => $value) {
            yield $key => $callback($value);
        }
    }
    
    static function walk(\Traversable $iterator, callable $callback, mixed ...$args) {
        foreach ($iterator as $key => $element) {
            $callback($element, $key, ...$args);
        }
    }
    
    static function merge(\Traversable ...$iterators) : \Traversable {
        return new class($iterators) implements \IteratorAggregate {
           
            
            public function __construct(private array $iterators) {
            }
            
            public function getIterator(): \Traversable {
                foreach ($this->iterators as $iterator) {
                    foreach ($iterator as $entry) {
                        yield $entry;
                    }
                }
            }
        };
    }
}
