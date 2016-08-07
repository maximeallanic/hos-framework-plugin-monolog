<?php
namespace Hos\Plugin\Monolog;

use Hos\Option;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
  * @author Maxime Allanic maxime@allanic.me
  * @license GPL
  * @internal Created 2016-07-26 12:08:57
  */
class Events{
	/** @var  Logger */
	private static $logger = false;

	private static function getLogger() {
		if (!self::$logger) {
			/** Log */
			self::$logger = new Logger('hos');
			$logFile = Option::LOG_DIR.(Option::isDev() ? "dev" : "prod").".log";

			$dateFormat = "Y-m-d G:i:s";
			$output = "[%datetime%](%level_name%)\t%message%\n";
			$formatter = new LineFormatter($output, $dateFormat);
			$streamHandler = new StreamHandler($logFile, Option::isDev() ? Logger::INFO : Logger::ALERT);
			$streamHandler->setFormatter($formatter);
			self::$logger->pushHandler($streamHandler);
		}
		return self::$logger;
	}

	static function alert($arguments) {
		self::getLogger()->alert(sprintf($arguments['message']));
	}

	static function error($arguments) {
		self::getLogger()->error(sprintf($arguments['message']));
	}

	static function info($arguments) {
		self::getLogger()->info(sprintf($arguments['message']));
	}
}
