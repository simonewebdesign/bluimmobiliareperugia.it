<?php include_once '../library/bootstrap.php' ?>
<!doctype html>



<?=CREDITS?>




<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="it"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="it"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="it"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="it"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?=empty($template['title']) ? '' : $template['title'] . ' | '?><?=$settings['site']['name']?></title>
  <meta name="description" content="<?=$template['metaDescription']?>">
  <meta name="keywords"	content="<?=$template['metaKeywords']?>">
  <meta name="author" content="<?=$settings['site']['author']?>">
  <meta name="robots" content="<?=($template == 'backoffice') ? 'noindex,nofollow' : 'index,follow'?>">
  <meta name="viewport" content="width=device-width">

  <link rel="icon" type="image/png" href="<?=ROOT?>favicon.png">

  <?=$css?>

</head>
<body>

  <div id=wrapper>

	  <div id=header></div>
	  
	  <div id=navbar role=navigation>
		<?php include_once INC . 'menus/main.php' ?>
	  </div>
	  
	  <div id=main class=clearfix>
	  <?php include_once "../application/templates/{$template['name']}.php" ?>
	  </div>
	  
	  <div id=footer role=contentinfo>
		Copyright &copy; <?=YEAR . ' ' . $settings['site']['name']?>. Tutti i Diritti Riservati. - Via G. Lunghi 21, P.S. Giovanni (PG) - tel/fax: 075 3887423
	  </div>  
  </div>
  
  <div id=outer-footer>
	<a href="http://playpc.it">Powered by Playpc.it</a>
  </div>
  
  <!-- JavaScript begin -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script>
	var ROOT = '<?=ROOT?>'
	var ABSOLUTE_ROOT = '<?=ABSOLUTE_ROOT?>'
  </script>

  <?php if ( $template['name'] == 'backoffice' ) { ?>
  <script src="<?=ROOT?>js/ajax.js"></script>
  <script src="<?=ROOT?>js/backoffice.js"></script>
  <script src="<?=ROOT?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
  <script>
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons3 : "cut,copy,paste"
	});
  </script>  
  <?php } ?>
  
  <?php if ( $template['name'] == 'default' || $template['name'] == 'ricerca' ) { ?>
  <script src="<?=ROOT?>js/filters.js"></script>
  <script src="<?=ROOT?>js/jquery.lazyload.min.js"></script>
  <script>
	$(document).ready(function() {
		$('img.lazy').lazyload({ 
			effect : "fadeIn"
		});
	});
  </script>
  <!-- begin jQuery infinite scroll -->
  <script src="<?=ROOT?>js/jquery.infinitescroll.js"></script>
  <script>
  $('#middle-column').infinitescroll({
    loading: {
      finished: undefined,
      finishedMsg: "<em>Non ci sono più annunci.</em>", // <em>Congratulazioni, hai raggiunto la fine di Internet.</em>
      img: "", // http://www.infinite-scroll.com/loading.gif
      msgText: "", // <small style=\"color:#aaa\"><em>Caricamento in corso...</em></small>
      speed: 'fast',
    },
    state: {
      isDuringAjax: false,
      isInvalidPage: false,
      isDestroyed: false,
      isDone: false, // For when it goes all the way through the archive.
      isPaused: false,
      currPage: 1
    },
    callback: undefined,
    debug: true,
    behavior: undefined,
    binder: $(window), // used to cache the selector
    nextSelector: ".nextpage", // selector for the NEXT link (to page 2)
    navSelector: "#pages", // selector for the paged navigation (it will be hidden)
    extraScrollPx: 150,
    itemSelector: ".property-preview", // selector for all items you'll retrieve
    animate: false,
    pathParse: undefined,
    dataType: 'html',
    appendCallback: true,
    bufferPx: 40,
    errorCallback: function () { },
    infid: 0, //Instance ID
  });
  </script>
  <!-- end jQuery infinite scroll -->
  <?php } ?>

  <?php if ( $template['name'] == 'annuncio' ) { // galleria ?>
	<!-- Add galleria -->
	<script src="<?=ROOT?>galleria/galleria-1.2.7.min.js"></script>
	<!-- Load galleria classic theme -->
	<script src="<?=ROOT?>galleria/themes/classic/galleria.load.js"></script>	
	
  <?php } ?>

  <?php if ( $template['name'] == 'servizi' ) { ?>
	<script>
	$(document).ready(function() {
		$('#contact-button').on('click', function() {
			document.location.href = ROOT + 'contatti';
		});
	});	
	</script>
  <?php } ?>
  
  <!-- Asynchronous Google Analytics snippet. -->
  <script>
    var _gaq=[['_setAccount','<?=GOOGLE_ANALYTICS?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  <!-- JavaScript end --> 
  
  <?php
	/* BEGIN DEBUG
echo "<pre>";
	echo "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
	echo "DEBUG:\n";
	echo '$_SESSION = '; 		print_r($_SESSION);
	echo '$verbose = ';			print_r($verbose);		
	echo '$template_name = '; 	var_dump($template_name);
	echo '$table_name = ';		var_dump($table_name);
	echo '$action = ';		 	var_dump($action);
	echo '$id = ';				var_dump($id);
	echo '$session = ';			print_r($session);
	echo '$user = ';			print_r($user);
	echo '$_GET = ';			print_r($_GET);
	echo '$_POST = ';			print_r($_POST);
	echo '$get = ';				var_dump($get);
echo "</pre>";
	//* END DEBUG */
  ?>

</body>
</html>