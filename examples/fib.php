<?php

require __DIR__.'/_run.php';

if (1 === $argc) {
    echo "Usage: php examples/fib.php NUMBER\n";
    exit(1);
}

$code = <<<EOF
(define fib (lambda (n)
    (if (< n 2)
        n
        (+ (fib (- n 1)) (fib (- n 2))))))
EOF;

$code .= sprintf('(fib %s)', (int) $argv[1]);

run($code);
