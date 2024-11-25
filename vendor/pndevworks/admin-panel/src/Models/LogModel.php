<?php

namespace PNDevworks\AdminPanel\Models;

use Monolog\Logger;
use CodeIgniter\Model;

class LogModel extends Model
{
	protected static $logger;

	public function __construct()
	{
		parent::__construct();
		self::$logger = new Logger('EventLogger');
		self::$logger->pushHandler(new \Monolog\Handler\RotatingFileHandler('../writable/logs/adminpanel.log', Logger::INFO, 7));
		self::$logger->pushHandler(new \Monolog\Handler\RotatingFileHandler('../writable/logs/adminpanel_critical.log', Logger::ERROR, 7));
		self::$logger->pushHandler(new \Monolog\Handler\RotatingFileHandler('../writable/logs/adminpanel_critical.log', Logger::WARNING, 7));
	}

	public function debug($message, $additional = NULL)
	{
		if ($additional === NULL) {
			self::$logger->debug($message);
		} else {
			self::$logger->debug($message, $additional);
		}
	}

	public function info($message, $additional = NULL)
	{
		if ($additional === NULL) {
			self::$logger->info($message);
		} else {
			self::$logger->info($message, $additional);
		}
	}

	public function notice($message, $additional = NULL)
	{
		if ($additional === NULL) {
			self::$logger->notice($message);
		} else {
			self::$logger->notice($message, $additional);
		}
	}

	public function error($message, $additional = NULL)
	{
		if ($additional === NULL) {
			self::$logger->error($message);
		} else {
			self::$logger->error($message, $additional);
		}
	}

	public function exception($e)
	{
		self::$logger->info($e->getMessage(), $e->getTrace());
	}
}
