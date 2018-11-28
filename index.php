<?php

include __DIR__ . '/_benchmark.php';


$benchmark = [
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
];
benchmark($benchmark);
