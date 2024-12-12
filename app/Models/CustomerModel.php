<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer'; // The name of the database table
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'password', 'email', 'first_name', 'last_name', 
        'phone', 'institution', 'address', 'country', 
        'joined_at', 'lastlogin_at', 'auth_key', 'password_reset_token'
    ];
    
    protected $validationRules = [
        'username' => 'required|max_length[32]|is_unique[customer.username]',
        'email' => 'required|valid_email|is_unique[customer.email]',
        'first_name' => 'required|max_length[64]',
        'last_name' => 'required|max_length[64]',
        'phone' => 'required|max_length[64]',
        'institution' => 'required|max_length[64]',
        'address' => 'permit_empty|string',
        'country' => 'required|max_length[64]',
        'password' => 'required|max_length[128]',
        'password_repeat' => 'required|matches[password]',
        // Add reCAPTCHA validation if needed
    ];

    protected $beforeInsert = ['hashPassword', 'setJoinedAt', 'generateAuthKey'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = md5($data['data']['username'] . '-' . $data['data']['password']);
        }
        return $data;
    }

    protected function setJoinedAt(array $data)
    {
        $data['data']['joined_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function generateAuthKey(array $data)
    {
        $data['data']['auth_key'] = bin2hex(random_bytes(16)); // Generate a random string
        return $data;
    }

    public function validatePassword($password, $hashedPassword)
    {
        return md5($this->username . '-' . $password) === $hashedPassword;
    }

    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function findIdentity($id)
    {
        return $this->find($id);
    }

    public function findIdentityByAccessToken($token)
    {
        return $this->where('access_token', $token)->first();
    }

    public function getAuthKey($id)
    {
        return $this->find($id)['auth_key'];
    }

    public function validateAuthKey($auth_key, $id)
    {
        return $this->find($id)['auth_key'] === $auth_key;
    }
}