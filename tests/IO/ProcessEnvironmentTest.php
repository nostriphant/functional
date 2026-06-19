<?php

namespace nostriphant\FunctionalTests\IO;

use nostriphant\Functional\IO\ProcessEnvironment;

it('can be initialized', function () {
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO());
    expect($process)->toBeInstanceOf(ProcessEnvironment::class);
});


it('receives an input channel', function () {
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO($in));
    
    $process(function() {
        expect(fread($this->in, 100))->toBe('Hello World');
    });
});

it('receives environment variables', function () {
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO($in), [], ENV_VAR: 'foo');
    
    $process(function() {
        expect($this->env['ENV_VAR'])->toBe('foo');
    });
});

it('receives arguments', function () {
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO($in), ['foo', 'bar']);
    
    $process(function(string $arg1, string $arg2) {
        expect($arg1)->toBe('foo');
        expect($arg2)->toBe('bar');
    });
});

it('prints output to the out stream', function () {
    $out = fopen('php://memory', 'w+');
    
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO(out:$out), ['foo', 'bar']);
    
    $process(function(string $arg1, string $arg2) {
        print 'Output';
    });
    
    fseek($out, 0);
    expect(fread($out, 100))->toBe('Output');
});


it('prints exceptions to the error stream', function () {
    $error = fopen('php://memory', 'w+');
    
    $process = new ProcessEnvironment(new \nostriphant\Functional\IO(err:$error), ['foo', 'bar']);
    
    $process(function(string $arg1, string $arg2) {
        throw new \Exception('Error');
    });
    
    fseek($error, 0);
    expect(fread($error, 100))->toBe('Error');
});