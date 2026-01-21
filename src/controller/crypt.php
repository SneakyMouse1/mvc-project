<?php
// Encryption constants
define("ENCRYPT_METHOD", "AES-256-CBC");
define("SECRET_KEY", "12345"); // Secret key (in a real project this should be more complex)
define("SECRET_IV", "67890");  // Initialization vector (in a real project this should be more complex)

/**
 * Class for string encryption and decryption
 */
class Crypt
{
    /**
     * Encrypt a string.
     *
     * Encrypts the input string using AES-256-CBC with a hashed key and IV,
     * then encodes the result in Base64.
     *
     * @param string $string The string to encrypt.
     * @return string|false The encrypted string in Base64 format, or false on failure.
     */
    public static function Encriptar($string)
    {
        $output = false;

        // Hash the key and initialization vector
        $key = hash("sha256", SECRET_KEY);
        $iv  = substr(hash("sha256", SECRET_IV), 0, 16);

        // Encrypt the string
        $output = openssl_encrypt($string, ENCRYPT_METHOD, $key, 0, $iv);
        // Encode in base64 for easy storage
        $output = base64_encode($output);

        return $output;
    }

    /**
     * Decrypt a string.
     *
     * Decodes the Base64 input and decrypts it using AES-256-CBC.
     *
     * @param string $string The encrypted string (Base64).
     * @return string|false The decrypted string, or false on failure.
     */
    public static function Desencriptar($string)
    {
        $output = false;

        // Hash the key and initialization vector
        $key = hash("sha256", SECRET_KEY);
        $iv  = substr(hash("sha256", SECRET_IV), 0, 16);

        // Decode from base64
        $output = base64_decode($string);
        // Decrypt the string
        $output = openssl_decrypt($output, ENCRYPT_METHOD, $key, 0, $iv);

        return $output;
    }
}
