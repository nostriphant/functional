<?php

namespace nostriphant\Functional;

class Partial {
    static function left(callable $f, mixed ...$partial_args) {
        return match($f instanceof \Closure) {
            true => fn(mixed ...$args) => call_user_func($f, ...$partial_args, ...$args),
            false => new (self::wrap_code($f::class, '...$this->partial_args, ...$args'))($f, $partial_args)
        };
    }
    static function right(callable $f, mixed ...$partial_args) {
        return match($f instanceof \Closure) {
            true => fn(mixed ...$args) => call_user_func($f, ...$args, ...$partial_args),
            false => new (self::wrap_code($f::class, '...$args, ...$this->partial_args'))($f, $partial_args)
        };
    }
    
    static function at(callable $f, int $position, ...$partial_args) {
        return match($f instanceof \Closure) {
            true => fn(mixed ...$args) => call_user_func($f, ...array_slice($args, 0, $position), ...$partial_args, ...array_slice($args, $position)),
            false => new (self::wrap_code($f::class, '...array_slice($args, 0, '.$position.'), ...$this->partial_args, ...array_slice($args, '.$position.')'))($f, $partial_args)
        };
    }
    
    public static function __callStatic(string $name, array $arguments): mixed {
        if (str_starts_with($name, 'at')) {
            $position = substr($name, 2);
            return self::at(array_shift($arguments), $position, ...$arguments);
        }
    }
    
    static function wrap_code(string $wrapped_class, string $apply_code) : string {
        $wrapper_class = '_'.uniqid();
            
        $reflection_class = (new \ReflectionClass($wrapped_class));
        
        
        
        $readonly = $reflection_class->isReadOnly();
        $return_type = $reflection_class->getMethod('__invoke')->getReturnType();
        
        eval(($readonly?'readonly ':'') . 'class ' . $wrapper_class . ' extends '. $wrapped_class .' {
                public function __construct(private mixed $f, private array $partial_args) {

                }
                
                public function __get(string $name) : mixed {
                    return (new \ReflectionObject($this->f))->getProperty($name)->getValue($this->f);
                }
                
                public function __invoke(...$args): '.$return_type.' {
                    return call_user_func($this->f, '.$apply_code.');
                }
            }');
        return $wrapper_class;
    }
}
