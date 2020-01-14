<?php

/**
 * @author  Yerofey S. <hi@yerofey.ru>
 * @license MIT
 * @link    https://github.com/yerofey/php-benchmark
 * @version 1.0.3
 */

function benchmark(array $array = [])
{
    if (empty($array)) {
        echo 'Benchmark | Error: empty data' . PHP_EOL;
        return;
    }

    if (!is_multi_array($array)) {
        $array = [$array];
    }

    $benchmarks = [];
    $results = [];
    $rows_count = 1;
    $best_key = null;
    $worst_key = null;

    foreach ($array as $key => $value) {
        $value_func = $value['function'] ?? '';

        if (empty($value_func)) {
            continue;
        }

        if (empty($value['arguments'])) {
            $value_args = [];
        } else {
            $value_args = $value['arguments'] ?? [];

            if (!is_array($value_args)) {
                $value_args = explode(',', $value_args);
            }
        }

        $iterations = $value['iterations'] ?? 10000; // 10K runs by default
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
            'func_args' 		=> '"' . implode('","', array_values($value_args)) . '"',
            'runtime_single'	=> number_format($runtime_single, 10, '.', ','),
            'runtime_total'		=> number_format($runtime_total, 10, '.', ','),
            'iterations'		=> number_format($iterations, 0, '.', ','),
        ];

        $results[$rows_count] = number_format($runtime_single, 10, '.', '');
        $rows_count++;
    }

    // best result
    if ($rows_count > 1) {
        asort($results);
        $keys = array_keys($results);
        $best_key = $keys[0];
        $worst_key = $keys[count($keys) - 1];
    }

    echo PHP_EOL;

    foreach ($benchmarks as $key => $value) {
        echo 'Benchmark | #' . $value['id'] . ': ' . $value['func_name'] . '(' . $value['func_args'] . ') - ' . $value['runtime_single'] . 's (1); ' . $value['runtime_total'] . 's (' . $value['iterations'] . ')';

        if (isset($best_key) && $best_key == $value['id']) {
            echo ' - the fastest!';
        }

        if (isset($worst_key) && $worst_key == $value['id']) {
            echo ' - the slowest!';
        }

        echo PHP_EOL;
    }

    echo PHP_EOL;
}

// Function to check array is
// multi-dimensional or not
function is_multi_array($array)
{
    rsort($array);
    return isset($array[0]) && is_array($array[0]);
}
