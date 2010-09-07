<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php echo $title ?> | Longy</title>

<?php 
if (!empty($styles))
foreach ($styles as $style => $media) echo HTML::style($style, array('media' => $media), TRUE), "\n" ?>
<?php 
if (!empty($scripts))
foreach ($scripts as $script) echo HTML::script($script, NULL, TRUE), "\n" ?>

	<link rel="shortcut icon" href="<?=URL::base()?>fav.png" />
</head>
<body>

<div id="topbar">
	<div class="wrap">
		<span>Pat's Lab</span>
		<h1 class="logo"><?= HTML::anchor( Route::get('default')->uri(array(
		'controller' => '',
		'action'     => '',)), 'Longy')?></h1>
		<ul class="top_nav">
		<? if( !empty($topnav) ):
				foreach($topnav as $link => $text ): ?>
			<li><?= is_int($link) ? $title : HTML::anchor($link, $text)  ?></li>
			<? endforeach;
			endif ?>
		</ul>
	</div>
</div>

<?php echo $content ?>

<div id="footer" class="wrap">
		<p class="note"><sup>(1)</sup> guaranteed not to fit in a tweet.</p>
		<p class="copyright">&copy; 2009 Patrick Forringer</p>
		<p class="powered">Powered by <?php echo HTML::anchor('http://kohanaphp.com/', 'Kohana') ?> v<?php echo Kohana::VERSION ?></p>
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-475393-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
