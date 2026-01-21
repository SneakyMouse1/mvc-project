<?php

class JsonClass
{
    // Error messages
    protected static $mensajes = array(
        JSON_ERROR_NONE           => 'No error',
        JSON_ERROR_DEPTH          => 'Maximum stack depth reached',
        JSON_ERROR_STATE_MISMATCH => 'Incorrect or invalid JSON',
        JSON_ERROR_CTRL_CHAR      => 'Control character error, possibly incorrect encoding',
        JSON_ERROR_SYNTAX         => 'Syntax error',
        JSON_ERROR_UTF8           => 'Incorrect UTF-8 characters, possibly incorrect encoding'
    );

    // Encode (PHP Array/Object -> JSON String)
    public static function encode($value, $flags = 0, $depth = 512)
    {
        $json_encode = json_encode($value, $flags, $depth);

        // Check for errors
        if (json_last_error() === JSON_ERROR_NONE) {
            return $json_encode;
        }

        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }

    // Decode (JSON String -> PHP Array/Object)
    public static function decode($json, $associative = false, $depth = 512, $flags = 0)
    {
        $json_decode = json_decode($json, $associative, $depth, $flags);

        // Check for errors
        if (json_last_error() === JSON_ERROR_NONE) {
            return $json_decode;
        }

        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }
}
