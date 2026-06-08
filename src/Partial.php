<?php

namespace nostriphant\Functional;

class Partial {
    static function left(callable $f, mixed ...$partial_args) {
        return match($f instanceof \Closure) {
            true => fn(mixed ...$args) => call_user_func($f, ...$partial_args, ...$args),
            false => new (self::wrap_code(get_class($f), '...$this->partial_args, ...$args'))($f, $partial_args)
        };
    }
    static function right(callable $f, mixed ...$partial_args) {
        return match($f instanceof \Closure) {
            true => fn(mixed ...$args) => call_user_func($f, ...$args, ...$partial_args),
            false => new (self::wrap_code(get_class($f), '...$args, ...$this->partial_args'))($f, $partial_args)
        };
    }
    
    static function wrap_code(string $wrapped_class, string $apply_code) : string {
            $wrapper_class = '_'.uniqid();
        eval('class ' . $wrapper_class . ' extends '. $wrapped_class .' {
                function __construct(private $f, private $partial_args) {
                
                }
                public function __invoke(...$args): mixed {
                    return call_user_func($this->f, '.$apply_code.');
                }
            }');
        return $wrapper_class;
    }
}
