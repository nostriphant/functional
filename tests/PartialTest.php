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

class Substract {
    public function __construct(public int $a) {
    }
    
    public function __invoke(int $a, int $b): mixed {
        return $this->a - $a - $b;
    }
}

it('partially applies arguments left (type hinting safe)', function () {
    $f = new Substract(10);
    
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(7);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});
it('partially applies arguments right (type hinting safe)', function () {
    $f = new Substract(10);
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(5);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});

readonly class SubstractRO {
    public function __construct(public int $a) {
    }
    
    public function __invoke(int $a, int $b): mixed {
        return $this->a - $a - $b;
    }
}

it('partially applies arguments left (readonly, type hinting safe)', function () {
    $f = new SubstractRO(10);
    
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(7);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});
it('partially applies arguments right (readonly, type hinting safe)', function () {
    $f = new SubstractRO(10);
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(5);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});