<?php

namespace nostriphant\FunctionalTests;


it('only accept resource arguments', function($in, $out, $err) {
    $io = new \nostriphant\Functional\IO($in, $out, $err);
})->throws(\InvalidArgumentException::class)->with([
    ['in', fopen('php://memory', 'w'), fopen('php://memory', 'w')],
    [fopen('php://memory', 'r'), 'out', fopen('php://memory', 'w')],
    [fopen('php://memory', 'r'), fopen('php://memory', 'w'), 'err']
]);

