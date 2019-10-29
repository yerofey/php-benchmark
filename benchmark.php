<?php

/**
 * @param array $array
 */
function benchmark(array $array = [])
{
	if (empty($array)) {
		echo 'Benchmark | Error: empty data' . PHP_EOL;
		return;
	}

	if (!isMulti($array)) {
	    $array = [
	        $array
        ];
    }

	$benchmarks = [];
    $best_key = null;
    $results = [];
    $rows_count = 1;

    foreach ($array as $key => $value) {
        if (empty($value_func = $value['func'])) {
            continue;
        }

		$value_args = $value['args'] ?? [];
        if (!empty($value_args)) {
            if (!is_array($value_args)) {
                $value_args = explode(',', $value_args);
            } else {
                $value_args = [];
            }
        }

        $iterations = $value['repeats'] ?? 10000; // 10K runs by default
        $i = 0;
        $time_started = microtime(true);

        while ($i <= $iterations) {
			call_user_func_array($value_func, $value_args ?? []);
            $i++;
        }

        $time_finished = microtime(true);
        $runtime_total = $time_finished - $time_started;
        $runtime_single = $runtime_total / $iterations;

		$benchmarks[$key] = [
			'id'				=> $rows_count,
			'func_name' 		=> $value_func,
			'func_args' 		=> implode(',', $value_args),
			'runtime_single'	=> number_format($runtime_single, 10, '.', ','),
			'runtime_total'		=> number_format($runtime_total, 10, '.', ','),
			'iterations'		=> number_format($iterations, 0, '.', ','),
		];
        $results[$rows_count] = $runtime_single;
        $rows_count++;
    }

	// best result
	if (count($array) > 1) {
		$best_key = array_search(min($results), $results);
	}

	echo PHP_EOL;

	foreach ($benchmarks as $key => $value) {
		echo 'Benchmark | #' . $value['id'] . ': "' . $value['func_name'] . '(' . $value['func_args'] . ')" - ' . $value['runtime_single'] . 's (1); ' . $value['runtime_total'] . 's (' . $value['iterations'] . ')';

		if ($best_key && $best_key == $value['id']) {
			echo ' - the fastest!';
		}

		echo PHP_EOL;
	}

	echo PHP_EOL;
}

/**
 * @param $array
 * @return bool
 */
function isMulti($array) {
    $rv = array_filter($array,'is_array');
    if (count($rv) > 0) {
        return true;
    }
    return false;
}
