<?php
// usage $ean = isbn2ean("2-913039-18-9"); // retourne 9782913039148
function isbn2ean($x)
{
   $x = str_replace("-", "", $x);
   $x = str_replace(" ", "", $x);
   if(strlen($x) < 10) $x = $x . "X";
   if(strlen($x) == 10)
   // ISBN10
   {
      $x = substr($x, 0, - 1);
      $x = "978" . $x;
      $code = $x;
      $x = str_split($x);
      $i = 0;
      $i2=0;
      $r=0;
      while($i2 <= 11)
      {
         if($i2 % 2 == 0) $p = "1";
         else $p = "3";
         $r += $x[$i] * $p;
         if($x[$i] != "-") $i2++;
         $i++;
      }
      $q = floor($r / 10);
      $x = 10 - ($r - $q * 10);
      if($x == "10") $x = "0";
      $x = $code . $x;
   }
   return $x;
}

//usage $isbn = ean2isbn("9782913039148"); // retourne 2913039146
function ean2isbn($x)
{
   $x = str_replace("-", "", $x);
   $x = str_replace(" ", "", $x);
   if(strlen($x) == 13)
   {
      $x = substr($x, - 10, 9);
      $k = str_split($x);
      $m = 10;
      foreach($k as $K)
      {
         $K = $K * $m;
         $t += $K;
         $m--;
      }
      $k = 11 - ($t % 11);
      if(strlen($k) > 1) $k = "X";
      $x = $x . $k;
   }
   return $x;
}


?>