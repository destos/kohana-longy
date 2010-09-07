<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front extends Controller_Template {

	public $template = 'main/template';
	
	// --------------------------------------------------------
	// Main Index for front page and site url adding handler.
	//
	
	public function action_index(){
		
		$success = false;
		
		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')
			->rule('url', 'not_empty')
			//->rule('url', 'regex', array('#^https?://.+$#')) // website url regex
			->rule('url', 'url')
			->rule('length', 'not_empty')
			->filter('url', 'Security::xss_clean')
			->filter('length', 'Security::xss_clean');

/*
//->rule('title', 'regex', array('/^[\pL\pP\s]{4,255}$/iu')) // 4-255 character regex and more?
->rule('completed', 'not_empty')
->rule('completed', 'date');
*/
		$errors = $post->errors();
		
		if ($post->check($errors)){
			
			// Get the values of the array
			$values = $post->as_array();
			
			// load url model
			$url = new Model_Url;
		
			if( $id = $url->add($values) ){
				$hash = $url->get_hash();
			}else{ // error adding
				
				
			}
				
		}
		
		// --------------------------------------------------------
		// Output
		//
		$topnav = Model_Nav::get_nav();
		
		/* $topnav = $topnav->get_nav(); */
		
		$this->template->content = View::factory('front_page/main');
/* 			->bind('topnav',$topnav); */
		
		$this->template->bind('topnav', $topnav);
					
		$this->template->title = 'Create yours today!';
		
		if( !empty($url) ){
		
			$hash_url = URL::site( Route::get('redirect/hash')->uri(array('hash' => $hash )), true);
				
			//add success
			$success = true;
			$success_form = View::factory('front_page/success_form', array('hash_url' => $hash_url ));
			
		}else{
			$success = false;
			$success_form = '';
		}
		
		if( Request::$is_ajax ){ // return json
			
			$this->auto_render = false;
			
			// set response
			$this->request->response = json_encode( array( 'success' => $success, 'new_html' => is_object($success_form) ? $success_form->render() : $success_form ) );
			
			// Set the content type json extension
			$this->request->headers['Content-Type'] = File::mime_by_ext('json');
						
		}else if($success){ // return html
			
			$this->template->content->form = $success_form;			

		}else{
		
			// check for error id
			$id = $this->request->param('id');
			
			if( $id == 'not-found' ){
				$this->template->title .= ' | No URL found';
				$this->template->content  = View::factory('front_page/bad_link');
				
			}else{
				$this->template->content->form = View::factory('front_page/add_form', array('post' => $post, 'errors' => $errors ));			
	/*
				->bind('post', $post)
				->bind('errors', $errors);		// Validate
*/
			}

		}
		
	}
	
	// media attachment to view
	public function after(){
	
		if( $this->auto_render ){
			$media = Route::get('app/media');
			
			// Add Styles
			$this->template->styles = array(
				$media->uri(array('file' => 'css/main.css')) => 'screen',
			);
			
			// Add scripts
			$this->template->scripts = array(
				//'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js',
				$media->uri(array('file' => 'js/jquery-1.3.2.min.js')),
				$media->uri(array('file' => 'js/jquery.autofill.js')),
				$media->uri(array('file' => 'js/jquery.form.js')),
				$media->uri(array('file' => 'js/front_page.js')),
			);
		}
		parent::after();
	}
}