<?php

namespace nostriphant\Functional;

readonly class Alternate {

    private function __construct(
            public When $when
    ) {
        
    }

    static function __callStatic(string $name, array $arguments): self {
        return new self(new When(
            fn(callable ...$callbacks) => array_key_exists($name, $callbacks),
            function(callable ...$callbacks) use ($name, $arguments) { 
                yield from $callbacks[$name](...$arguments);
            }, 
            $name !== 'default' ? self::default(...$arguments) : function(callable ...$callbacks) { yield from []; }
        ));
    }

    public function __invoke(callable ...$callbacks) : \Generator {
        yield from ($this->when)(...$callbacks);
    }
}
