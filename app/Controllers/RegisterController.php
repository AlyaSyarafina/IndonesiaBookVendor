<?php

namespace App\Controllers;

use App\Models\CustomerModel; // Assuming CustomerModel represents the Customer table
use App\Models\CustomerLoginModel; // Assuming a model to handle login functionality
use CodeIgniter\Controller;

class RegisterController extends BaseController
{
    public function index()
    {
        helper(['form', 'url']);

        $customerModel = new CustomerModel();

        // Custom validation rules, similar to Yii2's validation scenarios
        $customerModel->setValidationRules([
            'username' => 'required|min_length[3]|max_length[255]',
            'password' => 'required|min_length[6]',
            'password_repeat' => 'matches[password]', // Confirm password rule
            'email' => 'required|valid_email',
            'country' => 'required',
            // Add additional rules for other fields as needed
        ]);

        // Fetch countries for the dropdown (assuming you have a CountryModel)
        $countryModel = new \App\Models\CountryModel();
        $countries = array_column($countryModel->findAll(), 'name', 'id'); // ['id' => 'name']

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();

            if ($customerModel->insert($data)) {
                // Send an email
                $subject = "Welcome to Our Service!";
                $body = str_replace(
                    '{last_name}',
                    $data['last_name'] ?? '',
                    "Hi {last_name}, welcome to our platform!"
                );

                $email = \Config\Services::email();
                $email->setTo($data['email']);
                $email->setFrom('admin@example.com', 'Your Company');
                $email->setSubject($subject);
                $email->setMessage($body);
                $email->send();

                // Log the user in
                $loginModel = new CustomerLoginModel();
                $loginModel->login($data['username'], $data['password']);

                // Set a success flash message
                session()->setFlashdata('success', 'Your registration was successful!');

                return redirect()->to(current_url());
            }

            // Return errors if validation or insertion fails
            return view('register/index', [
                'model' => $data,
                'errors' => $customerModel->errors(),
                'countries' => $countries
            ]);
        }

        return view('register/index', ['countries' => $countries]);
    }
}
