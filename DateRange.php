<?php

namespace Gsdk\DateTime;

class DateRange {

	protected $from;

	protected $to;

	public function __construct($period, $dateTo = null) {
		if (null !== $dateTo)
			$this
				->from($dateTo)
				->to($dateTo);
		else if (is_string($period))
			$this->fromString($period);
		else if ($period instanceof DateRange)
			$this
				->from($period->from)
				->to($period->to);
		else if (is_array($period)) {
			$get = function (...$keys) use ($period) {
				foreach ($keys as $key) {
					if (isset($period[$key]))
						return $period[$key];
				}
				return null;
			};

			if (($from = $get(0, 'from', 'valueFrom')))
				$this->from($from);

			if (($from = $get(1, 'to', 'valueTo')))
				$this->to($from);
		}
	}

	public function __get($name) {
		return $this->$name ?? null;
	}

	public function from($date) {
		$this->from = static::dateFactory($date);
		return $this;
	}

	public function to($date) {
		$this->to = static::dateFactory($date);
		return $this;
	}

	public function today(): static {
		return $this
			->from(now())
			->to(now());
	}

	public function yesterday(): static {
		$from = now();
		$from->modify('-1 day');
		return $this
			->from(DateFactory::beginOfDay($from))
			->to(DateFactory::endOfDay($from->clone()));
	}

	public function last7days(): static {
		$from = now();
		$from->modify('-7 day');

		return $this
			->from(DateFactory::beginOfDay($from))
			->to(DateFactory::endOfDay());
	}

	public function last14days(): static {
		$from = now();
		$from->modify('-14 day');
		return $this
			->from(DateFactory::beginOfDay($from))
			->to(DateFactory::endOfDay());
	}

	public function last30days(): static {
		$from = now();
		$from->modify('-30 day');
		return $this
			->from(DateFactory::beginOfDay($from))
			->to(DateFactory::endOfDay());
	}

	public function thisYear(): static {
		return $this
			->from(DateFactory::beginOfYear())
			->to(DateFactory::endOfYear());
	}

	public function prevYear(): static {
		$date = now();
		$date->modify('-1 year');
		return $this
			->from(DateFactory::beginOfYear($date))
			->to(DateFactory::endOfYear($date->clone()));
	}

	public function thisMonth(): static {
		return $this
			->from(DateFactory::beginOfMonth())
			->to(DateFactory::endOfMonth());
	}

	public function prevMonth(): static {
		$date = now();
		$date->modify('-1 month');
		return $this
			->from(DateFactory::beginOfMonth($date))
			->to(DateFactory::endOfMonth($date->clone()));
	}

	public function nextMonth(): static {
		$date = now();
		$date->modify('+1 month');
		return $this
			->from(DateFactory::beginOfMonth($date))
			->to(DateFactory::endOfMonth($date->clone()));
	}

	public function thisWeek(): static {
		return $this
			->from(DateFactory::beginOfWeek())
			->to(DateFactory::endOfWeek());
	}

	public function prevWeek(): static {
		$date = now();
		$date->modify('-1 week');
		return $this
			->from(DateFactory::beginOfWeek($date))
			->to(DateFactory::endOfWeek($date->clone()));
	}

	public function nextWeek(): static {
		$date = now();
		$date->modify('+1 week');
		return $this
			->from(DateFactory::beginOfWeek($date))
			->to(DateFactory::endOfWeek($date->clone()));
	}

	public function fromString(string $period): static {
		switch ($period) {
			case 'all':
				return $this->reset();
			case 'today':
				return $this->today();
			case 'last7days':
				return $this->last7days();
			case 'last14days':
				return $this->last14days();
			case 'last30days':
				return $this->last30days();
			case 'thisyear':
				return $this->thisYear();
			case 'prevyear':
				return $this->prevYear();
			case 'thismonth':
				return $this->thisMonth();
			case 'prevmonth':
				return $this->prevMonth();
			case 'nextmonth':
				return $this->nextMonth();
			case 'thisweek':
				return $this->thisWeek();
			case 'prevweek':
				return $this->prevWeek();
			case 'nextweek':
				return $this->nextWeek();
		}

		$x = explode(' - ', $period);

		$this->from($x[0]);

		if (isset($x[1]))
			$this->to($x[1]);

		return $this;
	}

	public function getInterval() {
		return $this->to->diff($this->from);
	}

	public function fromFormat($format = 'date') {
		return static::dateFormat($this->from, $format);
	}

	public function toFormat($format = 'date') {
		return static::dateFormat($this->to, $format);
	}

	public function isEmpty(): bool {
		return null === $this->from && null === $this->to;
	}

	public function isRange(): bool {
		return null !== $this->from && null !== $this->to;
	}

	public function hasLowerBound(): bool {
		return null !== $this->from;
	}

	public function hasUpperBound(): bool {
		return null !== $this->to;
	}

	public function __toString(): string {
		return $this->fromFormat() . ' - ' . $this->toFormat();
	}

	private static function dateFactory($date): DateTime {
		return new DateTime($date);
	}

	private static function dateFormat($date, $format) {
		return $date ? $date->format($format) : null;
	}

}
