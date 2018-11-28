<?php

/**
 * @param array $benchmark
 */
function benchmark(array $benchmark = [])
{
	if (empty($benchmark)) {
		echo 'Benchmark | Error: empty benchmark array' . PHP_EOL;
		return;
	}

	if (is_array($benchmark)) {
		$best_key = null;
		$results = [];
		$save_best = count($benchmark) > 0 ? true : false;

		$i = 0;

		foreach ($benchmark as $key => $value) {
			if (empty($value_func = $value['func'])) {
				continue;
			}

			if (!empty($value_args = $value['args'])) {
				if (!is_array($value_args)) {
					$value_args = explode(',', $value_args);
				} else {
					$value_args = [];
				}
			}

			$benchmark_iterations = $value['repeat'] ?? 1000000;
			$benchmark_i = 0;
			$benchmark_start = microtime(true);

			while ($benchmark_i <= $benchmark_iterations) {
				call_user_func_array($value_func, $value_args);
				//
				$benchmark_i++;
			}

			$benchmark_end = microtime(true);
			$benchmark_runtime_total = number_format($benchmark_end - $benchmark_start, 4, '.', ',');
			$benchmark_runtime_single = $benchmark_runtime_total / $benchmark_iterations;
			echo 'Benchmark | ' . $i . ' - "' . $value_func . '(' . ($value['args'] ?? '') . ')" - ';
			echo number_format($benchmark_runtime_single, 10) . ' (1); ';
			echo $benchmark_runtime_total . ' (' . number_format($benchmark_iterations, 0, '.', ',') . ')';
			echo PHP_EOL;

			if ($save_best) {
				$results[$i] = $benchmark_runtime_single;
			}

			$i++;
		}

		// best result
		if ($save_best) {
			$best_key = array_search(min($results), $results);
			echo 'Benchmark | Best - "' . $benchmark[$best_key]['func'] . '"' . PHP_EOL;
		}
	}
}
