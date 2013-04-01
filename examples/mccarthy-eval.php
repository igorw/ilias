<?php

// based on http://lib.store.yahoo.net/lib/paulgraham/jmc.lisp
//
// The Lisp defined in McCarthy's 1960 paper, translated into CL.
// Assumes only quote, atom, eq, cons, car, cdr, cond.

$code = <<<EOF
(define caar
    (lambda (l)
        (car (car l))))

(define cadr
    (lambda (l)
        (car (cdr l))))

(define cadar
    (lambda (l)
        (car (cdr (car l)))))

(define caddar
    (lambda (l)
        (car (cdr (cdr (car l))))))

(define caddr
    (lambda (l)
        (car (cdr (cdr l)))))

(define null.
  (lambda (x)
    (eq? x '())))

(define and.
  (lambda (x y)
    (cond
      (x (cond (y true) (#else '())))
      (#else '()))))

(define not.
  (lambda (x)
    (cond
      (x '())
      (#else true))))

(define append.
  (lambda (x y)
    (cond
      ((null. x) y)
      (#else (cons (car x) (append. (cdr x) y))))))

(define list.
  (lambda (x y)
    (cons x (cons y '()))))

(define pair.
  (lambda (x y)
    (cond
      ((and. (null. x) (null. y)) '())
      ((and. (not. (atom? x)) (not. (atom? y)))
       (cons (list. (car x) (car y))
             (pair. (cdr x) (cdr y)))))))

(define assoc.
  (lambda (x y)
    (cond
      ((eq? (caar y) x) (cadar y))
      (#else (assoc. x (cdr y))))))

(define eval.
  (lambda (e a)
    (cond
      ((atom? e) (assoc. e a))
      ((atom? (car e))
       (cond
         ((eq? (car e) 'quote) (cadr e))
         ((eq? (car e) 'atom)  (atom?  (eval. (cadr e) a)))
         ((eq? (car e) 'eq)    (eq?    (eval. (cadr e) a)
                                       (eval. (caddr e) a)))
         ((eq? (car e) 'car)   (car    (eval. (cadr e) a)))
         ((eq? (car e) 'cdr)   (cdr    (eval. (cadr e) a)))
         ((eq? (car e) 'cons)  (cons   (eval. (cadr e) a)
                                       (eval. (caddr e) a)))
         ((eq? (car e) 'cond)  (evcon. (cdr e) a))
         (#else (eval. (cons (assoc. (car e) a)
                          (cdr e))
                    a))))
      ((eq? (caar e) 'label)
       (eval. (cons (caddar e) (cdr e))
              (cons (list. (cadar e) (car e)) a)))
      ((eq? (caar e) 'lambda)
       (eval. (caddar e)
              (append. (pair. (cadar e) (evlis. (cdr e) a))
                       a))))))

(define evcon.
  (lambda (c a)
    (cond
        ((eval. (caar c) a)
         (eval. (cadar c) a))
        (#else (evcon. (cdr c) a)))))

(define evlis.
  (lambda (m a)
    (cond
        ((null. m) '())
        (#else (cons (eval.  (car m) a)
                     (evlis. (cdr m) a))))))

(eval. (quote (cons (quote foo)
                    (quote (bar baz))))
       (quote ()))
EOF;

require __DIR__.'/../vendor/autoload.php';

use Igorw\Ilias\Program;
use Igorw\Ilias\Lexer;
use Igorw\Ilias\Reader;
use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Walker;
use Igorw\Ilias\Environment;

$program = new Program(
    new Lexer(),
    new Reader(),
    new FormTreeBuilder(),
    new Walker()
);

$env = Environment::standard();
$value = $program->evaluate($env, $code);
var_dump($value);
