class AES256 {
    const AES256_KEY_SIZE = 32;
    const AES256_NONCE_SIZE = 12;
    const AES256_MODE = 'aes-256-gcm';

    private string $key;

    public function __construct(string $key) {
        if (strlen($key) !== self::AES256_KEY_SIZE) {
            throw new \Exception('Key size must be 32 bytes.');
        }

        $this->key = $key;
    }

    public function encrypt(string $plaintext): string | null {
        try {
            $nonce = random_bytes(12);
            $ciphertext = openssl_encrypt($plaintext, self::AES256_MODE, $this->key, OPENSSL_RAW_DATA, $nonce, $tag);
            return base64_encode($nonce . $tag . $ciphertext);
        } catch (\Exception) {
            return null;
        }
    }

    public function encryptWithIV(string $plaintext, string $nonce): string | null {
        try {
            $nonce = base64_decode($nonce);
            $ciphertext = openssl_encrypt($plaintext, self::AES256_MODE, $this->key, OPENSSL_RAW_DATA, $nonce, $tag);
            return base64_encode($nonce . $tag . $ciphertext);
        } catch (\Exception) {
            return null;
        }
    }

    public function decrypt($ciphertext): string | null {
        try {
            $ciphertext = base64_decode($ciphertext);
            $iv = substr($ciphertext, 0, self::AES256_NONCE_SIZE);
            $tagLength = 16;
            $tag = substr($ciphertext, self::AES256_NONCE_SIZE, $tagLength);
            $encryptedData = substr($ciphertext, self::AES256_NONCE_SIZE + $tagLength);
            return openssl_decrypt($encryptedData, self::AES256_MODE, $this->key, OPENSSL_RAW_DATA, $iv, $tag);
        } catch (\Exception) {
            return null;
        }
    }
}
