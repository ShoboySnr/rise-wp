<?php

class USIN_Woocommerce_Coupons_Used_Loader extends USIN_Standard_Report_Loader {

	protected function load_data(){
		global $wpdb;

		$filter = $this->getSelectedFilter();
		$period_condition = USIN_Standard_Report_With_Period_Filter::generate_condition($filter, 'orders.post_date');

		$query = $wpdb->prepare("SELECT COUNT(*) AS $this->total_col, order_item_name AS $this->label_col".
			" FROM ".$wpdb->prefix."woocommerce_order_items AS items".
			" INNER JOIN $wpdb->posts AS orders on items.order_id = orders.ID AND orders.post_type = %s" .
			" WHERE order_item_type = 'coupon'".$period_condition.
			" GROUP BY order_item_name ORDER BY $this->total_col DESC LIMIT $this->max_items", USIN_Woocommerce::ORDER_POST_TYPE);

		return $wpdb->get_results( $query );

	}


}