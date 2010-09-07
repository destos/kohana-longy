<?php

class Controller_Api extends Controller {
	
	private $to_return;
	
	function before(){
		
		// filter get vars.
		foreach( $_GET as $gkey => $gval ){
		
			$gkey = Security::xss_clean($gkey);
			$gval = Security::xss_clean($gval);
			
			$this->get[$gkey] = $gval;
		}
		
		unset($_GET);
	}

	function action_create(){
		
		$to_insert['length'] = $this->get['length'];
		// check length
		$to_insert['url'] = $this->get['url'];
		
		$url = new Model_Url('default');
		
		if( $id = $url->add($to_insert) ){
			
			$hash_route = Route::get('redirect/hash')->uri( array( 'hash'=> $url->get_hash() ) );
			
			$this->to_return['hash'] = $url->get_hash();
			$this->to_return['long_url'] = Url::site($hash_route, true);
			$this->to_return['unique_id'] = $id;
			
/* 			var_dump($this->to_return); */
		}else{ // error adding
			
			$this->to_return['error'] = 'we wheren\'t able to create that url for some gosh darned reason. the database eleves are probably to blame again';
			$this->to_return['error_code'] = 2 ;
		}
			
	}
	
	function action_lookup(){
	
		$to_lookup = $this->request->param('singlekey');
				
		$url = new Model_Url('default');
		
		if( $url = $url->lookup_url( $to_lookup ) ){
			$this->to_return['url'] = $url;
		}else{
			$this->to_return['error'] = 'we wheren\'t able to find that url for some gosh darned reason. I bet faries took it!';
			$this->to_return['error_code'] = 3 ;
		}
	}
	
	function action_stats(){
		
		$to_lookup = $this->request->param('singlekey');
		
		//if( !$to_lookup )
			
		$url = new Model_Url('default');
		
		if( $stats = $url->get_stats( $to_lookup ) ){
			
			//print_r($stats);
			$this->to_return = $stats;
			
		}else{
			$this->to_return['error'] = 'no dissasemble stats! no dissasemble!';
			$this->to_return['error_code'] = 4 ;
		}
	}
	
	function super_secret(){
		
	}
	
	function after(){
		
		if( empty($this->to_return) ){
			$this->to_return['error'] = 'some error we have no intention of fixing occured. sorry';
			$this->to_return['error_code'] = 1 ;
		}
		
		// set response
		if( !empty($this->get['callback']) ){
			$this->request->response =  $this->get['callback'].'('.json_encode( $this->to_return ).')';
			
		}else{
			$this->request->response =  json_encode( $this->to_return );
		}
		
		// Set the content type by json extension
		if( Request::$is_ajax ) // for debuggin
			$this->request->headers['Content-Type'] = File::mime_by_ext('json');
		
	}
}