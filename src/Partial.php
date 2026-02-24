<?php

namespace nostriphant\Functional;

class Partial {
    static function left(callable $f, mixed ...$partial_args) {
        return fn(mixed ...$args) => call_user_func($f, ...$partial_args, ...$args);
    }
    static function right(callable $f, mixed ...$partial_args) {
        return fn(mixed ...$args) => call_user_func($f, ...$args, ...$partial_args);
    }
}
