<?php

class WC_Product_Listing_Download_Plan extends WC_Product {

    public function get_type() {
        return 'listing_download_plan';
    }

    public function is_sold_individually() {
		return true;
	}

    public function is_purchasable() {
		return true;
	}

    public function is_virtual() {
		return true;
	}

    public function is_visible() {
		return false;
	}

}
