<?php

namespace nostriphant\FunctionalTests;

use nostriphant\Functional\Alternate;

Pest::extend('expect');

it('usage works', function () {
    $state = Alternate::state1('Hello World!');

    $evaluate = $state(state1: function (string $message) {
        yield $message;
    });

    foreach ($evaluate as $messages => $message) {
        expect($message)->toBe('Hello World!');
    }
    expect($messages)->toBe(0);
});

it('default works', function () {
    $state = Alternate::state1('Hello Wsfsdfdforld!');

    $evaluate = $state(default: function (string $message) {
        yield 'Hello World!';
    });

    foreach ($evaluate as $messages => $message) {
        expect($message)->toBe('Hello World!');
    }
    expect($messages)->toBe(0);
});

it('can alternate execution paths', function () {
    $alternate = Alternate::first('Hello World');
    expect($alternate)->toHaveState(first: ['Hello World']);
    expect($alternate)->not()->toHaveState(second: ['Hello World']);
});

it('ignores undefined execution paths', function () {
    $alternate = Alternate::second('Hello World');
    foreach ($alternate() as $msgs => $msg) {

    }
})->throwsNoExceptions();

it('can fallback to a default execution paths', function () {
    $alternate = Alternate::first('Hello World');
    expect($alternate)->toHaveState(default: ['Hello World']);
});
