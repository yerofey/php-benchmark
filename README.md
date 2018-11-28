# php_benchmark


Example result: <br>
Benchmark | 0 - "mt_rand(1, 10)" - 0.0000001180 (1); 0.1180 (1,000,000) <br>
Benchmark | 1 - "rand(1, 10)" - 0.0000001203 (1); 0.1203 (1,000,000) <br>
Benchmark | 2 - "intval(1, 10)" - 0.0000001027 (1); 0.1027 (1,000,000) <br>
Benchmark | Best - "intval" <br>
