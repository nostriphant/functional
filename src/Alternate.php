<?php

namespace nostriphant\Functional;

readonly class Alternate {

    private function __construct(
            public \Closure $callback
    ) {
        
    }

    static function __callStatic(string $name, array $arguments): When {
        $when = new When(
            fn(callable ...$callbacks) => isset($callbacks[$name]), 
            function(callable ...$callbacks) use ($name, $arguments) { 
                yield from $callbacks[$name](...$arguments);
            }, 
                    
            function(callable ...$callbacks) use ($arguments) { 
                if (array_key_exists('default', $callbacks) === false) {
                    yield from [];
                } else {
                    yield from $callbacks['default'](...$arguments);
                }
            });
        return $when;
    }

    public function __invoke(callable ...$callbacks) {
        yield from ($this->callback)(...$callbacks);
    }
}
