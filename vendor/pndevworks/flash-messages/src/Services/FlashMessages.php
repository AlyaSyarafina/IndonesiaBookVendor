<?php

namespace PNDevworks\FlashMessages\Services;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Session\Session;
use InvalidArgumentException;

/**
 * Flash Mesage with better control over normal CodeIgniter's flash_data.
 *
 * Messages will be saved to the session until next `getMessages` or
 * `clearMessages` is called. This will add better control over which page do
 * you want to show your message. Hopefully will be better over time.
 */
class FlashMessages extends BaseService
{
	protected $sessionName = "_FM_main";
	const SESSION_PREFIX = "_FM_";
	/**
	 * Session API Client
	 *
	 * @var Session
	 */
	protected $session;

	public function __construct(string $sessionName = "main")
	{
		if (empty($sessionName)) {
			throw new InvalidArgumentException("Session Name should not be empty. Leave it as is if you don't know what you're doing.");
		}
		$this->session = session();
		$this->sessionName = self::SESSION_PREFIX . $sessionName;
	}

	/**
	 * Add a new message to Flash Data.
	 *
	 * @param string $type
	 * @param string $message
	 * @return void
	 */
	public function addMessage(string $type, string $message): void
	{
		$theItem = [
			"type" => $type,
			"message" => $message,
		];

		if (!$this->session->has($this->sessionName)) {
			$this->session->set($this->sessionName, []);
		}
		
		$this->session->push($this->sessionName, [$theItem]);
	}

	/**
	 * Destroys all messages within this scope.
	 *
	 * @return void
	 */
	public function clearMessages(): void
	{
		$this->session->set($this->sessionName);
	}

	/**
	 * Get all messages and then clear it.
	 *
	 * @return array
	 */
	public function getMessages(): array
	{
		$allMessages = $this->session->get($this->sessionName) ?? [];

		$this->clearMessages();

		return $allMessages;
	}

	/**
	 * Reset and clear all messages stored on the session.
	 * FlashMessage
	 * @return boolean
	 */
	public function hasMessage(): bool
	{
		$allMessages = $this->session->get($this->sessionName) ?? [];

		return !empty($allMessages);
	}
}
