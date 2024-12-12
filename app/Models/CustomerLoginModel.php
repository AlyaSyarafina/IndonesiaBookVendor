<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerLoginModel extends Model
{
    protected $table = 'customer'; // The name of the database table
    protected $primaryKey = 'id';

    public function login($username, $password)
    {
        // Find the customer by username
        $customer = $this->where('username', $username)->first();

        // If customer exists and password is valid
        if ($customer && $this->validatePassword($password, $customer['password'])) {
            // Set session data
            $this->setSessionData($customer);
            return true; // Login successful
        }

        return false; // Login failed
    }

    protected function validatePassword($password, $hashedPassword)
    {
        // Validate the password using the same hashing method
        return md5($username . '-' . $password) === $hashedPassword;
    }

    protected function setSessionData($customer)
    {
        // Set session data for the logged-in user
        session()->set([
            'id' => $customer['id'],
            'username' => $customer['username'],
            'email' => $customer['email'],
            'logged_in' => true,
        ]);
    }

    public function logout()
    {
        // Destroy the session to log out the user
        session()->destroy();
    }

    public function isLoggedIn()
    {
        // Check if the user is logged in
        return session()->get('logged_in') === true;
    }
}