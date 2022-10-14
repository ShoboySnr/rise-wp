<?php

class USIN_Standard_Report_With_Period_Filter extends USIN_Standard_Report {
	public $subtype = 'standard_with_period_filter';

	const ALL_TIME = 'all';
	const LAST_7_DAYS = 'last_7_days';
	const LAST_30_DAYS = 'last_30_days';
	const LAST_6_MONTHS = 'last_6_months';
	const LAST_12_MONTHS = 'last_12_months';
	const CUSTOM = 'custom_period';
	const PERIOD_SEPARATOR = '_';

	public static function get_period_dates($period_key) {
		if ($period_key == self::ALL_TIME) {
			// all time filter
			return array(null, null);
		}

		if (strpos($period_key, 'last_') === 0) {
			// it's a last N days/months filter
			$today = new DateTime(current_time('mysql'));
			$start_date = $today->sub(self::get_interval($period_key));
			// add one more day as today counts as well
			$start_date = $start_date->add(new DateInterval('P1D'))->format('Y-m-d');
			return array($start_date, null);
		}

		if (strpos($period_key, self::PERIOD_SEPARATOR)) {
			// it's a period in the format YYYY-MM-DD:YYYY-MM-DD
			// when either side of the period is null it will be "none", e.g. YYYY-MM-DD:none
			$parts = explode(self::PERIOD_SEPARATOR, $period_key);
			$start_date = $parts[0] == 'none' ? null : $parts[0];
			$end_date = $parts[1] == 'none' ? null : $parts[1];;

			return array($start_date, $end_date);
		}
	}

	public static function generate_condition($period_key, $column_name) {
		global $wpdb;
		$condition = '';

		list($start_date, $end_date) = self::get_period_dates($period_key);

		if ($start_date != null) {
			$condition .= $wpdb->prepare(" AND $column_name >= %s", $start_date);
		}

		if ($end_date != null) {
			$condition .= $wpdb->prepare(" AND $column_name <= %s", $end_date);
		}

		return $condition;
	}

	public static function get_interval($period_key) {
		$intervals = array(
			self::LAST_7_DAYS => 'P7D',
			self::LAST_30_DAYS => 'P30D',
			self::LAST_6_MONTHS => 'P6M',
			self::LAST_12_MONTHS => 'P12M',
		);
		if (isset($intervals[$period_key])) {
			return new DateInterval($intervals[$period_key]);
		}
	}

	public function __construct($id, $name, $options = array()) {
		parent::__construct($id, $name, $options);

		$this->set_filters();
	}

	protected function set_filters() {
		if (!$this->filters) {
			$this->filters = array(
				'options' => $this->get_default_periods(),
				'default' => self::ALL_TIME
			);
		}
	}


	protected function get_default_periods() {
		return array(
			self::ALL_TIME => __('All time', 'usin'),
			self::LAST_7_DAYS => __('Last 7 days', 'usin'),
			self::LAST_30_DAYS => __('Last 30 days', 'usin'),
			self::LAST_6_MONTHS => __('Last 6 months', 'usin'),
			self::LAST_12_MONTHS => __('Last 12 months', 'usin'),
			self::CUSTOM => __('Custom', 'usin')
		);
	}

}