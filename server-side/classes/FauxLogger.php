<?php
class Logger
{
	static private $_logger = NULL;
	public function getLogger()
	{
		if (is_null(self::$_logger)) {
			self::$_logger = new Logger();
		}

		return self::$_logger;
	}
	public function error($msg)
	{
		error_log($msg);
	}
	public function info($msg)
	{
		error_log($msg);
	}
}
?>
