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
        $new_array = [];

        foreach ($array as $value) {
            $new_array[] = $value;
        }

        $array = $new_array;
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
        $results[$rows_count] = $runtime_single;
        $rows_count++;
    }

    // best result
    if (count($array) > 1) {
        $best_key = array_search(min($results), $results);
        $worst_key = array_search(max($results), $results);
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
