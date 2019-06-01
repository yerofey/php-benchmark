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

    $best_key = null;
    $results = [];
    $rows_count = 1;

    foreach ($array as $key => $value) {
        if (empty($value_func = $value['func'])) {
            continue;
        }

        $params_string = '';
        if (!empty($value_args = $value['args'])) {
            if (!is_array($value_args)) {
                $value_args = explode(',', $value_args);
            } else {
                $value_args = [];
            }

            $params_string = $value['args'];
        }

        $iterations = !empty($value['repeat']) ? $value['repeat'] : 1000000; // 1M runs by default
        $i = 0;
        $time_started = microtime(true);

        while ($i <= $iterations) {
            call_user_func_array($value_func, $value_args);
            //
            $i++;
        }

        $time_finished = microtime(true);
        $runtime_total = number_format($time_finished - $time_started, 4, '.', ',');
        $runtime_single = $runtime_total / $iterations;
        echo 'Benchmark | ' . $rows_count . ': "' . $value_func . '(' . $params_string . ')" - ';
        echo number_format($runtime_single, 10) . ' s (1); ';
        echo $runtime_total . ' s (' . number_format($iterations, 0, '.', ',') . ')';
        echo PHP_EOL;

        $results[$rows_count] = $runtime_single;

        $rows_count++;
    }

    // best result
    if (count($array) > 1) {
        $best_key = array_search(min($results), $results);
        echo 'Benchmark | "' . $array[$best_key - 1]['func'] . '" - the fastest' . PHP_EOL;
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
