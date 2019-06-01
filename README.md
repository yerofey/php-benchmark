# php_benchmark


Example result: <br>
Benchmark | 1: "mt_rand(1, 10)" - 0.0000001120 s (1); 0.1120 s (1,000,000)<br>
Benchmark | 2: "rand(1, 10)" - 0.0000001106 s (1); 0.1106 s (1,000,000)<br>
Benchmark | 3: "intval(1, 10)" - 0.0000000967 s (1); 0.0967 s (1,000,000)<br>
Benchmark | "intval" - the fastest<br>
