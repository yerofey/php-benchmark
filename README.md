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
        'repeats' => 1000,
    ],
	[
        'func'    => 'rand',
        'args'    => '1, 10',
        'repeats' => 1000,
    ],
	[
        'func'    => 'intval',
        'args'    => '1, 10',
        'repeats' => 1000,
    ],
]);
```

<b>Example result:</b> <br>
Benchmark | 1: "mt_rand(1, 10)" - 0.0000001104 s (1); 0.1104 s (1,000,000)
<br><br>
Benchmark | 1: "mt_rand(1, 10)" - 0.0000001139 s (1); 0.1139 s (1,000,000)<br>
Benchmark | 2: "rand(1, 10)" - 0.0000001119 s (1); 0.1119 s (1,000,000)<br>
Benchmark | 3: "intval(1, 10)" - 0.0000000970 s (1); 0.0970 s (1,000,000)<br>
Benchmark | "intval" - the fastest
