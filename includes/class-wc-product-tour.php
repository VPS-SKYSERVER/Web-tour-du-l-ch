<?php
/**
 * Custom WooCommerce Product Type: Tour
 *
 * @package TravelTour
 */

if (!defined('ABSPATH')) {
    exit;
}

class WC_Product_Tour extends WC_Product {
    
    /**
     * Get product type
     */
    public function get_type() {
        return 'tour';
    }
    
    /**
     * Check if product is virtual
     */
    public function is_virtual() {
        return true;
    }
    
    /**
     * Check if product is downloadable
     */
    public function is_downloadable() {
        return false;
    }
    
    /**
     * Get tour duration
     */
    public function get_tour_duration() {
        return $this->get_meta('_tour_duration');
    }
    
    /**
     * Get tour itinerary
     */
    public function get_tour_itinerary() {
        return $this->get_meta('_tour_itinerary');
    }
    
    /**
     * Get tour departure
     */
    public function get_tour_departure() {
        return $this->get_meta('_tour_departure');
    }
    
    /**
     * Get tour destination
     */
    public function get_tour_destination() {
        return $this->get_meta('_tour_destination');
    }
}

