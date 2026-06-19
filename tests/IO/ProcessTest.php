<?php

namespace nostriphant\FunctionalTests\IO;

use nostriphant\Functional\IO\Process;

it('can be initialized', function () {
    $process = new Process(function() {});
    expect($process)->toBeInstanceOf(Process::class);
});


it('receives an input channel', function () {
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process = new Process($in);
    
    $process(function() {
        expect(fread($this->in, 100))->toBe('Hello World');
    });
});



it('receives environment variables', function () {
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process = new Process($in, ENV_VAR: 'foo');
    
    $process(function() {
        expect($this->env['ENV_VAR'])->toBe('foo');
    });
});
