<?php

class HmacCalculator {
    public static function calculateHmac($move, $hmacKey) {
        return hash_hmac('sha256', $move, $hmacKey);
    }
}
