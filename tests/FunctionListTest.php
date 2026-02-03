<?php

namespace nostriphant\FunctionalTests;

use nostriphant\Functional\FunctionList;

Pest::extend('expect');

it('can map list', function () {
    $list = new FunctionList(fn($x) => $x * 2);
    
    expect($list(2))->toBe([4]);
});


it('can add items later', function () {
    $list = new FunctionList(fn($x) => $x * 2);
    $list2 = $list->bind(fn($x) => $x + 3);
    expect($list2(2))->toBe([4, 5]);
});