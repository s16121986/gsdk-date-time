<?php

namespace Gsdk\DateTime;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\DateFactory;

class DateTimeServiceProvider extends ServiceProvider {

	public function register() {
		DateTime::setFormats([
			'date' => 'd.m.Y',
			'time' => 'H:i',
			'datetime' => 'd.m.Y H:i'
		]);

		DateFactory::useClass(DateTime::class);
	}

}
