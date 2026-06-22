<?php

namespace nostriphant\Functional;

readonly class IO {
    
    public mixed $in;
    public mixed $out;
    public mixed $err;
    
    public function __construct(mixed $in = null, mixed $out = null, mixed $err = null) {
        $this->in = $in ?? fopen('php://temp', 'w+');
        if (is_resource($this->in) === false) {
            throw new \InvalidArgumentException('Argument $in should be of type resource');
        }
        
        $this->out = $out ?? fopen('php://temp', 'w+');
        if (is_resource($this->out) === false) {
            throw new \InvalidArgumentException('Argument $out should be of type resource');
        }
        
        $this->err = $err ?? fopen('php://temp', 'w+');
        if (is_resource($this->err) === false) {
            throw new \InvalidArgumentException('Argument $err should be of type resource');
        }
    }
}
