<?php
declare(strict_types=1);

namespace nostriphant\functional\IO;

readonly class ProcessEnvironment {
    
    private array $env;
        
    public function __construct(private \nostriphant\Functional\IO $io, string ...$env) {
        $this->env = $env;
    }
    
    public function __invoke(callable $process):void {
        $bound_process = \Closure::bind($process, $this, self::class);
        $bound_process();
    }
    
}
