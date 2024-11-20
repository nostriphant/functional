# functional-alternate
Functionally alternating logical paths

## Usage

```
use nostriphant\FunctionalAlternate\Alternate;

$state = Alternate::state1('Hello World!');

$evaluate = $state(state1: function (string $message) {
    yield $message;
});

foreach ($evaluate as $message) {
    expect($message)->toBe('Hello World!');
}

```