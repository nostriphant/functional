<?php

namespace nostriphant\FunctionalTests\IO;

use nostriphant\Functional\IO\Process;

it('process can be initialized', function () {
    $process = new Process(function() {});
    expect($process)->toBeInstanceOf(Process::class);
});
