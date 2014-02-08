<?php

function rscandir($base='', &$data=array()) {
$array = array_diff(scandir($base), array('.', '..'));

foreach($array as $value) :
  if (is_dir($base.$value)) {
    $data = rscandir($base.$value.'/', $data);

  }
  elseif (is_file($base.$value)) {
   $rest = substr($value, -4);
   if ((!strcmp($rest,'.htm')) || 
   (!strcmp($rest,'.html')) || 
   (!strcmp($rest,'.jpg')) || 
   (!strcmp($rest,'.jpeg')) || 
   (!strcmp($rest,'.gif')) || 
   (!strcmp($rest,'.png')) ||
   (!strcmp($rest,'.ico')) ||
   (!strcmp($rest,'.css')) ||
   (!strcmp($rest,'.txt')) ||
   (!strcmp($rest,'.bmp')) ||
   (!strcmp($rest,'.js')) ) {
         $data[] = $base.$value;
   }
 }

endforeach;
return $data;
}

$mylist=rscandir("/var/www/www.suckup.de/web/");

$srch = array('/var/www/www.suckup.de/web/');
$newval = array('');

$memcache_obj = memcache_connect("127.0.0.1", 11211);

while (list($key, $val) = each($mylist)) {
  $url=str_replace($srch,$newval,$val);
  echo "$key => $val -> ".filesize($val)."\n";
  $value = file_get_contents($val);
  memcache_add($memcache_obj, $url, $value, false, 0);
}
?>



