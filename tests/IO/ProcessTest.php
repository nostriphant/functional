<?php

it('starts a process', function() {
    $process = new \nostriphant\Functional\IO\Process(new nostriphant\Functional\IO(), getcwd(), []);
    $kill = $process(PHP_BINARY);
    
    expect('/proc/' . $kill->pid)->toBeFile();
    
    $kill();
    
    expect('/proc/' . $kill->pid)->not()->toBeFile();
    
});