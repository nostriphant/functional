<?php
declare(strict_types=1);

namespace nostriphant\functional\IO;

readonly class Process {
    
    private array $env;
        
    public function __construct(private mixed $in, string ...$env) {
        $this->env = $env;
    }
    
    public function __invoke(callable $process):void {
        $bound_process = \Closure::bind($process, $this, self::class);
        $bound_process();
    }
    
}
