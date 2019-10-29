# php_benchmark

<b>Usage example:</b>
```php
<?php

include __DIR__ . '/benchmark.php';


// You can test a single function
benchmark([
    'func'    => 'mt_rand',
    'args'    => '1, 10',
    'repeats' => 1000,
]);

// Or a lot of functions to compare the results
benchmark([
	[
        'func'    => 'mt_rand',
        'args'    => '1, 10',
        'repeats' => 10000,
    ],
	[
        'func'    => 'rand',
        'args'    => '1, 10',
        'repeats' => 10000,
    ],
	[
        'func'    => 'intval',
        'args'    => '1, 10',
        'repeats' => 10000,
    ],
]);
```

<b>Example result:</b> <br>
Benchmark | #1: "mt_rand(1, 10000)" - 0.0000002217s (1); 0.0022s (10,000) <br>
Benchmark | #2: "rand(1, 10000)" - 0.0000002085s (1); 0.0021s (10,000) <br>
Benchmark | #3: "intval(1, 10000)" - 0.0000001462s (1); 0.0015s (10,000) - the fastest! <br>
