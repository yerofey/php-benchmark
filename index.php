<?php

include __DIR__ . '/benchmark.php';


// You can test a single function
benchmark([
    'func' 		=> 'mt_rand',
    'args'		=> '1, 10',
    'repeats'	=> 1000,
]);

// Or a lot of functions to compare the results
benchmark([
	[
        'func' 		=> 'mt_rand',
        'args'		=> '1, 10',
        'repeats'	=> 1000,
    ],
	[
        'func' 		=> 'rand',
        'args'		=> '1, 10',
        'repeats'	=> 1000,
    ],
	[
        'func' 		=> 'intval',
        'args'		=> '1, 10',
        'repeats'	=> 1000,
    ],
]);
