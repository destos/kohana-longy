<?php

class Model_Url extends Model{
	
	private $_hash;
	private $_id;
	public $url_tbl = 'urls';
	public $url_stats_tbl = 'url_refer';
	
	public function __construct(){
	
		parent::__construct();
	}
	
	// --------------------------------------------------------
	// Add new url, takes the array values of 'url' and 'length' from $data argument
	//
	public function add( $data ){
		
		// filter data?
		
		if(is_numeric($data['length'])){
			switch( $data['length'] ){
				case 1:
					$data['length'] = 25;
				break;
				case 2:
					$data['length'] = 250;
				break;
				case 3:
					$data['length'] = 500;
				break;
				default:
						$data['length'] = ( $data['length'] > 500 ) ? 500 : $data['length'];
				break;
			}
			
		}else{
			if(empty($data['length']))
				$data['length'] = 25;
		}
		
		$ins_data['url'] = Security::xss_clean ( $data['url'] );
		$ins_data['hash'] = $this->_hash = $this->hash_gen( false, $data['length'] ); //$data['url'] // Add local hash value
		$ins_data['time'] = time();
		
		unset($data['length']);
		
		try{
			
			if( is_array( $data ) ){
			
				list( $insert_id, $total_rows ) = DB::insert($this->url_tbl, array_keys( $ins_data ) )->values( $ins_data )->execute();
				
				// see if we were sucessful
				if( $total_rows >= 1 ){
					return $insert_id;
				}else{
					return false;
				}
				
			}else{
				return false;
			}
		
	  }catch( Database_Exception $e ){
	  
      echo $e->getMessage();
    }
		
	}
	
	// --------------------------------------------------------
	// Looks up url, accepts id number and hash.
	//
	public function lookup_url($key){
		
		if(!$key){
			return false;
			
		}else{
					
			try{
			
				//$url = $this->_db->from($this->url_tbl);
				$query = DB::select( 'url','id' )->from($this->url_tbl);
				
				//echo Kohana::debug($url);
				
					// filter key
					if( is_numeric($key) ){
						$where = 'id';
						$query->where('id','=', $key);
					}else{
						$query->where('hash','=', $key);
					}
				
				//$url->get('url');
				$url = $query->execute()->current();
				
			}catch( Database_Exception $e ){
			
				echo $e->getMessage();
				
			}
			
			//echo Kohana::debug($url);
			
			//print_r($url);
			
			$this->_id = $url['id'];
			return $url['url'];

		}
	}
	
	public function get_hash(){
		return ( isset( $this->_hash ) ) ?	$this->_hash : false ;
	}
	public function get_id(){
		return ( isset( $this->_id ) ) ?	$this->_id : false ;
	}
	
	// --------------------------------------------------------
	// Add Statistic record to the database, lookup_url() must be run first. 
	//
	public function add_stat(){
		
		// if we haven't retrieved a url don't run stat.
		if(!$this->_id)
			return false;
			
		$ref = Request::$referrer;
	
		$unique_ref = md5( $this->_id.'|'.$ref );
		
		if($ref == '' or !$ref){
				$ref = 'none';
			}
		
		$time = time();
		
		$ref_insert = DB::query(Database::INSERT, 'INSERT INTO url_refer ( url_id , last_hit, referer ,ref_id_unique ) Values ( :urlid , :time, :ref, :un_ref ) ON DUPLICATE KEY UPDATE last_hit = :time, num = num + 1')
				->bind(':urlid', $this->_id )
				->bind(':ref', $ref)
				->bind(':un_ref', $unique_ref)
				->bind(':time', $time)
				->execute();
		
		return $ref_insert;
		
	}
	
	// --------------------------------------------------------
	// Get Statistics from a single url, requires hash or key, returns array of statistics
	//
	
	public function get_stats( $key ){
		
		// Key can be a hash or id ( loockup by url ? )
		
		try{
			
			$q = DB::select()->from($this->url_stats_tbl);
			
			if( is_numeric($key) ){ // key is id
				
				$q->where( 'url_id','=',$key );
				
			}else if( is_string($key) ){ // key is a string
				
				// Get id of hash
				$q->join( $this->url_tbl )->on( $this->url_tbl.'.id', '=', $this->url_stats_tbl.'.url_id')->where( $this->url_tbl.'.hash','=', $key );
				
			}else{
				return false;
			}
			
			$stats = $q->execute()->as_array();
			
		}catch( Database_Exception $e ){			
			echo $e->getMessage();			
		}
		
		return $stats;
		
	}
	
	// --------------------------------------------------------
	// Rettrieve random url
	//
	
	public function random_url(){
	
		try{
			// orderby doesn't allow single values such as RAND() function
			//$q = DB::select()->from($this->url_tbl)->order_by(null,'RAND()')->limit(1)->execute()->current();
			//$q->_order_by[] = array('',"RAND()"); // doesn't work
			
			$q = DB::query(Database::SELECT, ' SELECT * FROM `urls` ORDER BY RAND() LIMIT 1 ')->execute()->current();
			
			return $q;
			
		}catch( Database_Exception $e ){			
			echo $e->getMessage();			
		}
		
		return false;
		
	}
	
	// --------------------------------------------------------
	// Hash generator
	//
	private function hash_gen( $url = false, $length = 8 ){
	
		// TODO: incorporate url somehow
		
		return Text::random( 'alnum', $length ); 
    
	}
	
}