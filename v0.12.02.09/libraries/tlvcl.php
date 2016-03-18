<?php

/***
* Fontion permettant tout simplment de mettre en forme l'affichage les détails des ventes
***/
function miseEnPageInfoVente($nbResult, $sum)
{
   $view .= '				<table id="infoSell">' . "\n";
   $view .= '					<tr class="rowInfoSell">' . "\n";
   $view .= '						<td class="numberSell"><b>Aantal verkopen : </b>' . $nbResult . '</td>' . "\n";
   $view .= '						<td class="totalSell"><b>Totaal verkopen : </b>' . $sum . '</td>' . "\n";
   $view .= '					</tr>' . "\n";
   $view .= '				</table>' . "\n";
   return $view;
}
function data2table($dataset, $entete = "")
{

   $rowcolor = '#E0E2EB';
   $ph .= "<table border='1'>";
   if($entete <> '')
   {
   }
   else
   {
      $entete .= '<tr>';
      $coln = ibase_num_fields($dataset);
      for($i = 0; $i < $coln; $i++)
      {
         $col_info = ibase_field_info($dataset, $i);

         $entete .= '<td>' . $col_info['name'] . '</td>';
      }

      $entete .= '</tr>';
   }
   $ph .= $entete;

   $compte = 0;
   while($row = ibase_fetch_object($dataset))
   {
      $compte++;
      if($compte == 10)
      {
         $compte = 0;
         $ph .= $entete;
      }
      $i = 0;
      $ph .= "<tr bgcolor='" . $rowcolor . "' >";
      foreach($row as $var)
      {
         $col_info = ibase_field_info($dataset, $i);
         //  $ph.="<td onclick=\"alert('". $col_info['name']."'); \">".$var."</td>";
         $ph .= "<td>" . $var . "</td>";
         //$record[$col_info['name']]=$var;
         //echo $record;
         $i++;
         $record = '';
      }


      $ph .= "</tr>";
      if($rowcolor == '#F0F1EE')
      {
         $rowcolor = '#E0E2EB';
      }
      else
      {
         $rowcolor = '#F0F1EE';
      }
   }
   $ph .= "</table>";
   return $ph;
}

function mysql2table($dataset, $entete = "", $rowcolor1 = "#E0E2EB", $rowcolor2 = "#F0F1EE", $css = false, $groupBydate = false)
{
   $oldVar = '';
   $rowcolor = $rowcolor1;
   if($css)
      $ph .= '				<table id="tableOfSell">' . "\n";
   else
      $ph .= '				<table border="1">' . "\n";

   if(!$groupBydate)
   {
      $ph .= $entete;
   }
   while($row = mysql_fetch_object($dataset))
   {
      if(!$groupBydate)
      {
         if($css)
            $ph .= '				<tr class="rowsOfSell">' . "\n";
         else
            $ph .= '				<tr bgcolor="' . $rowcolor . '">' . "\n";
      }

      foreach($row as $key => $var)
      {
         if($groupBydate)
         {
            if(strcmp('sal_date', $key) == 0)
            {
               $date = split(' ', $var);
               if($oldVar != $date[0])
               {
                  $dateOrdonne = split('-', $date[0]);
                  $ph .= '
					<tr class="rowsDate">
						<td colspan="20">' . $dateOrdonne[2] . '-' . $dateOrdonne[1] . '-' . $dateOrdonne[0] . '</td>
					</tr>
					' . "\n";
                  $ph .= $entete;
                  if($css)
                  {
                     if($i % 2 == 0)
                        $ph .= '					<tr class="rowsOfSell1">' . "\n";
                     else
                        $ph .= '					<tr class="rowsOfSell2">' . "\n";
                     $i++;
                  }
                  else
                     $ph .= '					<tr bgcolor="' . $rowcolor . '">' . "\n";
               }
               else
               {
                  if($css)
                  {
                     if($i % 2 == 0)
                        $ph .= '					<tr class="rowsOfSell1">' . "\n";
                     else
                        $ph .= '					<tr class="rowsOfSell2">' . "\n";
                     $i++;
                  }
                  else
                     $ph .= '					<tr bgcolor="' . $rowcolor . '" >' . "\n";
               }
               $oldVar = $date[0];
               if($css)
                  $ph .= '						<td class="cellOfSell">' . $date[1] . '</td>' . "\n";
               else
                  $ph .= '						<td>' . $date[1] . '</td>' . "\n";
            }
            else
            {
               if($css)
                  $ph .= '						<td class="cellOfSell">' . $var . '</td>' . "\n";
               else
                  $ph .= '						<td>' . $var . '</td>' . "\n";
            }
         }
         else
         {
            if($css)
               $ph .= '						<td class="cellOfSell">' . $var . '</td>' . "\n";
            else
               $ph .= '						<td>' . $var . '</td>' . "\n";
         }
      }


      $ph .= '					</tr>' . "\n";
      if($rowcolor == $rowcolor2)
      {
         $rowcolor = $rowcolor1;
      }
      else
      {
         $rowcolor = $rowcolor2;
      }
   }
   $ph .= '				</table>' . "\n";
   return $ph;
}

function data2htmlselect($dataset, $selectname, $selected, $noselect = '')
{

   $select .= '<SELECT name="' . $selectname . '">';
   if($noselect <> '')
      $select .= '<OPTION  VALUE="-10">Not selected</OPTION>';

   while($row = ibase_fetch_object($dataset))
   {
      $i = 0;
      foreach($row as $var)
      {
         if($i == 0)
            $value = $var;
         if($i == 1)
            $text = $var;
         $i = $i + 1;
      }
      if($selected == $value)
         $select .= '<OPTION selected VALUE="' . $value . '">' . $text . '</OPTION>';
      else
         $select .= '<OPTION  VALUE="' . $value . '">' . $text . '</OPTION>';
   }
   $select .= '</SELECT>';

   return $select;
}
function array2htmltr($array, $trbegin = '<tr>', $trend = '</tr>', $nrcolumn = false)
{
   $html = '';
   $i = 1;
   if(is_array($array))
   foreach($array as $row)
   {
      $html .= $trbegin;
      if($nrcolumn)
         $html .= '<td>' . $i . '</td>';
      foreach($row as $var)
      {
         $html .= '<td>' . $var . '</td>';
      }
      $html .= $trend;
      $i++;
   }
   return $html;

}

?>