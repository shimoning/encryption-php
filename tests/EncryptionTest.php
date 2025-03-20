<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Encryption\Encryption;

class EncryptionTest extends TestCase
{
    /**
     * 暗号化された文字列が空でないことを確認するテスト
     */
    public function testEncryptProducesNonEmptyString(): void
    {
        $originalString  = 'Hello, World!';
        $encryptedString = Encryption::encrypt($originalString);

        $this->assertNotEmpty($encryptedString, 'Encrypted string should not be empty.');
        $this->assertIsString($encryptedString, 'Encrypted string should be a string.');
    }

    /**
     * 復号化された文字列が元の文字列と一致することを確認するテスト
     */
    public function testDecryptReturnsOriginalString(): void
    {
        $originalString  = 'Hello, World!';
        $encryptedString = Encryption::encrypt($originalString);
        $decryptedString = Encryption::decrypt($encryptedString);

        $this->assertEquals($originalString, $decryptedString, 'Decrypted string should match the original string.');
    }

    /**
     * 暗号化と復号化が一貫して動作することを確認するテスト
     */
    public function testEncryptAndDecryptAreConsistent(): void
    {
        $originalString  = 'Consistency Test';
        $encryptedString = Encryption::encrypt($originalString);
        $decryptedString = Encryption::decrypt($encryptedString);

        $this->assertEquals($originalString, $decryptedString, 'Encrypting and then decrypting should return the original string.');
    }

    /**
     * カスタムキーとIVを使用した場合に暗号化と復号化が正しく動作することを確認するテスト
     */
    public function testEncryptWithCustomKeyAndIv(): void
    {
        $originalString = 'Custom Key and IV Test';
        $customKey      = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(Encryption::DEFAULT_METHOD)));
        $customIv       = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(Encryption::DEFAULT_METHOD)));

        $encryptedString = Encryption::encrypt($originalString, null, $customKey, $customIv);
        $decryptedString = Encryption::decrypt($encryptedString, null, $customKey, $customIv);

        $this->assertEquals($originalString, $decryptedString, 'Decrypted string should match the original string when using custom key and IV.');
    }

    /**
     * 異なる暗号化方式を使用した場合に暗号化と復号化が正しく動作することを確認するテスト
     */
    public function testEncryptWithDifferentMethod(): void
    {
        $originalString = 'Different Method Test';
        $customMethod   = 'AES-128-CBC';
        $customKey      = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($customMethod)));
        $customIv       = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($customMethod)));

        $encryptedString = Encryption::encrypt($originalString, $customMethod, $customKey, $customIv);
        $decryptedString = Encryption::decrypt($encryptedString, $customMethod, $customKey, $customIv);

        $this->assertEquals($originalString, $decryptedString, 'Decrypted string should match the original string when using a different encryption method.');
    }

    /**
     * 無効なキーを使用した場合に復号化が失敗することを確認するテスト
     */
    public function testDecryptWithInvalidKey(): void
    {
        $originalString  = 'Invalid Key Test';
        $encryptedString = Encryption::encrypt($originalString);
        $invalidKey      = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(Encryption::DEFAULT_METHOD)));

        $decryptedString = Encryption::decrypt($encryptedString, null, $invalidKey);

        $this->assertNotEquals($originalString, $decryptedString, 'Decrypted string should not match the original string when using an invalid key.');
    }

    /**
     * 無効なIVを使用した場合に復号化が失敗することを確認するテスト
     */
    public function testDecryptWithInvalidIv(): void
    {
        $originalString  = 'Invalid IV Test';
        $encryptedString = Encryption::encrypt($originalString);
        $invalidIv       = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(Encryption::DEFAULT_METHOD)));

        $decryptedString = Encryption::decrypt($encryptedString, null, null, $invalidIv);

        $this->assertNotEquals($originalString, $decryptedString, 'Decrypted string should not match the original string when using an invalid IV.');
    }

    /**
     * 空文字列を暗号化および復号化した場合に正しく動作することを確認するテスト
     */
    public function testEncryptAndDecryptWithEmptyString(): void
    {
        $originalString  = '';
        $encryptedString = Encryption::encrypt($originalString);
        $decryptedString = Encryption::decrypt($encryptedString);

        $this->assertEquals($originalString, $decryptedString, 'Encrypting and decrypting an empty string should return an empty string.');
    }
}
