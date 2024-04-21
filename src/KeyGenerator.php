<?php
class KeyGenerator
{
    public static function generateKey()
    {
        return bin2hex(random_bytes(16)); 
    }
}
