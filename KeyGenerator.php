<?php

class KeyGenerator {

    public static function generateKey() {
        return bin2hex(random_bytes(16)); 
    }
}
// $hmacKey = bin2hex(random_bytes(16));
// echo "Generated HMAC key: $hmacKey\n";
