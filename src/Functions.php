<?php

namespace nostriphant\Functional;

readonly class Functions {
    

    static function in_range(string|int|float $value, string|int|float $start, string|int|float $end, int|float $step = 1): bool {
        return in_array($value, range($start, $end, $step));
    }
    
    /**
     * 
     * @deprecated 2.6.0
     * @see \nostriphant\FunctionalIterator::map
     */
    static function iterator_map(\Traversable $iterator, callable $callback): \Traversable {
        return Iterator::map($iterator, $callback);
    }
    
    /**
     * 
     * @deprecated 2.6.0
     * @see \nostriphant\FunctionalIterator::walk
     */
    static function iterator_walk(\Traversable $iterator, callable $callback, mixed ...$args) {
        return Iterator::walk($iterator, $callback, ...$args);
    }
    
    /**
     * 
     * @deprecated 2.6.0
     * @see \nostriphant\FunctionalIterator::merge
     */
    static function iterator_merge(\Traversable ...$iterators) : \Traversable {
        return Iterator::merge(...$iterators);
    }
    
}