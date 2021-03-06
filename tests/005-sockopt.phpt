--TEST--
Test sending and receiving
--SKIPIF--
<?php require_once (dirname (__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php

use NanoMsg\Nano as Nano;
use NanoMsg\Socket as NanoSocket;
use NanoMsg\Exception as NanoException;

$pub = new NanoSocket (Nano::AF_SP, Nano::NN_PUB);
$pub->bind ("inproc://hello");

$sub = new NanoSocket (Nano::AF_SP, Nano::NN_SUB);
$sub->connect ("inproc://hello");
$sub->setSockOpt (Nano::NN_SUB, Nano::NN_SUB_SUBSCRIBE, "hello");
$sub->setSockOpt (Nano::NN_SUB, Nano::NN_SUB_SUBSCRIBE, 1);

$pub->send ("hello there");
var_dump ($sub->recv ());

$pub->send ("1 hello there");
var_dump ($sub->recv ());

$pub->send ("tttt");
var_dump ($sub->recv (Nano::NN_DONTWAIT));
echo "OK";

--EXPECT--
string(11) "hello there"
string(13) "1 hello there"
bool(false)
OK