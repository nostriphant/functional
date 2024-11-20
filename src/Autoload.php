<?php

namespace nostriphant\FunctionalAlternate;

expect()->extend('toHaveState', function (mixed ...$expected_state) {
    foreach (call_user_func_array($this->value, $state_mocks = generate_state_mocks(...$expected_state)) as $msg) {
        
    }
    check_state_mocks($state_mocks);
});

function generate_state_mocks(mixed ...$expected_states) {
    return array_map(fn(mixed $expected_args) => new class($expected_args) {

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
}

function check_state_mocks(array $state_mocks) {
    expect(array_reduce($state_mocks, fn(bool $carry, $mock) => $mock->invoked || $carry, false))->toBeTrue();
}
