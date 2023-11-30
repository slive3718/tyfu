<?php
namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use App\Models\UserModel;

class RegistrationController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;


	//--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();
	}

	//--------------------------------------------------------------------

	/**
	 * Displays register form.
	 */
	public function register()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to('dashboard');
		}

		return view('auth/auth/register');
	}

	//--------------------------------------------------------------------

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		helper('text');

		$rules = [
			'name' => [
				'label' => 'Name',
				'rules' => 'required',
				'errors' => [
					'required' => 'Enter your full name.'
				]
			],
			'email' => [
				'label' => 'Email',
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Enter email address.',
					'valid_email' => 'Please enter a valid email address.'
				]
			],
			'password' => [
				'label' => 'Password',
				'rules' => 'required|min_length[5]',
				'errors' => [
					'required' => 'Enter password',
					'min_length[5]' => 'Password must be at least 5 characters.'
				]
			],
			'password_confirm' => [
				'label' => 'Confirm Password',
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'Enter confirm password.',
					'matches[5]' => 'Confirm Password must match with Password.'
				]
			],
		];

		if (!$this->validate($rules)) {
			return redirect()->to('register')->withInput()->with('validate_errors', $this->validator->getErrors());
		}

		// save new user, validation happens in the model
		$users = new UserModel();
		$getRule = $users->getRule('registration');
		$users->setValidationRules($getRule);

		$user = [
			'name' => $this->request->getPost('name'),
			'email' => $this->request->getPost('email'),
			'password' => $this->request->getPost('password'),
			'password_confirm' => $this->request->getPost('password_confirm'),
			'activate_hash' => random_string('alnum', 32)
		];

		if (!$users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		// send activation email //
		// send email activation is commented no email support //

		// helper('auth'); 
		// send_activation_email($user['email'], $user['activate_hash']);

		// success
		return redirect()->to('login')->with('success', lang('Auth.registrationSuccess'));
	}

	//--------------------------------------------------------------------

	/**
	 * Activate account.
	 */
	public function activateAccount()
	{
		$users = new UserModel();

		// check token
		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		// check user if exists
		if (is_null($user)) {
			return redirect()->to('login')->with('error', lang('Auth.activationNoUser'));
		}

		// update user account to active
		$updatedUser['id'] = $user['id'];
		$updatedUser['active'] = 1;
		$users->save($updatedUser);

		return redirect()->to('login')->with('success', lang('Auth.activationSuccess'));
	}

}