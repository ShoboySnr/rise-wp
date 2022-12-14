<?php

if (!defined('ABSPATH')) {
	exit;
}


class USIN_WC_Memberships extends USIN_Plugin_Module {

	protected $module_name = 'wc-memberships';
	protected $plugin_path = 'woocommerce-memberships/woocommerce-memberships.php';
	protected static $statuses = null;

	const POST_TYPE = 'wc_user_membership';


	protected function apply_module_actions() {
		add_filter('usin_exclude_post_types', array($this, 'exclude_post_types'));
	}


	public function init() {
		new USIN_WC_Memberships_Query(self::POST_TYPE);
		new USIN_WC_Memberships_User_Activity(self::POST_TYPE);
	}


	public function register_module() {
		return array(
			'id' => $this->module_name,
			'name' => __('WooCommerce Memberships', 'usin'),
			'desc' => __('Retrieves and displays the data from the WooCommerce Memberships extension.', 'usin'),
			'allow_deactivate' => true,
			'buttons' => array(
				array('text' => __('Learn More', 'usin'), 'link' => 'https://usersinsights.com/woocommerce-memberships-search-filter-user-data/', 'target' => '_blank')
			),
			'active' => false
		);
	}

	protected function init_reports() {
		new USIN_WC_Memberships_Reports($this);
	}

	public function register_fields() {
		return array(

			array(
				'name' => __('Has a membership', 'usin'),
				'id' => 'has_membership',
				'order' => false,
				'show' => false,
				'hideOnTable' => true,
				'fieldType' => $this->module_name,
				'icon' => 'woocommerce',
				'filter' => array(
					'type' => 'combined',
					'items' => array(
						array('name' => __('Plan', 'usin'), 'id' => 'plan', 'type' => 'select', 'options' => self::get_membership_plans()),
						array('name' => __('Status', 'usin'), 'id' => 'status', 'type' => 'select', 'options' => self::get_status_options()),
						array('name' => __('Start date', 'usin'), 'id' => 'start_date', 'type' => 'date'),
						array('name' => __('Expiry date', 'usin'), 'id' => 'end_date', 'type' => 'date'),
						array('name' => __('Cancelled date', 'usin'), 'id' => 'cancelled_date', 'type' => 'date'),
					),
					'disallow_null' => true
				),
				'module' => $this->module_name
			),
			array(
				'name' => __('Memberships', 'usin'),
				'id' => 'membership_num',
				'order' => 'DESC',
				'show' => true,
				'fieldType' => $this->module_name,
				'filter' => array(
					'type' => 'number',
					'disallow_null' => true
				),
				'icon' => 'woocommerce',
				'module' => $this->module_name
			),

			array(
				'name' => __('Member since', 'usin'),
				'id' => 'member_since',
				'order' => 'DESC',
				'show' => true,
				'fieldType' => $this->module_name,
				'filter' => array(
					'type' => 'date'
				),
				'icon' => 'woocommerce',
				'module' => $this->module_name
			),

			array(
				'name' => __('Membership statuses', 'usin'),
				'id' => 'membership_statuses',
				'order' => 'ASC',
				'show' => false,
				'fieldType' => $this->module_name,
				'filter' => array(
					'type' => 'include_exclude',
					'options' => self::get_status_options()
				),
				'icon' => 'woocommerce',
				'module' => $this->module_name
			),

			array(
				'name' => __('Active memberships', 'usin'),
				'id' => 'active_memberships',
				'order' => false,
				'show' => false,
				'fieldType' => $this->module_name,
				'filter' => false,
				'icon' => 'woocommerce',
				'module' => $this->module_name
			),

			array(
				'name' => __('Membership plans', 'usin'),
				'id' => 'has_membership_plan',
				'show' => false,
				'hideOnTable' => true,
				'fieldType' => $this->module_name,
				'filter' => array(
					'type' => 'include_exclude',
					'options' => self::get_membership_plans()
				),
				'icon' => 'woocommerce',
				'module' => $this->module_name
			)
		);
	}

	public static function get_statuses() {
		if (self::$statuses === null) {
			//load the statuses
			if (function_exists('wc_memberships_get_user_membership_statuses')) {
				self::$statuses = wc_memberships_get_user_membership_statuses();
			} else {
				self::$statuses = array();
			}
		}
		return self::$statuses;
	}

	public static function get_status_options($assoc_res = false) {
		$status_options = array();

		$wcm_statuses = self::get_statuses();
		foreach ($wcm_statuses as $status_key => $status) {
			if ($assoc_res) {
				$status_options[$status_key] = $status['label'];
			} else {
				$status_options[] = array('key' => $status_key, 'val' => $status['label']);
			}
		}

		return $status_options;
	}

	public static function get_membership_plans($assoc_res = false) {
		$plan_options = array();
		if (function_exists('wc_memberships_get_membership_plans')) {
			$wcm_plans = wc_memberships_get_membership_plans();
			foreach ($wcm_plans as $plan) {
				if ($assoc_res) {
					$plan_options[$plan->id] = $plan->name;
				} else {
					$plan_options[] = array('key' => $plan->id, 'val' => $plan->name);
				}
			}

		}
		return $plan_options;
	}


	public function exclude_post_types($exclude) {
		$exclude[] = self::POST_TYPE;
		return $exclude;
	}

	/**
	 * Check if the WooCommerce Subscriptions AND WooCommerce are active
	 * @return boolean [description]
	 */
	protected function is_plugin_active() {
		return parent::is_plugin_active() && USIN_Helper::is_plugin_activated('woocommerce/woocommerce.php');
	}

}

new USIN_WC_Memberships();