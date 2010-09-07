<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static extends Controller_Template {

	public $template = 'main/template';
	
	public function action_load($page){
		
		$this->page = $page;
		
		// Get the path for this page
		//$file = $this->file($page);

		if ( ! $static_view = View::factory('static/'.$page) )
		{
			throw new Kohana_Exception('Staic page not found: :page',
				array(':page' => $page));
		}
		
		$this->template->title = $page;
		 
		$this->template->content = $static_view;
		
		$topnav = Model_Nav::get_nav();
		$this->template->bind('topnav', $topnav);
	}
	
	// media attachment to view
	public function after(){
	
		if( $this->auto_render ){
			$media = Route::get('app/media');
			
			// Add Styles
			$this->template->styles = array(
				$media->uri(array('file' => 'css/main.css')) => 'screen',
				$media->uri(array('file' => 'css/static.css')) => 'screen',
			);
			
			if($this->page == 'api')
			$this->template->scripts = array(
				$media->uri(array('file' => 'js/jquery-1.3.2.min.js')),
				$media->uri(array('file' => 'js/api_page.js'))
			);
		}
		parent::after();
	}
	
	public function file($page)
	{
	/*
	if ( ! ($file = Kohana::find_file('views', "{$this->_lang}/$page", 'md')))
		{
*/
			// Use the default file
			$file = Kohana::find_file('views', 'static/'.$page, 'md');
		/* } */

		return $file;
	}

}