<?php

namespace nostriphant\FunctionalTests\IO;

use nostriphant\Functional\IO\Process;

it('can be initialized', function () {
    $process = new Process(function() {});
    expect($process)->toBeInstanceOf(Process::class);
});


it('receives an input channel', function () {
    $process = new Process(function($in) {
        expect(fread($in, 100))->toBe('Hello World');
    });
    
    $in = fopen('php://memory', 'w+');
    fwrite($in, 'Hello World');
    fseek($in, 0);
    
    $process($in);
});
