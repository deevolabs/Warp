<?php  
/*
Lazy load image processor
Modifica o parametro src de  todas as tags "<img>" para template_directory/images/transparent.png
*/




function callback($buffer) {

  /*
  //example replacing
  $replace = array(
    'lazy' => 'lazy laziest',
    'google' => '<a href="http://www.google.com/">excerpt</a>',
    'function' => '<a href="#">function</a>'
  );
  $buffer = str_replace(array_keys($replace), $replace, $buffer);
  */


libxml_use_internal_errors(true);//supress PHP warnings
	$doc = new DOMDocument();
  $searchPage = mb_convert_encoding($buffer, 'HTML-ENTITIES', "UTF-8");
  @$doc->loadHTML($searchPage);
	$finder = new DomXPath($doc);
libxml_use_internal_errors(false);//restore PHP warnings

  //lazy load images ----------------------------------------------
	$classname = 'lazy';
  $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
  foreach ($nodes as $node) {
      //return 'nodename:'.$node->nodeName;
      if($node->nodeName=='img'){
        $transparent = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';        
        $transparent = get_bloginfo('template_directory') . '/images/transparent.png';        
        $src = $node->getAttribute('src');
        $node->removeAttribute('src');
        $node->setAttribute('src',$transparent);
        $node->setAttribute('data-src',$src);        
      }else if($node->nodeName=='video'){
          $sources = $node->getElementsByTagName('source');
          foreach ($sources as $source) {
            $src = $source->getAttribute('src');
            $source->removeAttribute('src');
            //$source->setAttribute('src','');
            $source->setAttribute('data-src',$src);
        }
      }
  }
 	$buffer = $doc->saveHTML();



  return $buffer;

}

function buffer_start() {
  ob_start("callback");
}

function buffer_end() {
  ob_end_flush();
}

add_action('wp_head', 'buffer_start');
add_action('wp_footer', 'buffer_end');

?>