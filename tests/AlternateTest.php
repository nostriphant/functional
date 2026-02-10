<?php

namespace nostriphant\FunctionalTests;

use nostriphant\Functional\Alternate;

expect()->extend('toHaveState', function (mixed ...$expected_states) {
    $state_mocks = array_map(fn(mixed $expected_args) => new class($expected_args) {

                public bool $invoked = false;

                public function __construct(private array|string $expected_args) {

                }

                public function __invoke(mixed ...$args): \Generator {
                    if (is_array($this->expected_args)) {
                        foreach ($this->expected_args as $index => $expected_arg) {
                            expect($args[$index])->toBe($expected_arg);
                        }
                    } elseif ($this->expected_args === '*') {
                        // accept everything!
                    }
                    $this->invoked = true;
                    yield 0;
                }
            }, $expected_states);

    foreach (call_user_func_array($this->value, $state_mocks) as $msg) {

    }
    expect(array_reduce($state_mocks, fn(bool $carry, $mock) => $mock->invoked || $carry, false))->toBeTrue();
});

it('usage works', function () {
    $state = Alternate::state1('Hello World!');

    $evaluate = $state(state1: function (string $message) {
        yield $message;
    });

    foreach ($evaluate as $message) {
        expect($message)->toBe('Hello World!');
    }
});

it('can alternate execution paths', function () {
    $alternate = Alternate::first('Hello World');
    expect($alternate)->toHaveState(first: ['Hello World']);
    expect($alternate)->not()->toHaveState(second: ['Hello World']);
});

it('ignores undefined execution paths', function () {
    $alternate = Alternate::second('Hello World');
    foreach ($alternate() as $msg) {

    }
})->throwsNoExceptions();

it('can fallback to a default execution paths', function () {
    $alternate = Alternate::first('Hello World');
    expect($alternate)->toHaveState(default: ['Hello World']);
});
