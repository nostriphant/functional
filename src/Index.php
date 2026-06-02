<?php

namespace nostriphant\Functional;

final class Index {
   
    private array $index = [];
    
    public function __invoke(string $id, ?callable $callback = null) {
        if (isset($callback)) {
            $this->index[$id] = $callback;
        }
        return $this->index[$id] ?? fn() => null;
    }
}
