<?php
declare(strict_types=1);

namespace nostriphant\functional\IO;

readonly class Process {
    
    private \Closure $process;
    
    public function __construct(callable $process) {
        $this->process = \Closure::fromCallable($process);
    }
    
    public function __invoke($in):void {
        call_user_func($this->process, $in);
        
    }
    
}
