<?php

namespace PNDevworks\AdminPanel\Controllers;

use InvalidArgumentException;
use PNDevworks\AdminPanel\Models\UserModel;

class User extends BaseController
{
	public function get_login()
	{
		// Prevent Google index this page.

		if (config("Authentication")->discourageRobotIndexLoginPage) {
			$this->response->setHeader("X-Robots-Tag", "noindex, nofollow, noarchive");
		}
		return view("PNDevworks\\AdminPanel\\Views\\user_login", [
			'returnto' => $this->request->getGetPost('returnto'),
			'showprivacypolicy' => array_key_exists('configurations', config('AdminPanel')->admin_tables)
		]);
	}

	public function post_login()
	{
		\Config\Database::connect();

		$validation =  \Config\Services::validation();
		// Sanitize login information
		$rule = ([
			'email' => ['label' => 'email', 'rules' => 'required'],
			'password' => ['label' => 'Password', 'rules' => 'required']
		]);

		if (!$validation->withRequest($this->request)->setRules($rule)->run()) {
			$errors = $validation->getErrors();
			foreach ($errors as $field => $err) {
				$this->flashMessages->addMessage('danger', "Field $field is $err");
			}
			return $this->get_login();
		}

		// Try to login
		try {
			$user = UserModel::doLogin($this->request->getPost('email'), $this->request->getPost('password'));

			$this->flashMessages->addMessage("success", "Welcome, " . $user->first_name . "!");

			// Return to earlier requested area.
			$returnto = $this->request->getGetPost('returnto') ?? "/";
			return redirect()->to($returnto);
		} catch (InvalidArgumentException $e) {
			$this->flashMessages->addMessage("danger", $e->getMessage());
		}
		return $this->get_login();
	}

	public function post_logout()
	{
		UserModel::doLogout();
		$this->flashMessages->addMessage('success', "You have been logged out.");
		$returnto = $this->request->getPost('returnto') ?? "/";
		return redirect()->to($returnto);
	}
}
