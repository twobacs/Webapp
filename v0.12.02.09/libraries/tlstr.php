<?php
function cutstring(&$source, $cutstring)
{
   $pos = strpos($source, $cutstring);
   if($pos === false)
   {
      $result= $source;
      $source='';
   }
   else
   {
      $result = substr($source, 0, $pos + strlen($cutstring));
      $source = substr($source, $pos + strlen($cutstring)+1);
   }
      return $result;
}

function specialcharconvert($chaine,$conv=1)
{
	//http://openweb.eu.org/articles/caracteres_illegaux/ de 128 a 159
	$nChaine = $chaine;

	$secondTabSearch = array(
									chr(128),   // 001 €
									chr(129),   // 002 rien
									chr(130),   // 003 apostrophe anglaise basse
									chr(131),   // 004 florin, forte musical
									chr(132),   // 005 guillemet anglais bas
									chr(133),   // 006 points de suspension
									chr(134),   // 007 obèle, dague, croix (renvoi de notes de bas de page)
									chr(135),   // 008 double croix
									chr(136),   // 009 accent circonflexe
									chr(137),   // 010 pour mille
									chr(138),   // 011 S majuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									chr(139),   // 012 guillemet simple allemand et suisse, parenthèse angulaire ouvrante
									chr(140),   // 013 Ligature o-e majuscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									chr(141),   // 014 vide
									chr(142),   // 015 Z majuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									chr(143),   // 016 vide
									chr(144),   // 017 vide
									chr(145),	// 018 guillemet anglais simple ouvrant(utilisé dans les guillemets doubles)
									chr(146),	// 019 guillemet anglais simple fermant(utilisé dans les guillemets doubles)
									chr(147),	// 020 guillemets anglais doubles ouvrants
									chr(148),	// 021 guillemets anglais doubles fermants
									chr(149),	// 022 boulet, utiliser plutôt des listes à puces
									chr(150),	// 023 tiret demi-cadratin (incise), voir The Trouble With EM 'n EN
									chr(151),	// 024 tiret cadratin (dialogue), voir The Trouble With EM 'n EN
									chr(152),	// 025 tilde
									chr(153),	// 026 marque déposée
									chr(154),	// 027 s minuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									chr(155),	// 028 guillemet simple allemand et suisse, parenthèse angulaire fermante
									chr(156),	// 029 Ligature o-e minscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									chr(157),	// 030 vide
									chr(158),	// 031 z minuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									chr(159)	// 032 Y majuscule avec trema, présent en français dans quelques noms propres (PDF).
									 );

	if ($conv==1) // caractère à signification équivalente
	$secondTabReplace = array(
									"euro",   // 001 €
									" ",   // 002 rien
									" ",   // 003 apostrophe anglaise basse
									"",   // 004 florin, forte musical
									"",   // 005 guillemet anglais bas
									"...",   // 006 points de suspension
									"",   // 007 obèle, dague, croix (renvoi de notes de bas de page)
									"",   // 008 double croix
									"",   // 009 accent circonflexe
									"",   // 010 pour mille
									"S",   // 011 S majuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									"'",   // 012 guillemet simple allemand et suisse, parenthèse angulaire ouvrante
									"OE",   // 013 Ligature o-e majuscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									" ",   // 014 vide
									"Z",   // 015 Z majuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									" ",   // 016 vide
									" ",   // 017 vide
									"'",	// 018 guillemet anglais simple ouvrant(utilisé dans les guillemets doubles)
									"'",	// 019 guillemet anglais simple fermant(utilisé dans les guillemets doubles)
									"\"",	// 020 guillemets anglais doubles ouvrants
									"\"",	// 021 guillemets anglais doubles fermants
									" ",	// 022 boulet, utiliser plutôt des listes à puces
									"-",	// 023 tiret demi-cadratin (incise), voir The Trouble With EM 'n EN
									"-",	// 024 tiret cadratin (dialogue), voir The Trouble With EM 'n EN
									"-",	// 025 tilde
									" ",	// 026 marque déposée
									"s",	// 027 s minuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									"'",	// 028 guillemet simple allemand et suisse, parenthèse angulaire fermante
									"oe",	// 029 Ligature o-e minscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									" ",	// 030 vide
									"z",	// 031 z minuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									"Y"	// 032 Y majuscule avec trema, présent en français dans quelques noms propres (PDF).

										  );
	if ($conv==2) // référence numérique valide (html)
	$secondTabReplace = array(
									"&#8364;",   // 001 €
									" ",   // 002 rien
									"&#8218;",   // 003 apostrophe anglaise basse
									"&#402;",   // 004 florin, forte musical
									"&#8222;",   // 005 guillemet anglais bas
									"&#8230;",   // 006 points de suspension
									"&#8224;",   // 007 obèle, dague, croix (renvoi de notes de bas de page)
									"&#8225;",   // 008 double croix
									"&#710;",   // 009 accent circonflexe
									"&#8240;",   // 010 pour mille
									"&#352;",   // 011 S majuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									"&#8249;",   // 012 guillemet simple allemand et suisse, parenthèse angulaire ouvrante
									"&#338;",   // 013 Ligature o-e majuscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									"",   // 014 vide
									"&#381;",   // 015 Z majuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									" ",   // 016 vide
									" ",   // 017 vide
									"&#8216;",	// 018 guillemet anglais simple ouvrant(utilisé dans les guillemets doubles)
									"&#8217;",	// 019 guillemet anglais simple fermant(utilisé dans les guillemets doubles)
									"&#8220;",	// 020 guillemets anglais doubles ouvrants
									"&#8221;",	// 021 guillemets anglais doubles fermants
									"&#8226;",	// 022 boulet, utiliser plutôt des listes à puces
									"&#8211;",	// 023 tiret demi-cadratin (incise), voir The Trouble With EM 'n EN
									"&#8212;",	// 024 tiret cadratin (dialogue), voir The Trouble With EM 'n EN
									"&#732;",	// 025 tilde
									"&#8482;",	// 026 marque déposée
									"&#353;",	// 027 s minuscule avec caron (accent circonflexe inversé) utilisé en tchèque
									"&#8250;",	// 028 guillemet simple allemand et suisse, parenthèse angulaire fermante
									"&#339;",	// 029 Ligature o-e minscule (absente de la norme ISO-8859-1 pour une raison aberrante…)
									"",	// 030 vide
									"&#382;",	// 031 z minuscule avec caron (accent circonflexe inversé) utilisé en tchèque. Présent dans le Character Encoding  ISO-8859-2
									"&#376;"	// 032 Y majuscule avec trema, présent en français dans quelques noms propres (PDF).

										  );

	$tmp = explode(' ',$nChaine);

	foreach($tmp as $value)
	{
		$tmpWord=$value;
		if(mb_detect_encoding($value) == '') //.'a', 'UTF-8, ISO-8859-1'
		{
			$tmpWord = str_replace($secondTabSearch,$secondTabReplace ,$tmpWord);
			$word[] = $tmpWord;
		}
		elseif(mb_detect_encoding($value) != 'UTF-8') //.'a', 'UTF-8, ISO-8859-1'
		{
			$word[] = $tmpWord;
		}
		else
		{
			$tmpWord = str_replace($secondTabSearch,$secondTabReplace ,$tmpWord);
			$word[] = $tmpWord;
		}
	}
	$nChaine = implode(' ',$word);
	return $nChaine;
}


function utf8encodeifnecessary($value)
{
	//echo mb_detect_encoding($value.'a', 'UTF-8, ISO-8859-1');
	if (mb_detect_encoding($value.'a', 'UTF-8, ISO-8859-1')=='ISO-8859-1')
	{
		//echo "<br /><br />Ce qui suit c est ISO-8859-1 <br > $value <br > ";

		$tmp=utf8_encode(specialcharconvert($value)); //
		//echo '<br><br><b>decode - encode utf </b>: '.$tmp;
		return($tmp);
	}
	else
	{
		//echo '<br /><br />Ce qui suit c est UTF<br >';
		//echo '<br > originutf: '. $value ;//$value;
		return ($value);
	}
}


?>