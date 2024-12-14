<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer'; // Matches the Yii2 table name
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 'password', 'email', 'first_name', 'last_name',
        'phone', 'institution', 'address', 'country', 
        'joined_at', 'lastlogin_at', 'auth_key', 'password_reset_token'
    ];

    // Define rules for validation
    protected $validationRules = [
        'username' => 'required|max_length[32]|is_unique[customer.username]',
        'email' => 'required|valid_email|is_unique[customer.email]',
        'password' => 'required|min_length[6]',
        'first_name' => 'required|max_length[64]',
        'last_name' => 'required|max_length[64]',
        'phone' => 'required|max_length[64]',
        'institution' => 'required|max_length[64]',
        'address' => 'required',
        'country' => 'required|max_length[64]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required.',
            'is_unique' => 'This username is already taken.'
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Enter a valid email address.',
            'is_unique' => 'This email is already registered.'
        ]
    ];

    // Auto timestamps
    protected $useTimestamps = false; // Yii2 has `joined_at` and `lastlogin_at` fields manually handled

    public function beforeInsert(array $data)
    {
        // Hash password before inserting
        if (isset($data['data']['password'])) {
            $data['data']['password'] = $this->hashPassword(
                $data['data']['username'], 
                $data['data']['password']
            );
        }

        $data['data']['joined_at'] = date('Y-m-d H:i:s');
        $data['data']['auth_key'] = bin2hex(random_bytes(16)); // Similar to Yii2 auth_key

        return $data;
    }

    public function hashPassword($username, $password)
    {
        // Match the Yii2 password hashing logic
        return md5($username . '-' . $password);
    }

    public function validatePassword($username, $password, $storedPassword)
    {
        // Match hashed password
        return $this->hashPassword($username, $password) === $storedPassword;
    }

    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function validateAuthKey($authKey, $storedAuthKey)
    {
        return $authKey === $storedAuthKey;
    }
}
