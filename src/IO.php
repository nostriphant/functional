<?php

namespace nostriphant\Functional;

readonly class IO {
    
    public function __construct(public mixed $in = null, public mixed $out = null, public mixed $err = null) {
        foreach (func_get_args() as $arg => $value) {
            if (isset($value) && is_resource($value) === false) {
                throw new \InvalidArgumentException('Argument $arg should be of type resource');
            }
        }
    }
}
