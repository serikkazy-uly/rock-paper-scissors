<?php
require_once 'KeyGenerator.php';
require_once 'HmacCalculator.php';

$move = 'rock';
$hmacKey = 'eff44c51cc42fca878651959ef18440f';

$hmac = HmacCalculator::calculateHmac($move, $hmacKey);
echo "HMAC for '$move': $hmac\n";
