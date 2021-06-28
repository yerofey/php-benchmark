<?php

include __DIR__ . '/src/benchmark.php';


// you can test a single function
// benchmark([
//     'function' 		=> 'mt_rand',
//     'arguments'		=> '1, 9999999999',
//     'iterations'	=> 1000,
// ]);

// or a lot of functions to compare the results
benchmark([
	[
        'function' 		=> 'mt_rand',
        'arguments'		=> '1, 9999999999',
        'iterations'	=> 1000,
    ],
	[
        'function' 		=> 'rand',
        'arguments'		=> '1, 9999999999',
        'iterations'	=> 1000,
    ],
	[
        'function' 		=> 'intval',
        'arguments'		=> '1, 9999999999',
        'iterations'	=> 1000,
    ],
]);
