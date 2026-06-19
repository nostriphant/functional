<?php
declare(strict_types=1);

namespace nostriphant\functional\IO;

readonly class ProcessEnvironment {
    
    private array $env;
        
    public function __construct(private \nostriphant\Functional\IO $io, private array $arguments = [], string ...$env) {
        $this->env = $env;
    }
    
    public function __invoke(callable $callback) : void {
        $bound_process = \Closure::bind($callback, $process = new class($this->io->in, $this->env) {
            public function __construct(private mixed $in, private array $env) {
            }
        }, $process);
        $bound_process(...$this->arguments);
    }
    
}
