<?php

// Y-combinator
// thanks to the little schemer

$code = <<<EOF
(define Y
  (lambda (le)
    ((lambda (f) (f f))
     (lambda (f)
        (le (lambda (x) ((f f) x)))))))

(define length
  (Y (lambda (length)
    (lambda (l)
        (cond
            ((eq? l '()) 0)
            (#else (+ 1 (length (cdr l)))))))))

(length '(a b c))
EOF;

require __DIR__.'/_run.php';
run($code);
