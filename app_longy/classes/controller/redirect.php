<?php

class Controller_Redirect extends Controller {
	
	function action_go(){
		
		//Hash lookup
		
		$hash = mysql_escape_string($this->request->param('hash'));
		
		// TODO: clean hash for xxs 
		
		if(!$hash){
			throw new Kohana_Exception('You must have a site hash to get redirected!');
		}
		
		$url = new Model_Url('default');
		
		$url_addr = $url->lookup_url($hash);
		$url_id = $url->get_id();
		
		// If we have a valid url
		if( $url ){
			
			$url->add_stat();
				
			// redirect to url
			$this->request->redirect( $url_addr );
		}else{
			// redirect home as no hash was found, display error
			$this->request->redirect( url::site('/not-found') );
		}
		
	}
	
}