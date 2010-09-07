<?php
// --------------------------------------------------------
// Example generator
//
function example( $query = null, $request = array('action' => 'create', 'singlekey' => null ), $route = 'app/api'){
	$route = Route::get( $route )->uri( $request ).URL::query($query);
	return '<p><sub>click link to make call:</sub></p><code>'
		.HTML::anchor( $route, URL::site($route, true ), array('target'=>'_blank'), true ).'</code>';
}

$url = new Model_Url('default');
$url = $url->random_url();
$hash = $url['hash'];

?><div id="content" class="api wrap">
	<h2>API</h2>
	<div class="container">
	<p style="text-align:right;">For when it just isn't long enough.</p>
	<p style="text-align:right; margin-top:-10px;">-the Longy API</p>
	<p>Currently the api returns all results in json, mainly because thats the simplest way to do it in php. If you complain enough I might add another format.</p>
	
	
	
	<h3>Create</h3>
	<p>Need to create a new long url lickity split? fret no longer!</p>
	<?=example( array( 'url'=>'http://test.com', 'length'=> 35, 'callback' => 'testing' ) )?>
	
	<h4>Accepted get variables</h4>
	<p><b>url</b> (required)  - the url to be lengthened, url escaped.</p>
	<p><b>length</b> - defaults to the shortest length as represented by the value of 1. ( 25 characters )</p>
	<p>It also accepts the values 2 (250) and 3 (500), as used by the longer and longest settings on the front page. You can also specify your own length by using numbers above 3 with a limit of up to 500.</p>
	<p><b>callback</b> (optional) - callback function</p>
		
	<h4>Returns</h4>
	<p><b>hash</b> - hash generated for url</p>
	<p><b>long_url</b> - url to link to hash for convinence</p>
	<p><b>unique_id</b> - debating whether to return this as it means people can sniff for other urls by iterating on this</p>
	
	
	
	<h3>Lookup</h3>
	<p>What's behind that mysteriously long url? find out!</p>
	<p>A randomly selected hash is used for this example, it may or may not contain statistics.</p>
	<?=example(  array('callback' => 'process_url' ), array('action' => 'lookup', 'singlekey' => $hash ) )?>
	
	<h4>Accepted uri paramater</h4>
	<p>you can use either the hash or unique_id to lookup a url.</p>

	<h4>Accepted get variables</h4>
	<p><b>callback</b> (optional) - callback function</p>
	
	<h4>Returns</h4>
	<p><b>url</b> - the url</p>
	
	
	
	<h3>Stats</h3>
	<p>Lookup stats for urls!</p>
	<p>Basically returns the entire stats database table rows for that particular url</p>
	<p>A randomly selected hash is used for this example, it may or may not contain statistics.</p>
	<?=example(  array('callback' => 'process_stats' ), array('action' => 'stats', 'singlekey' => $hash ) )?>
	
	<h4>Accepted uri paramater</h4>
	<p>url hash or unique id</p>
	
	<h4>Accepted get variables</h4>
	<p><b>callback</b> (optional) - callback function</p>
	
	<h4>Returns</h4>
	<p>Everything!</p>
	
	<p>Things that need done - limiting and offsetting of the returned values from the database.</p>
<!--
	<h3></h3>
	<p></p>
-->
	</div>
</div>