<?php

namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use Config\Services;
//use App\Models\UserModel;
//use App\Models\LogsModel;

class LoginController extends Controller
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
	 * Displays login form or redirects if user is already logged in.
	 */
	public function login()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to('dashboard');
		}

		return view('auth/login');
	}

	//--------------------------------------------------------------------

//	/**
//	 * Attempts to verify user's credentials through POST request.
//	 */
//	public function attemptLogin()
//	{
//		$rules = [
//			'email' => [
//				'label' => 'Email',
//				'rules' => 'required|valid_email',
//				'errors' => [
//					'required' => 'Enter email address.',
//					'valid_email' => 'Please enter a valid email address.'
//				]
//			],
//			'password' => [
//				'label' => 'Password',
//				'rules' => 'required|min_length[5]',
//				'errors' => [
//					'required' => 'Enter password',
//					'min_length[5]' => 'Password must be at least 5 characters.'
//				]
//			],
//		];
//
//		if (!$this->validate($rules)) {
//			return redirect()->to('login')->withInput()->with('validate_errors', $this->validator->getErrors());
//		}
//
//		// check credentials
//		$users = new UserModel();
//
//		$user = $users->where('email', $this->request->getPost('email'))->first();
//
//		if (is_null($user) || !password_verify($this->request->getPost('password'), $user['password_hash'])) {
//			return redirect()->to('login')->withInput()->with('error', lang('Auth.wrongCredentials'));
//		}
//
//		// check activation
//		if (!$user['active']) {
//			return redirect()->to('login')->withInput()->with('error', lang('Auth.notActivated'));
//		}
//
//		// login OK, save user data to session
//		$this->session->set('isLoggedIn', true);
//		$this->session->set('userData', [
//			'id' => $user["id"],
//			'name' => $user["name"],
//			'email' => $user["email"],
//			'admin' => $user['admin']
//		]);
//
//		// save login info to user login logs for tracking
//		// get user agent
//		$agent = $this->request->getUserAgent();
//		// load logs model
//		$logs = new LogsModel();
//		// logs data
//		$userlog = [
//			'date' => date("Y-m-d"),
//			'time' => date("H:i:s"),
//			'reference' => $user["id"],
//			'name' => $user["name"],
//			'ip' => $this->request->getIPAddress(),
//			'browser' => $agent->getBrowser(),
//			'status' => 'Success'
//		];
//		// logs to database
//		$logs->save($userlog);
//
//		return redirect()->to('dashboard');
//	}
//
//	//--------------------------------------------------------------------
//
//	/**
//	 * Log the user out.
//	 */
//	public function logout()
//	{
//		$this->session->remove(['isLoggedIn', 'userData']);
//
//		return redirect()->to('login');
//	}
}