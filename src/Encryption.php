<?php

namespace Shimoning\Encryption;

class Encryption
{
    /**
     * Default encryption method.
     */
    public const DEFAULT_METHOD = 'AES-256-CBC';

    /**
     * Default key for encryption.
     *
     * \base64_encode(\openssl_random_pseudo_bytes(\openssl_cipher_iv_length('AES-256-CBC')))
     */
    public const DEFAULT_KEY = '06ShagteTfh1cKgu0GI0iA==';

    /**
     * Default IV for encryption.
     *
     * \base64_encode(\openssl_random_pseudo_bytes(\openssl_cipher_iv_length('AES-256-CBC')))
     */
    public const DEFAULT_IV = 'lSwJdjw1PUnjyw5OwhAUIA==';

    /**
     * 暗号化を行う
     *
     * @param string $string
     * @param string|null $method
     * @param string|null $base64key
     * @param string|null $base64iv
     * @return string
     */
    public static function encrypt(
        string $string,
        ?string $method = null,
        ?string $base64key = null,
        ?string $base64iv = null,
    ): string {
        return \base64_encode(
            \openssl_encrypt(
                $string,
                $method ?? static::DEFAULT_METHOD,
                \base64_decode($base64key ?? static::DEFAULT_KEY),
                \OPENSSL_RAW_DATA,
                \base64_decode($base64iv ?? static::DEFAULT_IV),
            ),
        );
    }

    /**
     * 復号化を行う
     *
     * @param string $string
     * @param string|null $method
     * @param string|null $base64key
     * @param string|null $base64iv
     * @return string
     */
    public static function decrypt(
        string $string,
        ?string $method = null,
        ?string $base64key = null,
        ?string $base64iv = null,
    ): string {
        return \openssl_decrypt(
            \base64_decode($string),
            $method ?? static::DEFAULT_METHOD,
            \base64_decode($base64key ?? static::DEFAULT_KEY),
            \OPENSSL_RAW_DATA,
            \base64_decode($base64iv ?? static::DEFAULT_IV),
        );
    }
}
