<?php

namespace nostriphant\Functional;

readonly class Functions {
    
    static function iterator_map(\Traversable $iterator, callable $callback): \Traversable {
        foreach ($iterator as $key => $value) {
            yield $key => $callback($value);
        }
    }
    
    static function iterator_merge(\Traversable ...$iterators) : \Traversable {
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

    static function in_range(string|int|float $value, string|int|float $start, string|int|float $end, int|float $step = 1): bool {
        return in_array($value, range($start, $end, $step));
    }
    
}