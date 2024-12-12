<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\CustomerLoginModel;
use CodeIgniter\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $data = [];

        if ($this->request->getMethod() === 'post') {
            $customerData = $this->request->getPost();

            // Validate the input data
            if ($this->validate('customer')) {
                // Save customer data
                $customerModel->save($customerData);

                // Prepare email
                $email = \Config\Services::email();
                $subject = config('App')->mail['registration']['subject'];
                $body = config('App')->mail['registration']['body'];

                // Replace placeholders in the email body
                $body = str_replace('{last_name}', $customerData['last_name'], $body);

                // Send email
                $email->setTo($customerData['email']);
                $email->setFrom(config('App')->adminEmail, config('App')->title);
                $email->setSubject($subject);
                $email->setMessage($body);
                $email->send();

                // Login the customer
                $customerLoginModel = new CustomerLoginModel();
                $customerLoginModel->login($customerData['username'], $customerData['password']);

                // Set flash message
                session()->setFlashdata('success', 'Your registration was successful!');

                // Redirect to the same page to avoid resubmission
                return redirect()->to(current_url());
            } else {
                // Validation failed, get errors
                $data['errors'] = $this->validator->getErrors();
            }
        }

        return view('register/index', [
            'model' => $customerModel,
            'errors' => $data['errors'] ?? []
        ]);
    }
}