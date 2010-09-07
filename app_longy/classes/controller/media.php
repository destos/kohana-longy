<?php defined('SYSPATH') or die('No direct script access.');

// Maybe move to its own module.
// Add versioning?

/* Usage 

$media = Route::get('app/media');
$this->template->styles = array(
				$media->uri(array('file' => 'css/print.css'))  => 'print',
				$media->uri(array('file' => 'css/screen.css')) => 'screen',
				$media->uri(array('file' => 'css/kodoc.css'))  => 'screen',
			);
			
// Add scripts
			$this->template->scripts = array(
				'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js',
				$media->uri(array('file' => 'js/kodoc.js')),
			)
*/
class Controller_Media extends Controller_Template {
	
	public function before(){
		$this->auto_render = FALSE;
		parent::before();
	}
	
	public function action_getfile()
	{
		// Get the file path from the request
		$file = $this->request->param('file');

		// Find the file extension
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		// Remove the extension from the filename
		$file = substr($file, 0, -(strlen($ext) + 1));

		if ($file = Kohana::find_file('media', $file, $ext))
		{
			// Send the file content as the response
			$this->request->response = file_get_contents($file);
		}
		else
		{
			// Return a 404 status
			$this->request->status = 404;
		}

		// Set the content type for this extension
		$this->request->headers['Content-Type'] = File::mime_by_ext($ext);
	}
	
	public function after(){
		return parent::after();
	}
}
