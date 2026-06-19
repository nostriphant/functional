<?php

namespace nostriphant\FunctionalTests;


it('only accept resource arguments', function() {
    $io = new \nostriphant\Functional\IO('in');
})->throws(\InvalidArgumentException::class);;