<?php

namespace api\src\Controller;

use api\src\Config\Connection;
use api\src\Config\DBOperation;

require_once(__DIR__ . '/../Config/Connection.php');
require_once(__DIR__ . '/../Config/DBOperation.php');

class SecureLogin {

    private $dbOperations;

    public function __construct() {
        echo "Constructing SecureLogin<br>";
        $connector = new Connection("test.json");
        $this->dbOperations = new DBOperation($connector);
    }

    public static function Routing() {
        echo "Routing<br>";
        $method = $_GET['method'] ?? null;
        $json = $_GET['json'] ?? '';

        if (!$method) {
            echo "Missing 'method' parameter<br>";
            return;
        }

        $secureLogin = new self();

        if ($method !== 'signedin' && !$json) {
            echo "Missing 'json' parameter for method '{$method}'<br>";
            return;
        }

        $array = ($json) ? json_decode($json, true) : [];

        switch ($method) {
            case 'signup':
                $secureLogin->SignUp($array);
                break;
            case 'signin':
                $secureLogin->SignIn($array);
                break;
            case 'changepwd':
                $secureLogin->ChangePwd($array);
                break;
            case 'signedin':
                $secureLogin->SignedIn();
                break;
            default:
                echo "Unknown method<br>";
                return;
        }
    }

    public function SignUp($userData) {
        echo "SignUp<br>";
        if (!isset($userData['username']) || !isset($userData['password']) || !isset($userData['email'])) {
            echo "Username, password or email is missing<br>";
            return;
        }

      
        if (!preg_match('/^[a-zA-Z0-9]{4,}$/', $userData['username'])) {
            echo "Username must be at least 4 characters long and contain only letters and numbers<br>";
            return;
        }

       
        $existingUser = $this->dbOperations->Display('users', ['email' => $userData['email']]);
        if (!empty($existingUser)) {
            echo "Email is already in use<br>";
            return;
        }

       
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $userData['password'])) {
            echo "Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character<br>";
            return;
        }

        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

        $this->dbOperations->Insert2('users', $userData);
        echo "User registered successfully<br>";
    }

    public function SignIn($userData) {
        echo "SignIn<br>";
        if (!isset($userData['username']) || !isset($userData['password'])) {
            echo "Username or password is missing<br>";
            return;
        }
        
        $attempts = $this->dbOperations->Display('login_attempts', ['username' => $userData['username']]);
        $now = new \DateTime();
    
        if (count($attempts) >= 5) {
            $lastAttempt = new \DateTime(end($attempts)['attempt_time']);
            $diff = $now->getTimestamp() - $lastAttempt->getTimestamp();
    
            if ($diff < 300) { 
                echo "Account is locked due to multiple failed login attempts. Please try again in 5 minutes.<br>";
                return;
            } else {
                
                $this->dbOperations->Delete2('login_attempts', ['username' => $userData['username']]);
                
                $attempts = [];
            }
        }
    
        $user = $this->dbOperations->Display('users', ['username' => $userData['username']]);
        if (empty($user) || !password_verify($userData['password'], $user[0]['password'])) {
            $this->dbOperations->Insert2('login_attempts', ['username' => $userData['username'], 'attempt_time' => $now->format('Y-m-d H:i:s')]);
            $attempts[] = ['attempt_time' => $now->format('Y-m-d H:i:s')]; 
            if (count($attempts) >= 5) {
                echo "Account is locked due to multiple failed login attempts. Please try again in 5 minutes.<br>";
            } else {
                echo "Invalid username or password<br>";
            }
            return;
        }
    
        
        $this->dbOperations->Delete2('login_attempts', ['username' => $userData['username']]);
    
        session_start();
        $_SESSION['user'] = $user[0];
        echo "User logged in successfully<br>";
    }        

    public function SignedIn() {
        echo "SignedIn<br>";
        session_start();
        if (isset($_SESSION['user'])) {
            echo json_encode(["signedin" => true, "user" => $_SESSION['user']]);
        } else {
            echo json_encode(["signedin" => false]);
        }
    }
}
