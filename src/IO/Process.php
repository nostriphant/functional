<?php
declare(strict_types=1);

namespace nostriphant\functional\IO;

readonly class Process {
        
    public function __construct(private mixed $in) {

    }
    
    public function __invoke(callable $process):void {
        $bound_process = \Closure::bind($process, $this, self::class);
        $bound_process();
    }
    
}
