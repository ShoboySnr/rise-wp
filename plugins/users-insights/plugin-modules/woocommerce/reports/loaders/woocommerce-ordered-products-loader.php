<?php

class USIN_Woocommerce_Ordered_Products_Loader extends USIN_Standard_Report_Loader {

	protected function load_data() {
		return $this->get_results();
	}

	protected function get_results($order_status = null) {
		global $wpdb;
		$filter = $this->getSelectedFilter();
		$period_condition = USIN_Standard_Report_With_Period_Filter::generate_condition($filter, 'orders.post_date');
		$status_condition = $order_status ? $wpdb->prepare(' AND orders.post_status = %s', $order_status) : '';

		$query = $wpdb->prepare("SELECT COUNT(*) AS $this->total_col, products.post_title AS $this->label_col" .
			" FROM " . $wpdb->prefix . "woocommerce_order_itemmeta AS meta" .
			" INNER JOIN $wpdb->posts AS products ON meta.meta_value = products.ID" .
			" INNER JOIN {$wpdb->prefix}woocommerce_order_items AS items ON meta.order_item_id = items.order_item_id" .
			" INNER JOIN $wpdb->posts AS orders on items.order_id = orders.ID AND orders.post_type = %s" .
			" WHERE meta_key = '_product_id'" . $period_condition . $status_condition .
			" GROUP BY meta_value ORDER BY $this->total_col DESC LIMIT $this->max_items", USIN_Woocommerce::ORDER_POST_TYPE);

		return $wpdb->get_results($query);
	}
}