<?php

namespace nostriphant\Functional\IO;

class Process {
    
    public function __construct(public \nostriphant\Functional\IO $io, private string $cwd, private array $env) {
        
    }
    
    public function __invoke(string ...$cmd): mixed {
        $process = proc_open($cmd, [$this->io->in, $this->io->out, $this->io->err], $pipes, $this->cwd, $this->env);
        
        
        if ($process === false) {
            return fn() => null;
        }
        
        return new class($process) {
            public string $pid;
            public function __construct(private $process) {
                $this->pid = proc_get_status($process)['pid'];
            }
            public function __invoke(int $signal = 15): void {
                proc_terminate($this->process, $signal);
                proc_close($this->process);;
            }
        };
    }
    
}
