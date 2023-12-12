function generateUUIDv4() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

class CSRFProtection {
    protected $session_key;
    protected $token_name;
    protected $expiration;

    public function __construct($config = []) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->session_key = $config['session_key'] ?? 'csrf_token';
        $this->token_name = $config['token_name'] ?? '_csrf';
        $this->expiration = $config['expiration'] ?? 400;
    }

    public function generateToken(): string {
        $token = generateUUIDv4();
        $_SESSION[$this->session_key] = $token;
        $_SESSION[$this->session_key . '_expiration'] = time() + $this->expiration;
        return $token;
    }

    public function getToken(): string {
        if (!isset($_SESSION[$this->session_key])) {
            $this->generateToken();
        }
        return $_SESSION[$this->session_key];
    }

    public function validateToken($token): bool {
        if (!isset($token) || !isset($_SESSION[$this->session_key])) {
            return false;
        }
        if ($_SESSION[$this->session_key] !== $token) {
            return false;
        }
        if (($_SESSION[$this->session_key . '_expiration'] - time()) <= 0) {
            return false;
        }
        return true;
    }

    public function getTokenField(): string {
        return '<input type="hidden" name="' . $this->session_key . '" value="' . $this->getToken() . '">';
    }

    public function getTokenMeta(): string {
        return '<meta name="csrf-token" content="' . $this->getToken() . '">';
    }
}
