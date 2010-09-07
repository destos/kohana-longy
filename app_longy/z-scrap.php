<?		
$got_hash = DB::query(Database::SELECT, 'SELECT url, id FROM urls WHERE hash = :hash LIMIT 1')
			->bind(':hash', $hash )
			->execute();

			//->as_array('id', 'url');