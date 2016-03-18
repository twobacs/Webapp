<?php
function odbcvalues($dbhresult, $format = 'html')
{
   $nr = 1;
   //$row = '';
   while($result = odbc_fetch_object($dbhresult))
   {
      switch($format)
      {
         case 'html' :
            $row .= '<tr><td>' . $nr . '</td>';
            $i = 1;
            foreach($result as $var)
            {
               if(odbc_field_type($dbhresult, $i) == 'binary'or odbc_field_type($dbhresult, $i) == 'varbinary')
                  $row .= '<td>' . bin2hex($var) . '<td>';
               else
                  $row .= '<td>' . $var . '<td>';
               $i++;
            }
            $row .= '</tr>';
            break;
         case 'array':
            $i = 1;
            unset($line);
            foreach($result as $var)
            {

               if(odbc_field_type($dbhresult, $i) == 'binary'or odbc_field_type($dbhresult, $i) == 'varbinary')
                  $line[]=  bin2hex($var) ;
               else
                  $line[]=   $var ;
               $i++;
            }
            $row[]=$line;


            break;
      }
      $nr++;
   }
   return $row;
}
function odbccolumns($dbhresult, $format = 'html')
{
   switch($format)
   {
      case 'html' :
         $titre = '<tr><td>nr</td>';
         for($i = 1; $i <= odbc_num_fields($dbhresult); $i++)
         {
            $titre .= '<td>' . odbc_field_name($dbhresult, $i) . '*' . odbc_field_type($dbhresult, $i) . '<td>';
         }
         $titre .= '</tr>';
         return $titre;
         break;
      case 'array' :
         for($i = 1; $i <= odbc_num_fields($dbhresult); $i++)
         {
            $array[odbc_field_name($dbhresult, $i)] = odbc_field_type($dbhresult, $i);
         }
         return $array;
         break;
   }
}
?>