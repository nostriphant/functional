<?php

namespace nostriphant\FunctionalTests;


it('partially applies arguments left', function () {
    $f = fn(int $a, int $b) => $a - $b;
    
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(-1);
});

it('partially applies arguments right', function () {
    $f = fn(int $a, int $b) => $a - $b;
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(3);
});
