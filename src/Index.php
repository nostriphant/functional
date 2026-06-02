<?php

namespace nostriphant\Functional;

final class Index implements \ArrayAccess {
   
    private array $index = [];
    
    public function __invoke(string $id, ?callable $callback = null) {
        if (isset($callback)) {
            $this->index[$id] = $callback;
        }
        return $this->index[$id] ?? fn() => null;
    }

    #[\Override]
    public function offsetExists(mixed $offset): bool {
        return array_key_exists($offset, $this->index);
    }

    #[\Override]
    public function offsetGet(mixed $offset): mixed {
        return $this->index[$offset];
    }

    #[\Override]
    public function offsetSet(mixed $offset, mixed $value): void {
        $this->index[$offset] = $value;
    }

    #[\Override]
    public function offsetUnset(mixed $offset): void {
        unset($this->index[$offset]);
    }
}
