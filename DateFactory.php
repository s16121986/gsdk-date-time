<?php

namespace Gsdk\DateTime;

class DateFactory {

	public static function beginOfYear($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime
			->setDate($datetime->getYear(), 1, 1)
			->setTime(0, 0, 0);
		return $datetime;
	}

	public static function endOfYear($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime
			->setDate($datetime->getYear(), 12, 31)
			->setTime(23, 59, 59);
		return $datetime;
	}

	public static function beginOfQuarter($date = null) {

	}

	public static function endOfQuarter($date = null) {

	}

	public static function beginOfMonth($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime->modify('first day of this month');
		$datetime->setTime(0, 0, 0);
		return $datetime;
	}

	public static function endOfMonth($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime->modify('last day of this month');
		$datetime->setTime(23, 59, 59);
		return $datetime;
	}

	public static function beginOfWeek($date = null): DateTime {
		$datetime = static::factory($date);
		$d = $datetime->getWeekDay();
		if ($d > 1)
			$datetime->modify('-' . ($d - 1) . ' day');

		$datetime->setTime(0, 0, 0);
		return $datetime;
	}

	public static function endOfWeek($date = null): DateTime {
		$datetime = static::factory($date);
		$d = $datetime->getWeekDay();
		if ($d < 7)
			$datetime->modify('+' . (7 - $d) . ' day');

		$datetime->setTime(23, 59, 59);
		return $datetime;
	}

	public static function beginOfHour($date = null) {

	}

	public static function endOfHour($date = null) {

	}

	public static function beginOfMinute($date = null) {

	}

	public static function endOfMinute($date = null) {

	}

	public static function beginOfDay($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime->setTime(0, 0, 0);
		return $datetime;
	}

	public static function endOfDay($date = null): DateTime {
		$datetime = static::factory($date);
		$datetime->setTime(23, 59, 59);
		return $datetime;
	}

	private static function factory($date) {
		if ($date instanceof DateTime)
			return $date;
		else
			return new DateTime($date);
	}
}