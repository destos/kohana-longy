<?php

class Model_Nav extends Model{

	public function __construct(){
		return $this->get_nav();
		
		//parent::__construct();
	}
	
	public static function get_nav(){
	
		$static_page = Route::get('app/static');
		
		$topnav = array();
		$topnav[$static_page->uri(array('page' => 'faq'))] = __('FAQ');
		$topnav[$static_page->uri(array('page' => 'api'))] = __('API');
		$topnav[$static_page->uri(array('page' => 'contact'))] = __('Contact');
		
		return $topnav;
	}
	
}