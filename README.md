# functional-alternate
Functional helper classes for nostriphant projects

## Usage

```
use nostriphant\Functional\Alternate;

$state = Alternate::state1('Hello World!');

$evaluate = $state(state1: function (string $message) {
    yield $message;
});

foreach ($evaluate as $message) {
    expect($message)->toBe('Hello World!');
}

```

### FunctionList
```
use nostriphant\Functional\FunctionList;

$list = new FunctionList(fn($x) => $x * 2);
$list2 = $list->bind(fn($x) => $x + 3);
expect($list2(2))->toBe([4, 5]);
```