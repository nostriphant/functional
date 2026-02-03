<?php


namespace nostriphant\Functional;


readonly class FunctionList {
    
    private array $functions;
    
    public function __construct(callable ...$functions) {
        $this->functions = $functions;
    }
    
    public function bind(callable $function) : self {
        $functions = $this->functions;
        $functions[] = $function;
        return new self(...$functions);
    }
    
    public function __invoke(mixed ...$args): mixed {
        return array_map(fn(callable $function) => $function(...$args), $this->functions);
    }
    
}
