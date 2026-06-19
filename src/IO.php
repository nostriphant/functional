<?php

namespace nostriphant\Functional;

readonly class IO {
    
    public function __construct(public mixed $in = null, public mixed $out = null, public mixed $err = null) {
        if (isset($in) && is_resource($in) === false) {
            throw new \InvalidArgumentException('Argument $in should be of type resource');
        } elseif (isset($out) && is_resource($out) === false) {
            throw new \InvalidArgumentException('Argument $out should be of type resource');
        } elseif (isset($err) && is_resource($err) === false) {
            throw new \InvalidArgumentException('Argument $in should be of type resource');
        }
    }
    
  
    
}
