<?php

namespace nostriphant\Functional;

readonly class IO {
    
    public function __construct(public mixed $in = null) {
        if (is_resource($in) === false) {
            throw new \InvalidArgumentException('Argument $in should be of type resource');
        }
    }
    
}
