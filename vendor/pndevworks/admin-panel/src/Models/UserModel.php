<?php

namespace PNDevworks\AdminPanel\Models;

use CodeIgniter\Model;
use InvalidArgumentException;
use PNDevworks\AdminPanel\Entities\UserEntities;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'PNDevworks\AdminPanel\Entities\UserEntities';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'first_name',
		'last_name',
		'email',
		'password',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected static $session_name = "loggedin_user";
	protected static $loggedInUser = null;

	/**
	 * Get current logged in user. Will return null when no-user is detected.
	 * This will memory-cache the logged in user data.
	 * 
	 * @param boolean $useCache Check for cache first
	 *
	 * @return UserEntities|null Logged in user.
	 */
	public static function getCurrent(bool $useCache = true): ?UserEntities
	{
		// Check if we have logged in user before or not.
		if (self::$loggedInUser && $useCache) {
			return self::$loggedInUser;
		}

		$sessionUserID = session(self::$session_name);
		if (!$sessionUserID) {
			return null;
		}

		$user = new self();
		$theUser = $user->find($sessionUserID);
		if (!$theUser) {
			return null;
		}

		self::$loggedInUser = $theUser;
		return self::$loggedInUser;
	}

	/**
	 * Set current logged in user. This can also be used to clear the logged in
	 * user status by providing `null` to the $user param.
	 *
	 * @param UserEntities|null $user Current logged in user, or null to clear
	 * the login sttus.
	 * @return void
	 */
	public static function setCurrent(?UserEntities $user)
	{
		$session = session();
		if ($user) {
			$session->set(self::$session_name, $user->id);
			self::$loggedInUser = $user;
		} else {
			// clear session! Because $user is null.
			$session->remove(self::$session_name);
			self::$loggedInUser = null;
		}
	}

	/**
	 * Trigger login of the user. This will automatically set the session of the
	 * user by default.
	 *
	 * @throws InvalidArgumentException If email and/or password invalid this
	 * 	will be thrown.
	 * @param string $email User's Email
	 * @param string $password User's Password
	 * @param boolean $autoSetSession Set the session by default
	 * @return UserEntities Logged in user.
	 */
	public static function doLogin(string $email, string $password, bool $autoSetSession = true): UserEntities
	{
		$user = new self();

		$theUser = $user->where('email', $email)->first();

		if (!$theUser || !$theUser->verifyPassword($password)) {
			throw new InvalidArgumentException("Invalid email or password!", 403);
		}

		if ($autoSetSession) {
			self::setCurrent($theUser);
		}

		return $theUser;
	}

	/**
	 * Trigger logout of the user
	 *
	 * @return UserEntities|null Logoutted user.
	 */
	public static function doLogout(): ?UserEntities
	{
		$user = self::getCurrent();
		self::setCurrent(null);
		return $user;
	}
}
