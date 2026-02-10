<?php

namespace nostriphant\Functional;

readonly class Alternate {

    private function __construct(
            public \Closure $callback
    ) {
        
    }

    static function __callStatic(string $name, array $arguments): When {
        return new When(
            fn(callable ...$callbacks) => array_key_exists($name, $callbacks),
            function(callable ...$callbacks) use ($name, $arguments) { 
                yield from $callbacks[$name](...$arguments);
            }, 
            new When(
                fn(...$callbacks) => array_key_exists('default', $callbacks), 
                function(callable $default) use ($arguments) {
                    yield from $default(...$arguments);
                }, 
                function() { yield from []; })
            );
    }

    public function __invoke(callable ...$callbacks) {
        yield from ($this->callback)(...$callbacks);
    }
}
