<?php

include __DIR__ . '/benchmark.php';


// You can test a single function
benchmark([
    'function' 		=> 'mt_rand',
    'arguments'		=> '1, 10',
    'iterations'	=> 1000,
]);

// Or a lot of functions to compare the results
benchmark([
	[
        'function' 		=> 'mt_rand',
        'arguments'		=> '1, 10',
        'iterations'	=> 1000,
    ],
	[
        'function' 		=> 'rand',
        'arguments'		=> '1, 10',
        'iterations'	=> 1000,
    ],
	[
        'function' 		=> 'intval',
        'arguments'		=> '1, 10',
        'iterations'	=> 1000,
    ],
]);
