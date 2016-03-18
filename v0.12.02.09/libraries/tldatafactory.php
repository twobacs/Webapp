<?php
include_once('tlstr.php');
include_once('dbmodel.php');
//*******************************************************************************************
//********************************************************************* Datafactory class
//*******************************************************************************************


class datafactory extends dbmodel
{
   public $mainsubjectschemesdentifier;// nurcode ou csr ou etc ... par dfaut 32 pour nur
   public $imprintispublisher;//Faut il prendre l'imprit comme libell publisher (central boekhouse)
   public $utf8decoding;
   public $buildutf8encode;
   public $longtags = true;
   public $listtext;
   private $tablongtags = array(
                                'ProductIDType' => 'ProductIDType', // 001 $tabtags[1]
                                'IDValue' => 'IDValue', // 002 $tabtags[2]
                                'TitleType' => 'TitleType', // 003 $tabtags[3]
                                'TitleText' => 'TitleText', // 004 $tabtags[4]
                                'Subtitle' => 'Subtitle', // 005 $tabtags[5]
                                'KeyNames' => 'KeyNames', // 006 $tabtags[6]
                                'ContributorRole' => 'ContributorRole', // 007 $tabtags[7]
                                'NamesBeforeKey' => 'NamesBeforeKey', // 008 $tabtags[8]
                                'PrefixToKey' => 'PrefixToKey', // 009 $tabtags[9]
                                'CorporateName' => 'CorporateName', // 010 $tabtags[10]
                                'LanguageRole' => 'LanguageRole', // 011 $tabtags[11]
                                'LanguageCode' => 'LanguageCode', // 012 $tabtags[12]
                                'MainSubjectSchemeIdentifier' => 'MainSubjectSchemeIdentifier', // 013 $tabtags[13]
                                'SubjectCode' => 'SubjectCode', // 014 $tabtags[14]
                                'TitleOfSeries' => 'TitleOfSeries', // 015 $tabtags[15]
                                'NumberWithinSeries' => 'NumberWithinSeries', // 016 $tabtags[16]
                                'Text' => 'Text', // 017 $tabtags[17]
                                'TextTypeCode' => 'TextTypeCode', // 018 $tabtags[18]
                                'TextFormat' => 'TextFormat', // 019 $tabtags[19]
                                'MediaFileTypeCode' => 'MediaFileTypeCode', // 020 $tabtags[20]
                                'MediaFileLink' => 'MediaFileLink', // 021 $tabtags[21]
                                'PublisherName' => 'PublisherName', // 022 $tabtags[22]
                                'ImprintName' => 'ImprintName', // 023 $tabtags[23]
                                'ExpectedShipDate' => 'ExpectedShipDate', // 024 $tabtags[24]
                                'ProductAvailability' => 'ProductAvailability', // 025 $tabtags[25]
                                'Measurement' => 'Measurement', // 026 $tabtags[26]
                                'MeasureTypeCode' => 'MeasureTypeCode', // 027 $tabtags[27]
                                'PriceAmount' => 'PriceAmount', // 028 $tabtags[28]
                                'CurrencyCode' => 'CurrencyCode', // 029 $tabtags[29]
                                'PriceTypeCode' => 'PriceTypeCode', // 030 $tabtags[30]
                                'PriceEffectiveFrom' => 'PriceEffectiveFrom', // 031 $tabtags[31]
                                'PriceEffectiveUntil' => 'PriceEffectiveUntil', // 032 $tabtags[32]
                                'Product' => 'Product', // 033 $tabtags[33]
                                'TextWithDownload' => 'TextWithDownload'//034

                                );
   private $tabshorttags = array(
                                 'ProductIDType' => 'b221', // 001    $tabtags[1]  ProductIDType
                                 'IDValue' => 'b244', // 002    $tabtags[2]  IDValue
                                 'TitleType' => 'b202', // 003    $tabtags[3]  TitleType
                                 'TitleText' => 'b203', // 004    $tabtags[4]  TitleText
                                 'Subtitle' => 'b029', // 005    $tabtags[5]  SubTitle
                                 'KeyNames' => 'b040', // 006    $tabtags[6]  KeyNames
                                 'ContributorRole' => 'b035', // 007    $tabtags[7]  ContributorRole
                                 'NamesBeforeKey' => 'b039', // 008    $tabtags[8]  NamesBeforeKey
                                 'PrefixToKey' => 'b247', // 009    $tabtags[9]  PrefixToKey
                                 'CorporateName' => 'b047', // 010    $tabtags[10] CorporateName
                                 'LanguageRole' => 'b253', // 011    $tabtags[11] LanguageRole
                                 'LanguageCode' => 'b252', // 012    $tabtags[12] LanguageCode
                                 'MainSubjectSchemeIdentifier' => 'b191', // 013    $tabtags[13] MainSubjectSchemeIdentifier
                                 'SubjectCode' => 'b069', // 014    $tabtags[14] SubjectCode
                                 'TitleOfSeries' => 'b018', // 015    $tabtags[15] TitleOfSeries
                                 'NumberWithinSeries' => 'b019', // 016    $tabtags[16] NumberWithinSeries
                                 'Text' => 'd104', // 017    $tabtags[17] Text
                                 'TextTypeCode' => 'd102', // 018    $tabtags[18] TextTypeCode
                                 'TextFormat' => 'd103', // 019    $tabtags[19] TextFormat
                                 'MediaFileTypeCode' => 'f114', // 020    $tabtags[20] MediaFileTypeCode
                                 'MediaFileLink' => 'f117', // 021    $tabtags[21] MediaFileLink
                                 'PublisherName' => 'b081', // 022    $tabtags[22] PublisherName
                                 'ImprintName' => 'b079', // 023    $tabtags[23] ImprintName
                                 'ExpectedShipDate' => 'j142', // 024    $tabtags[24] ExpectedShipDate
                                 'ProductAvailability' => 'j396', // 025    $tabtags[25] ProductAvailability
                                 'Measurement' => 'c094', // 026    $tabtags[26] Measurement
                                 'MeasureTypeCode' => 'c093', // 027    $tabtags[27] MeasureTypeCode
                                 'PriceAmount' => 'j151', // 028 	  $tabtags[28] PriceAmount
                                 'CurrencyCode' => 'j152', // 029 	  $tabtags[29] CurrencyCode
                                 'PriceTypeCode' => 'j148', // 030 	  $tabtags[30] PriceTypeCode
                                 'PriceEffectiveFrom' => 'j161', // 031 	  $tabtags[31] PriceEffectiveFrom
                                 'PriceEffectiveUntil' => 'j162', // 032 	  $tabtags[32] PriceEffectiveUntil
                                 'Product' => 'product', // 033 	  $tabtags[33] Product
                                 'TextWithDownload' => 'f118'//034

                                 );
   function datafactory($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'parking';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
      $this->mainsubjectschemesdentifier = '32';
      $this->imprintispublisher = false;
      // MC 26/02/2010 Pour un bien cette fonction ne doit pas executer de decode ! CAR NOTRE SOURCE DOIT ETRE EN UTF8 ET NOUS DEVONS AVOIR DE L UTF8 DANS NOTRE BASE DE DONNEES
      // donc par dfaut  $this->utf8decoding doit etre gale  false ! et pas  true
      //$this->utf8decoding = true;
      $this->utf8decoding = false;
      // meme chose pour le encode en sortie si on met a true ca veut dire que la source est en iso et qu'on veut la transformer en utf
      $this->buildutf8encode = false;
   }

   function __destruct()
   {
      if(isset($this->contributors))
      {
         unset($this->contributors);
      }
      if(isset($this->prices))
      {
         unset($this->prices);
      }
      if(isset($this->othertext))
      {
         unset($this->othertext);
      }
      if(isset($this->publication))
      {
         unset($this->publication);
      }
      if(isset($this->todoupdate))
         unset($this->todoupdate);
   }

   // MC 26/02/2010 Pour un bien cette fonction ne doit pas executer de decode ! CAR NOTRE SOURCE DOIT ETRE EN UTF8 ET NOUS DEVONS AVOIR DE L UTF8 DANS NOTRE BASE DE DONNEES
   // donc par dfaut  $this->utf8decoding doit etre gale  false ! et pas  true
   function ifutf8decodingdecode($value)
   {
      if($this->utf8decoding)
         return(utf8_decode($value));
      else return($value);
   }

   function utf8_encodedata($value)
   {
      if($this->buildutf8encode)
      {
         return(utf8encodeifnecessary($value));
      }
      else return($value);
   }

   function loadbook($ean = null , $dbprovider = null , $titelid = null , $domaincode = '')
   {
      if(isset($ean))
      {
         $mode = 'ean';
         $this->dbprovider = $dbprovider;
      }
      else if(isset($titelid))
      {
         $mode = 'id';
      }
      else
      {
         $mode = 'none';

      }
      if($domaincode == '')
      {
         $domainjoin = '';
      }
      else
      {
         $domainjoin = 'left join domain_cat d on d.ean=a.ean and d.domain_code=\'' . $domaincode . '\'';
      }

      $sql = 'select a.*,b.bindwijzeweb as bindweb,b.bind_onix,c.omschrijving as leeftijd,e.b_onix from parking a
				left join bindwijze b on b.code=a.bindwijzecode
				left join leeftijdcategorie c on c.code=a.leeftijdcode
				' . $domainjoin . ' left join beschikbaar e on e.code=a.BESCHIKBAARHEIDCODE';

      switch($mode)
      {

         case 'ean':
            $sql .= ' where a.ean=\'' . $ean . '\' and a.dbproviderid=' . $dbprovider;
            break;
         case 'id' :
            $sql .= ' where a.titelid=\'' . $titelid . '\'';
            break;
      }
      $this->dbdf->requete($sql, 'parking');
      $this->dbdf->row2class($this->dbdf->resultat('parking'), $this, true, true, 'parking', 'parking');
   }

   function loadfullbook($ean = null , $dbprovider = null , $titelid = null)
   {
      $this->loadbook($ean, $dbprovider, $titelid);

      if($this->f_titelid == '')
         return false;

      if(isset($this->contributors))
      {
         $this->contributors->loadcontributors(null , null , $this->f_titelid);
      }
      else
      {
         $this->contributors = new contributors($this->dbdf);
         $this->contributors->loadcontributors(null , null , $this->f_titelid);
      }

      if(isset($this->prices))
      {
         $this->prices->loadprices(null , null , $this->f_titelid);
      }
      else
      {
         $this->prices = new prices($this->dbdf);
         $this->prices->loadprices(null , null , $this->f_titelid);
      }

      if(isset($this->othertext))
      {
         $this->othertext->loadtext(null , null , $this->f_titelid);
      }
      else
      {
         $this->othertext = new othertext($this->dbdf);
         $this->othertext->loadtext(null , null , $this->f_titelid);
      }

      if(isset($this->publication))
      {
         $this->publication->loadpub($this->f_ean, null , null);
      }
      else
      {
         $this->publication = new publication($this->dbdf);
         $this->publication->loadpub($this->f_ean, null , null);
      }
   }
   function initfullbook()
   {
      if(!isset($this->contributors))
      {
         $this->contributors = new contributors($this->dbdf);
      }

      if(!isset($this->prices))
      {
         $this->prices = new prices($this->dbdf);
      }
      if(!isset($this->othertext))
      {
         $this->othertext = new othertext($this->dbdf);
      }

   }

   function initprices()
   {
      unset($this->prices);
      $this->prices = new prices($this->dbdf);
   }

   function deletebook($titelid)
   {
      $sql = "delete from parking a where a.titelid='" . $titelid . "'";
      $this->dbdf->requete($sql, 'deletebook');
   }
   function savebook()
   {
      // MC 11/03/2010 avant de faire la requete... test des champs
      // pour l'instant juste du champs aantpag pour etre sur qu'il fait pas plus de 4 caractres
      // si c'est le cas alors on remplace la valeur par vide.
      if(isset($this->f_aantpag))
         if(strlen($this->f_aantpag) > 4)
            $this->f_aantpag = '';

      $sql = 'select titelid from parking where ean=\'' . $this->f_ean . '\' and dbproviderid=' . $this->f_dbproviderid;


      $this->dbdf->requete($sql, 'check');
      $row = $this->dbdf->resultat('check');
      if(!$row == false)
      {
         $this->f_titelid = $row['TITELID'];
         $sql = $this->buildupdatesql();
         $sql .= ' where titelid=' . $this->dbdf->preparevalue($this->i_titelid, $this->f_titelid);
         $this->dbdf->requete($sql, 'update');
      }
      else
      {
         if(trim($this->f_titelid) == '')
         {
            $this->dbdf->requete('SELECT gen_id(GEN_TITELID,1) FROM rdb$Database', 'id');
            $rowid = $this->dbdf->resultat('id');
            $this->f_titelid = $rowid['GEN_ID'];
         }
         $sql = $this->buildinsertsql();
         $this->dbdf->requete($sql, 'insert');

      }
   }
   function deletefullbook($titelid)
   {
      $this->deletebook($titelid);
      $this->contributors->deleteallcontributors($titelid);
      $this->prices->deleteallprices($titelid);
      $this->othertext->deleteallothertext($titelid);
   }
   function savefullbook()
   {

      $this->savebook();
      $this->contributors->settitelid($this->f_titelid);
      $this->contributors->savecontributors();

      $this->prices->settitelid($this->f_titelid);
      $this->prices->saveprices();
      // MC 03/03/2010
      $this->todoupdate = new todoupdate($this->dbdf);
      $this->todoupdate->loadtodoupdateprices($this->f_titelid, $this->prices);
      $this->todoupdate->savetodoupdate($this->f_titelid);
      $this->othertext->settitelid($this->f_titelid);
      $this->othertext->saveothertext();

   }

   function buildonix($OnixMessage = false, $customxml = '', $relatedprod = false)
   {
      $source = '<Product>'.$customxml.'</Product>';
      $onix = simplexml_load_string($source);
      
      $onix->RecordReference = $this->f_ean;
      $onix->NotifycationType = '03';
      //   $onix->recordsourcetype='00';  optional
      $onix->ProductIdentifier->ProductIDType = '03';
      $onix->ProductIdentifier->IDValue = $this->f_ean;
      $onix->ProductForm = $this->j_bind_onix;
      // if($this->j_bind_onix == 'DG')
      if($this->f_epubtype <> '')
         $onix->EpubType = $this->f_epubtype;
      if($this->f_pfdetail <> '')
         $onix->ProductFormDetail = $this->f_pfdetail;

      if($this->f_reekstitel <> '')
      {
         $onix->Series->TitleOfSeries = $this->utf8_encodedata($this->f_reekstitel);
         if($this->f_reeksnr <> '')
            $onix->Series->NumberWithinSeries = $this->f_reeksnr;
      }
      $onix->Title->TitleType = '01';
      //echo 'aaa ' $onix->Title->TitleText.' ici ';
      $onix->Title->TitleText = $this->utf8_encodedata($this->f_titel);
      //echo $onix->Title->TitleText.' oco';
      if(trim($this->f_ondertitel) != '')
         $onix->Title->Subtitle = $this->utf8_encodedata($this->f_ondertitel);

      // contributors
      $i = 0;
      if(isset($this->contributors->listcontributors))
      {
         foreach($this->contributors->listcontributors  as $row)
         {
            $this->contributors->focuscontributor($i);
            $onix->Contributor[$i]->ContributorRole = trim(strtoupper($this->contributors->j_onixcode));

            if($this->contributors->f_persoonvoornaam <> '')
               $onix->Contributor[$i]->NamesBeforeKey = trim($this->utf8_encodedata($this->contributors->f_persoonvoornaam));

            if($this->contributors->f_prefixtokey <> '')
               $onix->Contributor[$i]->PrefixToKey = trim($this->contributors->f_prefixtokey);

            if($this->contributors->f_persoonnaam <> '')
               $onix->Contributor[$i]->KeyNames = trim($this->utf8_encodedata($this->contributors->f_persoonnaam));

            if($this->contributors->f_corporatename <> '')
               $onix->Contributor[$i]->CorporateName = trim($this->utf8_encodedata($this->contributors->f_corporatename));

            if($this->contributors->f_unnamedpersons <> '')
               $onix->Contributor[$i]->UnnamedPersons = trim($this->utf8_encodedata($this->contributors->f_unnamedpersons));

            $personname = $this->utf8_encodedata($this->contributors->f_persoonvoornaam . ' ' . $this->contributors->f_prefixtokey . ' ' . $this->contributors->f_persoonnaam);
            if($personname <> '')
               $onix->Contributor[$i]->PersonName = trim($personname);

            $i++;
         }
      }
      if($this->f_editie != '' && is_numeric($this->f_editie))
         $onix->EditionNumber = $this->f_editie;
      if($this->f_taalcode <> '')
      {
         $onixcode = str_replace('ned', 'dut', $this->f_taalcode);
         $onixcode = str_replace('NL', 'dut', $onixcode);
         $onix->Language->LanguageRole = '01';
         $onix->Language->LanguageCode = $onixcode;
      }
      if($this->f_aantpag != '' && is_numeric($this->f_aantpag))
         $onix->PagesArabic = $this->f_aantpag;

      if($this->f_nurcode != '')
      {
         //$onix->MainSubject->MainSubjectSchemeIdentifier = '32';
         $onix->MainSubject->MainSubjectSchemeIdentifier = $this->mainsubjectschemesdentifier;
         $onix->MainSubject->SubjectCode = $this->f_nurcode;
      }
      $i = 0;
      $j = 0;
      // print_r($this->othertext->listtext);
      //if(isset($this->listtext))
      if(isset($this->othertext->listtext))
      {
         foreach($this->othertext->listtext  as $row)
         {
            $this->othertext->focustext($i);
            if(trim($this->othertext->f_text) != '')
            {
               $onix->OtherText[$i]->TextTypeCode = str_pad($this->othertext->j_onyxcode, 2, '0', STR_PAD_LEFT);
               $onix->OtherText[$i]->TextFormat = $this->othertext->f_formatcode;
               $onix->OtherText[$i]->Text = $this->utf8_encodedata($this->othertext->f_text);
               //	echo $onix->OtherText[$i]->Text ;
               //	$onix->OtherText[$i]->Text = $this->othertext->f_text;
               //	echo $onix->OtherText[$i]->Text;
               $j++;
            }
            $i++;
         }
      }
      $levelmedia = 0;
      if($this->f_thumblink <> '')
      {
         $levelmedia++;
         $onix->MediaFile->MediaFileTypeCode = '04';
         switch(substr($this->f_thumblink, - 3))
         {
            case 'jpg':
               $mfc = '03';
               break;
            case 'gif':
               $mfc = '02';
               break;
            default:
               $mfc = '03';

         }
         $onix->MediaFile->MediaFileFormatCode = $mfc;
         $onix->MediaFile->MediaFileLinkTypeCode = '01';
         $onix->MediaFile->MediaFileLink = $this->f_thumblink;
      }
      if(isset($this->publication))
         $rowpub = $this->publication->getpub(90);
      else
         $rowpub = false;
      if($rowpub <> false)
      {
         $onix->MediaFile[$levelmedia]->MediaFileTypeCode = '51';
         $onix->MediaFile[$levelmedia]->MediaFileLinkTypeCode = '01';
         $onix->MediaFile[$levelmedia]->MediaFileLink = $rowpub['PUB_TXT'];
      }
      $onix->Publisher->PublishingRole = '01';
      $onix->Publisher->PublisherName = $this->utf8_encodedata($this->f_uitgever);
      //echo $this->f_eersteverschijningdatum_d;
      $onix->PublicationDate = str_replace('-', '', substr($this->f_eersteverschijningdatum_d, 0, 10));

      $i = 0;
      if(($this->f_formaat_lengte <> '') && ($this->f_formaat_lengte <> '0000'))
      {
         $onix->Measure[$i]->MeasureTypeCode = '01';
         $onix->Measure[$i]->Measurement = $this->f_formaat_lengte;
         $onix->Measure[$i]->MeasureUnitCode = 'mm';
         $i++;
      }
      if(($this->f_formaat_breedte <> '') && ($this->f_formaat_breedte <> '0000'))
      {
         $onix->Measure[$i]->MeasureTypeCode = '02';
         $onix->Measure[$i]->Measurement = $this->f_formaat_breedte;
         $onix->Measure[$i]->MeasureUnitCode = 'mm';
         $i++;
      }
      if(($this->f_formaat_hoogte <> '') && ($this->f_formaat_hoogte <> '0000'))
      {
         $onix->Measure[$i]->MeasureTypeCode = '03';
         $onix->Measure[$i]->Measurement = $this->f_formaat_hoogte;
         $onix->Measure[$i]->MeasureUnitCode = 'mm';
         $i++;
      }
      if(($this->f_gewicht <> '') && ($this->f_gewicht <> '0'))
      {
         $onix->Measure[$i]->MeasureTypeCode = '08';
         $onix->Measure[$i]->Measurement = $this->f_gewicht;
         $onix->Measure[$i]->MeasureUnitCode = 'gr';
         $i++;
      }
      
      if($relatedprod === true && $this->f_ean <> '') {
          if($this->j_bind_onix == 'DG') {
                $relsql = "select ebk.book from ebook ebk ";
                $relsql .= "where ebk.ebook = '".$this->f_ean."'";
                $this->dbdf->requete($relsql, 'RelatedProduct');
                $result = $this->dbdf->resultat('RelatedProduct');
                if($result) {
                    if($result['BOOK'] != '') {
                        $onix->RelatedProduct->RelationCode = '13';
                        $onix->RelatedProduct->ProductIdentifier->ProductIDType = '03';
                        $onix->RelatedProduct->ProductIdentifier->IDValue = $result['BOOK'];
                    }
                }
          }
          else {
              $relsql = "select ebk.ebook from ebook ebk ";
                $relsql .= "where ebk.book = '".$this->f_ean."'";
                $this->dbdf->requete($relsql, 'RelatedProduct');
                $result = $this->dbdf->resultat('RelatedProduct');
                if($result) {
                    if($result['EBOOK'] != '') {
                        $onix->RelatedProduct->RelationCode = '27';
                        $onix->RelatedProduct->ProductIdentifier->ProductIDType = '03';
                        $onix->RelatedProduct->ProductIdentifier->IDValue = $result['EBOOK'];
                    }
                }
          }
      }

      $i = 0;
      //echo $onix->asXML();
      if(isset($this->prices->listprices))
      {
         if(count($this->prices->listprices) == 0)
         {
            $onix->SupplyDetail->Price[$i]->PriceTypeCode = '02';
            $onix->SupplyDetail->Price[$i]->PriceAmount = str_replace(',', '.', $this->f_prijs);
            $onix->SupplyDetail->Price[$i]->CurrencyCode = 'EUR';
         }
         else
            foreach($this->prices->listprices  as $row)
            {
               //print_r($row);
               $this->prices->focusprice($i);
               $onix->SupplyDetail->Price[$i]->PriceTypeCode = $this->prices->f_prijstype;
               $onix->SupplyDetail->Price[$i]->PriceAmount = $this->prices->f_bedrag;
               $onix->SupplyDetail->Price[$i]->CurrencyCode = $this->prices->f_valutacode;
               if(substr($this->prices->f_datumgeldigvanaf, 0, 4) <> '1899'and $this->prices->f_datumgeldigvanaf <> '')
                  $onix->SupplyDetail->Price[$i]->PriceEffectiveFrom = str_replace('-', '', substr($this->prices->f_datumgeldigvanaf, 0, 10));
               if(substr($this->prices->f_datumgeldigtot, 0, 4) <> '1899'and $this->prices->f_datumgeldigtot <> '')
                  $onix->SupplyDetail->Price[$i]->PriceEffectiveUntil = str_replace('-', '', substr($this->prices->f_datumgeldigtot, 0, 10));// $this->prices->f_datumgeldigtot;
               //         $onix->SupplyDetail[$i]->TextFormat = $this->othertext->f_formatcode;
               //         $onix->SupplyDetail[$i]->Text = $this->othertext->f_text;

               $i++;
            }
      }

      $onix->SupplyDetail->ProductAvailability = $this->j_b_onix;
      if($this->f_verschijningsdatum <> '')
         $onix->SupplyDetail->ExpectedShipDate = substr(str_replace('-', '', substr($this->f_verschijningdatum_d, 0, 10)), 0, 6);
      //str_replace('-', '', substr($this->f_eersteverschijningdatum_d, 0, 10));

      if($OnixMessage === true)
      {
         $onixxml = '<?xml version="1.0" encoding="UTF-8"?><ONIXMessage xmlns="http://www.editeur.org/onix/2.1/reference">';
         $resxml = $onix->asXML();
         if($resxml === false)
            echo $this->f_ean;
         $onixxml .= $resxml;
         $onixxml .= '</ONIXMessage>';
      }
      else
      {
         $resxml = $onix->asXML();
         if($resxml === false)
            echo $this->f_ean;
         $onixxml .= $resxml;
         //$onixxml = $onix->asXML();
      }

      return $onixxml;
      //var_dump ($onix);

   }

   function buildlightonix()
   {

      $source = '<product xmlns="http://www.editeur.org/onix/2.1/reference"></product> ';
      $onix = simplexml_load_string($source);
      $onix->RecordReference = $this->f_ean;
      $onix->NotifycationType = '03';
      //   $onix->recordsourcetype='00';  optional
      $onix->ProductIdentifier->ProductIDType = '03';
      $onix->ProductIdentifier->IDValue = $this->f_ean;
      $onix->ProductForm = $this->j_bind_onix;
      if($this->j_bind_onix == 'DG')
         $onix->EpubType = '029';


      return $onix->asXML();
      //var_dump ($onix);

   }

   function clearprices()
   {
      $this->prices = new prices($this->dbdf);
   }

   /// NE PLUS MODIFIER CETTE FONCTION !MC 24/03/2010
   function oldloadonixfile($filename)
   {

      $onixfile = simplexml_load_file($filename);
      if($onixfile)
      {
         $result = true;
      }
      else
      {
         //echo 'mert2';
         $result = false;
         return $result;
      }

      $children = $onixfile->Product->children();

      $i = 0;
      foreach($children as $elem)
      {
         //  var_dump($elem);
         //echo $elem->getname() . '<br>';
         switch($elem->getname())
         {
            case 'ProductIdentifier':

               if(((string)$elem->ProductIDType == 3)or((string)$elem->ProductIDType == 15))
                  $this->f_ean = (string)$elem->IDValue;
               break;
            case 'Title' :
               if((string)$elem->TitleType == 1)
               {
                  $this->f_titel = $this->ifutf8decodingdecode((string)$elem->TitleText);
                  $this->f_ondertitel = $this->ifutf8decodingdecode((string)$elem->Subtitle);
               }
               break;
            case 'ProductForm':
               if($this->f_bindwijzecode == '')
                  $this->f_bindwijzecode = (string)$elem;
               //var_dump($elem);
               break;

            case 'Contributor':
               $this->contributors->clear();
               $this->contributors->f_persoonnaam = $this->ifutf8decodingdecode((string)$elem->KeyNames);
               $this->contributors->f_persoonrolcode = (string)$elem->ContributorRole;
               $this->contributors->f_persoonvoornaam = $this->ifutf8decodingdecode((string)$elem->NamesBeforeKey);
               $this->contributors->f_prefixtokey = (string)$elem->PrefixToKey;
               $this->contributors->f_corporatename = $this->ifutf8decodingdecode((string)$elem->CorporateName);
               $this->contributors->addcontributor();
               //var_dump($this->contributors);
               break;
            case 'Language':

               if((string)$elem->LanguageRole == 1)
                  $this->f_taalcode = (string)$elem->LanguageCode;
               break;
            case 'MainSubject':

               if((string)$elem->MainSubjectSchemeIdentifier == $this->mainsubjectschemesdentifier)
               {
                  $this->f_nurcode = (string)$elem->SubjectCode;
                  //echo 'prout'.$elem->SubjectCode;
               }
               break;
            case 'Series' :
               if((string)$elem->TitleOfSeries <> '')
                  $this->f_reekstitel = $this->ifutf8decodingdecode((string)$elem->TitleOfSeries);
               if((string)$elem->Title->TitleText <> '')
                  $this->f_reekstitel = $this->ifutf8decodingdecode((string)$elem->Title->TitleText);
               if((string)$elem->NumberWithinSeries <> '')
                  $this->f_reeksnr = (string)$elem->NumberWithinSeries;

               break;
            case 'OtherText':
               //echo (string)$elem->Text.'<br /><br />';
               //echo xmlEntities2(htmlentities((string)$elem->Text,ENT_NOQUOTES,'UTF-8')).'<br /><br />';
               //echo (string)$elem->Text.'<br />';
               //echo $this->ifutf8decodingdecode((string)$elem->Text).'<br />';
               $this->othertext->clear();
               // MC 05/03/2010 si on veut de l'entit html dans la base faudra faire du htmlentites d'un htmlentitydecode !
               // sinon on risque de convertir des trucs dj convertis... ce qui va nous faire du &amp;eacute;
               // mais bon je le fais pas ...
               //echo  htmlentities (html_entity_decode((string)$elem->Text));
               $this->othertext->f_text = $this->ifutf8decodingdecode((string)$elem->Text);//XMLEntities2( xmlEntities2(htmlentities((string)$elem->Text,ENT_NOQUOTES,'UTF-8')));//(
               $this->othertext->f_typetext = (string)$elem->TextTypeCode;
               $this->othertext->f_formatcode = (string)$elem->TextFormat;
               $this->othertext->addtext();
               //echo $this->othertext->f_text;
               break;
            case 'MediaFile':
               if((string)$elem->MediaFileTypeCode == '4')
                  $this->f_thumblink = (string)$elem->MediaFileLink;
               break;
            case 'Publisher':
               if($this->imprintispublisher == false)
               {
                  if(trim((string)$elem->PublisherName) <> '')
                     $this->f_uitgever = $this->ifutf8decodingdecode((string)$elem->PublisherName);
               }
               else
               {
                  if(trim((string)$elem->PublisherName) <> '')
                     $this->f_orguitgever = $this->ifutf8decodingdecode((string)$elem->PublisherName);
               }
               //  $this->f_orguitgever = $this->ifutf8decodingdecode((string)$elem->PublisherName);
               // echo 'test' . $this->f_orguitgever;
               break;
            case 'Imprint' :
               if($this->imprintispublisher)
                  $this->f_uitgever = (string)$elem->ImprintName;
               else
                  $this->f_orguitgever = (string)$elem->ImprintName;

               break;
            case 'PublicationDate':
               //echo (string)$elem;
               $this->f_eersteverschijningdatum_d = substr((string)$elem, 0, 4);

               if((strlen((string)$elem) == 8)or(strlen((string)$elem) == 6))
                  $this->f_eersteverschijningdatum_d = substr((string)$elem, 4, 2) . '.' . $this->f_eersteverschijningdatum_d;
               else
                  $this->f_eersteverschijningdatum_d = '01.' . $this->f_eersteverschijningdatum_d;
               if(strlen((string)$elem) == 8)
                  $this->f_eersteverschijningdatum_d = substr((string)$elem, 6, 2) . '.' . $this->f_eersteverschijningdatum_d;
               else
                  $this->f_eersteverschijningdatum_d = '01.' . $this->f_eersteverschijningdatum_d;
               break;
            case 'SupplyDetail':

               //********************************************shipdate
               if((string)$elem->ExpectedShipDate <> '')
               {
                  $size = strlen((string)$elem->ExpectedShipDate);
                  if(($size == 4)or($size == 6)or($size == 8))
                  {
                     $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 0, 4);
                     $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 0, 4);
                     if(($size == 8)or($size == 6))
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 4, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 4, 2) . '-' . $this->f_verschijningsdatum;
                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                     if($size == 8)
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 6, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 6, 2) . '-' . $this->f_verschijningsdatum;

                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                  }
                  //$this->f_verschijningdatum_d =
               }
               //********************************************* product availability
               if((string)$elem->ProductAvailability <> '')
                  $this->f_beschikbaarheidcode = (string)$elem->ProductAvailability;
               foreach($elem->children() as $price)
               {
                  if($price->getname() == 'Price')
                  {
                     $this->prices->clear();
                     $this->prices->f_bedrag = (string)$price->PriceAmount;
                     $this->prices->f_valutacode = (string)$price->CurrencyCode;
                     $this->prices->f_prijstype = (string)$price->PriceTypeCode;
                     if((string)$price->PriceEffectiveFrom <> '')
                        $this->prices->f_datumgeldigvanaf = substr((string)$price->PriceEffectiveFrom, 0, 4) . '-' .
                        substr((string)$price->PriceEffectiveFrom, 4, 2) . '-' . substr((string)$price->PriceEffectiveFrom, 6, 2);
                     if((string)$price->PriceEffectiveUntil <> '')
                        $this->prices->f_datumgeldigtot = substr((string)$price->PriceEffectiveUntil, 0, 4) . '-' .
                        substr((string)$price->PriceEffectiveUntil, 4, 2) . '-' . substr((string)$price->PriceEffectiveUntil, 6, 2);
                     $this->prices->addprice();
                  }

               }

               break;
            case 'Measure':
               $this->f_formaat = (string)$elem->Measurement;
               if((string)$elem->MeasureTypeCode == 1)
                  $this->f_formaat_lengte = (string)$elem->Measurement;
               if((string)$elem->MeasureTypeCode == 2)
                  $this->f_formaat_breedte = (string)$elem->Measurement;
               if((string)$elem->MeasureTypeCode == 3)
                  $this->f_formaat_hoogte = (string)$elem->Measurement;
               if((string)$elem->MeasureTypeCode == 8)
                  $this->f_gewicht = (string)$elem->Measurement;

               break;
            case 'PagesArabic':
               $this->f_aantpag = (string)$elem;
               break;
            case 'EditionNumber':
               $this->f_editie = (string)$elem;
               break;
            case 'EpubType':
               $this->f_epubtype = (string)$elem;//(string)$elem;
               break;
            case 'ProductFormDetail':
               $this->f_pfdetail = (string)$elem;
               break;

         }
      }
      return $result;
   }


   function loadonixfile($filename)
   {

      $onixfile = simplexml_load_file($filename);
      if($onixfile)
      {
         $result = true;
      }
      else
      {
         $result = false;
         return $result;
      }

      if($this->longtags == true)
         $this->parsetags($onixfile, $this->tablongtags);
      else $this->parsetags($onixfile, $this->tabshorttags);

      return $result;
   }


   function parsetags($onixfile, $tabtags)
   {
      $children = $onixfile->$tabtags['Product']->children();
      $i = 0;
      foreach($children as $elem)
      {
         switch($elem->getname())
         {
            case 'productidentifier':
            case 'ProductIdentifier':
               if(((string)$elem->$tabtags['ProductIDType'] == 3)or((string)$elem->$tabtags['ProductIDType'] == 15))
                  $this->f_ean = (string)$elem->$tabtags['IDValue'];

               break;
            case 'title' :
            case 'Title' :
               if((string)$elem->$tabtags['TitleType'] == 1)
               {
                  $this->f_titel = $this->ifutf8decodingdecode((string)$elem->$tabtags['TitleText']);
                  $this->f_ondertitel = $this->ifutf8decodingdecode((string)$elem->$tabtags['Subtitle']);
               }
               break;
            case 'b012':
            case 'productform':
            case 'ProductForm':
                         
               if(!isset($this->f_bindwijzecode) || $this->f_bindwijzecode == '')
                  $this->f_bindwijzecode = (string)$elem;
               break;

            case 'contributor':
            case 'Contributor':
               $this->contributors->clear();
               $this->contributors->f_persoonnaam = $this->ifutf8decodingdecode((string)$elem->$tabtags['KeyNames']);
               $this->contributors->f_persoonrolcode = (string)$elem->$tabtags['ContributorRole'];
               $this->contributors->f_persoonvoornaam = $this->ifutf8decodingdecode((string)$elem->$tabtags['NamesBeforeKey']);
               $this->contributors->f_prefixtokey = (string)$elem->$tabtags['PrefixToKey'];
               $this->contributors->f_corporatename = $this->ifutf8decodingdecode((string)$elem->$tabtags['CorporateName']);
               $this->contributors->addcontributor();
               break;
            case 'language':
            case 'Language':

               if((string)$elem->$tabtags['LanguageRole'] == 1)
                  $this->f_taalcode = (string)$elem->$tabtags['LanguageCode'];
               break;
            case 'mainsubject':
            case 'MainSubject':
               if((string)$elem->$tabtags['MainSubjectSchemeIdentifier'] == $this->mainsubjectschemesdentifier)
               {
                  $this->f_nurcode = (string)$elem->$tabtags['SubjectCode'];
               }
               break;
            case 'series' :
            case 'Series' :
               if((string)$elem->$tabtags['TitleOfSeries'] <> '')
                  $this->f_reekstitel = $this->ifutf8decodingdecode((string)$elem->$tabtags['TitleOfSeries']);
               if((string)$elem->Title->$tabtags['TitleText'] <> '')
                  $this->f_reekstitel = $this->ifutf8decodingdecode((string)$elem->Title->$tabtags['TitleText']);
               if((string)$elem->$tabtags['NumberWithinSeries'] <> '')
                  $this->f_reeksnr = (string)$elem->$tabtags['NumberWithinSeries'];

               break;
            case 'othertext':
            case 'OtherText':
               $this->othertext->clear();
               // MC 05/03/2010 si on veut de l'entit html dans la base faudra faire du htmlentites d'un htmlentitydecode !
               // sinon on risque de convertir des trucs dj convertis... ce qui va nous faire du &amp;eacute;
               // mais bon je le fais pas ...
               //echo  htmlentities (html_entity_decode((string)$elem->Text));
               $this->othertext->f_text = $this->ifutf8decodingdecode((string)$elem->$tabtags['Text']);
               $this->othertext->f_typetext = (string)$elem->$tabtags['TextTypeCode'];
               $this->othertext->f_formatcode = (string)$elem->$tabtags['TextFormat'];
               $this->othertext->addtext();
               break;
            case 'mediafile':
            case 'MediaFile':
               if((string)$elem->$tabtags['MediaFileTypeCode'] == '4')
                  $this->f_thumblink = (string)$elem->$tabtags['MediaFileLink'];
               // spcial wpg !
               else if((((string)$elem->$tabtags['MediaFileTypeCode'] == '1')
               || ((string)$elem->$tabtags['MediaFileTypeCode'] == '01'))
               && (trim((string)$elem->$tabtags['TextWithDownload']) == '(import):Omslag voor internet. Definitief'))
                  $this->f_thumblink = (string)$elem->$tabtags['MediaFileLink'];
               break;
            case 'publisher':
            case 'Publisher':
               if($this->imprintispublisher == false)
               {
                  if(trim((string)$elem->$tabtags['PublisherName']) <> '')
                     $this->f_uitgever = $this->ifutf8decodingdecode((string)$elem->$tabtags['PublisherName']);
               }
               else
               {
                  if(trim((string)$elem->$tabtags['PublisherName']) <> '')
                     $this->f_orguitgever = $this->ifutf8decodingdecode((string)$elem->$tabtags['PublisherName']);
               }
               break;
            case 'imprint' :
            case 'Imprint' :
               if($this->imprintispublisher)
                  $this->f_uitgever = (string)$elem->$tabtags['ImprintName'];
               else
                  $this->f_orguitgever = (string)$elem->$tabtags['ImprintName'];

               break;
            case 'b003':
            case 'publicationdate':
            case 'PublicationDate':
               $this->f_eersteverschijningdatum_d = substr((string)$elem, 0, 4);

               if((strlen((string)$elem) == 8)or(strlen((string)$elem) == 6))
                  $this->f_eersteverschijningdatum_d = substr((string)$elem, 4, 2) . '.' . $this->f_eersteverschijningdatum_d;
               else
                  $this->f_eersteverschijningdatum_d = '01.' . $this->f_eersteverschijningdatum_d;
               if(strlen((string)$elem) == 8)
                  $this->f_eersteverschijningdatum_d = substr((string)$elem, 6, 2) . '.' . $this->f_eersteverschijningdatum_d;
               else
                  $this->f_eersteverschijningdatum_d = '01.' . $this->f_eersteverschijningdatum_d;
               break;
            case 'supplydetail':
            case 'SupplyDetail':

               //********************************************shipdate
               if((string)$elem->$tabtags['ExpectedShipDate'] <> '')
               {
                  $size = strlen((string)$elem->$tabtags['ExpectedShipDate']);
                  if(($size == 4)or($size == 6)or($size == 8))
                  {
                     $this->f_verschijningdatum_d = substr((string)$elem->$tabtags['ExpectedShipDate'], 0, 4);
                     $this->f_verschijningsdatum = substr((string)$elem->$tabtags['ExpectedShipDate'], 0, 4);
                     if(($size == 8)or($size == 6))
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->$tabtags['ExpectedShipDate'], 4, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->$tabtags['ExpectedShipDate'], 4, 2) . '-' . $this->f_verschijningsdatum;
                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                     if($size == 8)
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->$tabtags['ExpectedShipDate'], 6, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->$tabtags['ExpectedShipDate'], 6, 2) . '-' . $this->f_verschijningsdatum;

                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                  }
                  //$this->f_verschijningdatum_d =
               }
               //********************************************* product availability
               if((string)$elem->$tabtags['ProductAvailability'] <> '')
                  $this->f_beschikbaarheidcode = (string)$elem->$tabtags['ProductAvailability'];
               foreach($elem->children() as $price)
               {
                  if(($price->getname() == 'Price') || ($price->getname() == 'price'))
                  {
                     $this->prices->clear();
                     $this->prices->f_bedrag = (string)$price->$tabtags['PriceAmount'];//PriceAmount;
                     $this->prices->f_valutacode = (string)$price->$tabtags['CurrencyCode'];//CurrencyCode;
                     $this->prices->f_prijstype = (string)$price->$tabtags['PriceTypeCode'];//PriceTypeCode;
                     if((string)$price->$tabtags['PriceEffectiveFrom'] <> '')//PriceEffectiveFrom
                        $this->prices->f_datumgeldigvanaf = substr((string)$price->$tabtags['PriceEffectiveFrom'], 0, 4) . '-' .
                        substr((string)$price->$tabtags['PriceEffectiveFrom'], 4, 2) . '-' . substr((string)$price->$tabtags['PriceEffectiveFrom'], 6, 2);
                     if((string)$price->$tabtags['PriceEffectiveUntil'] <> '')//PriceEffectiveUntil
                        $this->prices->f_datumgeldigtot = substr((string)$price->$tabtags['PriceEffectiveUntil'], 0, 4) . '-' .
                        substr((string)$price->$tabtags['PriceEffectiveUntil'], 4, 2) . '-' . substr((string)$price->$tabtags['PriceEffectiveUntil'], 6, 2);
                     $this->prices->addprice();
                  }
               }

               break;
            case 'measure':
            case 'Measure':
               $this->f_formaat = (string)$elem->$tabtags['Measurement'];
               if((string)$elem->$tabtags['MeasureTypeCode'] == 1)
                  $this->f_formaat_lengte = (string)$elem->$tabtags['Measurement'];
               if((string)$elem->$tabtags['MeasureTypeCode'] == 2)
                  $this->f_formaat_breedte = (string)$elem->$tabtags['Measurement'];
               if((string)$elem->$tabtags['MeasureTypeCode'] == 3)
                  $this->f_formaat_hoogte = (string)$elem->$tabtags['Measurement'];
               if((string)$elem->$tabtags['MeasureTypeCode'] == 8)
                  $this->f_gewicht = (string)$elem->$tabtags['Measurement'];

               break;
            case 'b255':
            case 'PagesArabic':
               $this->f_aantpag = (string)$elem;
               break;
            case 'b057':
            case 'EditionNumber':
               $this->f_editie = (string)$elem;
               break;
            case 'b211':
            case 'EpubType':
               $this->f_epubtype = (string)$elem;//(string)$elem;
               break;
            case 'b333':
            case 'ProductFormDetail':
               $this->f_pfdetail = (string)$elem;
               break;

         }
      }
   }

   function loadonixfilev3($filename)
   {
      $onixfile = simplexml_load_file($filename);
      if($onixfile)
      {
         $result = true;
      }
      else
      {
         $result = false;
         return $result;
      }
      //TITRE
      $children = $onixfile->Product->children();

      $i = 0;
      foreach($children as $elem)
      {
         //  var_dump($elem);
         //echo $elem->getname() . '<br>';
         switch($elem->getname())
         {
            case 'ProductIdentifier':

               if(((string)$elem->ProductIDType == 3)or((string)$elem->ProductIDType == 15))
                  $this->f_ean = (string)$elem->IDValue;

               break;
            case 'DescriptiveDetail' :

               $childrenlv2 = $elem->children();
               foreach($childrenlv2 as $elemlv2)
               {
                  switch($elemlv2->getname())
                  {
                  case 'Contributor':
                     $this->contributors->clear();
                     $this->contributors->f_persoonnaam = utf8_decode((string)$elemlv2->KeyNames);
                     $this->contributors->f_persoonrolcode = (string)$elemlv2->ContributorRole;
                     $this->contributors->f_persoonvoornaam = utf8_decode((string)$elemlv2->NamesBeforeKey);
                     $this->contributors->f_prefixtokey = (string)$elemlv2->PrefixToKey;
                     $this->contributors->f_corporatename = utf8_decode((string)$elemlv2->CorporateName);
                     $this->contributors->addcontributor();
                     //var_dump($this->contributors);
                     break;
                  case 'Language':
                     if((string)$elemlv2->LanguageRole == 1)
                        $this->f_taalcode = (string)$elemlv2->LanguageCode;
                     break;
                  case 'Subject':

                     if((string)$elemlv2->SubjectSchemeIdentifier == $this->mainsubjectschemesdentifier)
                     {
                        $this->f_nurcode = (string)$elemlv2->SubjectCode;
                        //echo 'prout'.$elemv2->SubjectCode;
                     }
                     break;

                  case 'Collection':
                     $this->f_reekstitel = utf8_decode((string)$elemlv2->TitleDetail->TitleElement->TitleText);
                     $this->f_reeksnr = (string)$elemlv2->Collectionidentifier->IDValue;
                     break;
                  case 'Measure':
                     $this->f_formaat = (string)$elem->Measurement;
                     if((string)$elemlv2->MeasureType == 1)
                        $this->f_formaat_lengte = (string)$elemlv2->Measurement;
                     if((string)$elemlv2->MeasureType == 2)
                        $this->f_formaat_breedte = (string)$elemlv2->Measurement;
                     if((string)$elemlv2->MeasureType == 3)
                        $this->f_formaat_hoogte = (string)$elemlv2->Measurement;
                     if((string)$elemlv2->MeasureType == 8)
                        $this->f_gewicht = (string)$elemlv2->Measurement;

                     break;


               }
            }


            if((string)$elem->TitleDetail->TitleType == 1)
            {
               $this->f_titel = utf8_decode((string)$elem->TitleDetail->TitleElement->TitleText);
               $this->f_ondertitel = utf8_decode((string)$elem->TitleDetail->TitleElement->Subtitle);
            }

            if($this->f_bindwijzecode == '')
               $this->f_bindwijzecode = (string)$elem->ProductForm;

            break;

            case 'CollateralDetail':
               $childrenlv2 = $elem->children();
               foreach($childrenlv2 as $elemlv2)
               {
                  switch($elemlv2->getname())
                  {
                  case 'TextContent':
                     $this->othertext->clear();
                     $this->othertext->f_text = utf8_decode((string)$elemlv2->Text);//XMLEntities2( xmlEntities2(htmlentities((string)$elem->Text,ENT_NOQUOTES,'UTF-8')));//(
                     $this->othertext->f_typetext = (string)$elemlv2->TextType;
                     $this->othertext->f_formatcode = '0';
                     $this->othertext->addtext();
                     break;
                  case 'SupportingResource':
                     if((string)$elemlv2->ResourceContentType == '01')
                     {
                        $this->f_thumblink = (string)$elemlv2->ResourceVersion->ResourceLink;
                     }
               }
            }

            break;

            case 'PublishingDetail':
               $childrenlv2 = $elem->children();
               foreach($childrenlv2 as $elemlv2)
               {
                  switch($elemlv2->getname())
                  {
                  case 'Imprint':
                     if($elemlv2->ImprintIdentifier->ImprintIDType == '01')
                     {
                        $this->f_uitgever = utf8_decode((string)$elemlv2->ImprintIdentifier->IDTypeName);
                     }
                     break;
                  case 'SupportingResource':
                     break;
                  case 'PublishingDate':
                     // echo 'zedate';
                     if($elemlv2->PublishingDateRole == '01')
                     {

                        switch($elemlv2->DateFormat)
                        {
                        case '00':
                           if(strlen($elemlv2->Date) == 8)
                              $this->f_eersteverschijningdatum_d = substr($elemlv2->Date, 0, 4) . '.' . substr($elemlv2->Date, 4, 2) . '.' . substr($elemlv2->Date, 6, 2);
                           break;
                     }
                  }


               }
            }
            break;
            case 'ProductSupply':
               $childrenlv2 = $elem->children();
               foreach($childrenlv2 as $elemlv2)
               {
                  switch($elemlv2->getname())
                  {
                  case 'SupplyDetail':
                     $this->f_beschikbaarheidcode = (string)$elemlv2->ProductAvailability;
                     $childrenlv3 = $elemlv2->children();
                     foreach($childrenlv3 as $elemlv3)
                     {
                        switch($elemlv3->getname())
                        {
                        case 'Price':
                           $this->prices->clear();
                           $this->prices->f_bedrag = (string)$elemlv3->PriceAmount;
                           $this->prices->f_valutacode = (string)$elemlv3->CurrencyCode;
                           $this->prices->f_prijstype = (string)$elemlv3->PriceType;
                           /* if((string)$elemlv3->PriceEffectiveFrom <> '')
                           $this->prices->f_datumgeldigvanaf = substr((string)$elemlv3->PriceEffectiveFrom, 0, 4) . '-' .
                           substr((string)$elemlv3->PriceEffectiveFrom, 4, 2) . '-' . substr((string)$elemlv3->PriceEffectiveFrom, 6, 2);
                           if((string)$elemlv3->PriceEffectiveUntil <> '')
                           $this->prices->f_datumgeldigtot = substr((string)$elemlv3->PriceEffectiveUntil, 0, 4) . '-' .
                           substr((string)$elemlv3->PriceEffectiveUntil, 4, 2) . '-' . substr((string)$elemlv3->PriceEffectiveUntil, 6, 2);*/
                           $this->prices->addprice();

                           break;

                     }


                  }



                  break;

               }
            }

            break;
            case 'xSupplyDetail':

               //********************************************shipdate
               if((string)$elem->ExpectedShipDate <> '')
               {
                  $size = strlen((string)$elem->ExpectedShipDate);
                  if(($size == 4)or($size == 6)or($size == 8))
                  {
                     $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 0, 4);
                     $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 0, 4);
                     if(($size == 8)or($size == 6))
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 4, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 4, 2) . '-' . $this->f_verschijningsdatum;
                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                     if($size == 8)
                     {
                        $this->f_verschijningdatum_d = substr((string)$elem->ExpectedShipDate, 6, 2) . '.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = substr((string)$elem->ExpectedShipDate, 6, 2) . '-' . $this->f_verschijningsdatum;

                     }
                     else
                     {
                        $this->f_verschijningdatum_d = '01.' . $this->f_verschijningdatum_d;
                        $this->f_verschijningsdatum = '01-' . $this->f_verschijningsdatum;
                     }
                  }
                  //$this->f_verschijningdatum_d =
               }
               //********************************************* product availability
               foreach($elem->children() as $price)
               {
                  if($price->getname() == 'Price')
                  {
                     $this->prices->clear();
                     $this->prices->f_bedrag = (string)$price->PriceAmount;
                     $this->prices->f_valutacode = (string)$price->CurrencyCode;
                     $this->prices->f_prijstype = (string)$price->PriceTypeCode;
                     if((string)$price->PriceEffectiveFrom <> '')
                        $this->prices->f_datumgeldigvanaf = substr((string)$price->PriceEffectiveFrom, 0, 4) . '-' .
                        substr((string)$price->PriceEffectiveFrom, 4, 2) . '-' . substr((string)$price->PriceEffectiveFrom, 6, 2);
                     if((string)$price->PriceEffectiveUntil <> '')
                        $this->prices->f_datumgeldigtot = substr((string)$price->PriceEffectiveUntil, 0, 4) . '-' .
                        substr((string)$price->PriceEffectiveUntil, 4, 2) . '-' . substr((string)$price->PriceEffectiveUntil, 6, 2);
                     $this->prices->addprice();
                  }

               }

               break;
            case 'xPagesArabic':
               $this->f_aantpag = (string)$elem;
               break;
            case 'xEditionNumber':
               $this->f_editie = (string)$elem;
               break;
            case 'xEpubType':
               $this->f_epubtype = (string)$elem;//(string)$elem;
               break;
            case 'xProductFormDetail':
               $this->f_pfdetail = (string)$elem;
               break;

         }
      }
      return $result;
   }



}
//*******************************************************************************************
//********************************************************************* Contributors class
//*******************************************************************************************

class contributors extends dbmodel
{
   function contributors($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'personen';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }

   function loadcontributors($ean = null , $dbprovider, $titelid = null)
   {
      if(isset($ean))
      {
         $mode = 'ean';
      }
      else if(isset($titelid))
      {
         $mode = 'id';
      }
      else
      {
         $mode = 'none';

      }

      switch($mode)
      {
         case 'ean':
            $sql = 'select a.*,c.onixcode from personen a
						join parking b on b.titelid=a.titelid
						join rolcode c on c.rolcode=a.persoonrolcode
						where b.dbproviderid=' . $dbprovider . ' and b.ean=\'' . $ean . '\'';
            break;
         case 'id' :
            $sql = 'select a.*,c.onixcode,c.rolnaam from personen a
						join rolcode c on c.rolcode=a.persoonrolcode
						where a.titelid=\'' . $titelid . '\'';
            break;
      }
      $this->dbdf->requete($sql, 'contributors');
      $i = 0;
      $row = $this->dbdf->resultat('contributors');
      $rsarray = array();
      while(!$row == false)
      {
         $rsarray[$i] = $row;
         $i++;
         $row = $this->dbdf->resultat('contributors');
      }

      $this->listcontributors = $rsarray;
      $this->focuscontributor(0);
      return $rsarray;

   }
   function contributorfullname($rolcode)
   {

      switch($rolcode)
      {
         case 'author':
            $rolcode = 'a01';
            break;
      }



      foreach($this->listcontributors  as $row)
      {
         $pos = strpos($rolcode, $row['ONIXCODE']);
         if($pos === false)
         {

         }
         else
         {
            return $row['PERSOONVOORNAAM'] . ' ' . $row['PREFIXTOKEY'] . ' ' . $row['PERSOONNAAM'];
         }
      }

   }
   function focuscontributor($nr)
   {
      $this->clear();
      if($this->dbdf) $this->dbdf->row2class($this->listcontributors[$nr], $this, true, true, '', $this->tablename);

   }
   function deleteallcontributors($titelid)
   {
      $sql = "delete from personen a where a.titelid='" . $titelid . "'";
      $this->dbdf->requete($sql, 'deletecontributors');
   }
   function savecontributors()
   {
      if($this->f_titelid <> '')
         $this->dbdf->requete('delete from personen where titelid=\'' . $this->f_titelid . '\'', 'delete');

      $i = 0;
      if(isset($this->listcontributors))
      {
         foreach($this->listcontributors  as $row)
         {
            $this->focuscontributor($i);
            $sql = $this->buildinsertsql();
            $this->dbdf->requete($sql, 'insert');
            $i++;
         }
      }

   }
   function settitelid($titelid)
   {

      $this->f_titelid = $titelid;
      $i = 0;
      if(isset($this->listcontributors))
      {
         foreach($this->listcontributors  as $row)
         {
            $this->listcontributors[$i]['TITELID'] = $titelid;
            $i++;
         }
      }
   }
   function addcontributor()
   {
      $tmparr = array();
      foreach($this as $name => $value)
      {
         if(substr($name, 0, 2) == 'f_')
         {
            $tmparr[strtoupper(substr($name, 2))] = $value;
         }
      }
      $this->listcontributors[] = $tmparr;
   }

}

//*******************************************************************************************
//********************************************************************* Price class
//*******************************************************************************************

class prices extends dbmodel
{
   function prices($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'productprices';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }

   function loadprices($ean = null , $dbprovider = null , $titelid = null)
   {
      if(isset($ean))
      {
         $mode = 'ean';
      }
      else if(isset($titelid))
      {
         $mode = 'id';
      }
      else
      {
         $mode = 'none';

      }

      switch($mode)
      {
         case 'ean':
            $sql = 'select a.* from productprices a
						join parking b on b.titelid=a.titelid
						where b.dbproviderid=' . $dbprovider . ' and b.ean=\'' . $ean . '\'';
            break;
         case 'id' :
            $sql = 'select * from productprices a
						where a.titelid=\'' . $titelid . '\'';
            break;
      }
      //die($sql);
      $this->dbdf->requete($sql, 'prices');
      $i = 0;
      $row = $this->dbdf->resultat('prices');
      $rsarray = array();
      while(!$row == false)
      {

         $rsarray[$i] = $row;
         $i++;
         $row = $this->dbdf->resultat('prices');
      }

      $this->listprices = $rsarray;
      return $rsarray;

   }
   function deleteallprices($titelid)
   {
      $sql = "delete from productprices a where a.titelid='" . $titelid . "'";
      $this->dbdf->requete($sql, 'deleteprices');
   }

   function saveprices()
   {
      if($this->f_titelid <> '')
         $this->dbdf->requete('delete from productprices where titelid=\'' . $this->f_titelid . '\'', 'delete');

      $i = 0;
      if(isset($this->listprices))
      {
         foreach($this->listprices  as $row)
         {
            $this->focusprice($i);
            $sql = $this->buildinsertsql();
            $this->dbdf->requete($sql, 'insert');
            //echo $sql;
            $i++;
         }
      }


   }

   function getprice($onixcode)
   {
      if(isset($this->listprices))
      {
         foreach($this->listprices  as $row)
         {
            if($row['PRIJSTYPE'] == $onixcode)
               return $row;
         }
      }
   }

   function gettodaysprice($oxc)
   {
      $TODAY = date('Ymd');
      return $this->getdayprice($oxc, $TODAY);
   }

   function getdayprice($onixcode, $daydate)
   {
      $SD = '0';
      $ED = '0';
      $PRICE = '0';
      $goodi = 0;
      $i = 0;

      if(isset($this->listprices))
      {
         foreach($this->listprices  as $row)
         {
            //$this->f_datumgeldigtot='';
            $this->focusprice($i);

            if(($row['PRIJSTYPE'] == $onixcode)or($row['PRIJSTYPE'] == '12'))
            {
               //print_r($row);
               //echo '<b>'.$this->f_bedrag.'</b>';
               if(
               ($daydate >= str_replace('-', '', substr($this->f_datumgeldigvanaf, 0, 10)))
               && ($this->f_datumgeldigtot == '' || ($daydate <= str_replace('-', '', substr($this->f_datumgeldigtot, 0, 10))))
               )
               {
                  if(($PRICE == '0') || str_replace('-', '', substr($this->f_datumgeldigvanaf, 0, 10)) > $SD)
                  {
                     $goodi = $i;
                     $SD = str_replace('-', '', substr($this->f_datumgeldigvanaf, 0, 10));
                     if(trim(str_replace('-', '', substr($this->f_datumgeldigtot, 0, 10))) <> '')
                        $ED = str_replace('-', '', substr($this->f_datumgeldigtot, 0, 10));
                     $PRICE = $this->f_bedrag;
                  }

               }
            }
            $i++;
         }
         $this->focusprice($goodi);
         return $PRICE;
      }
   }

   function setprice($onixcode, $price,$currency='EUR')
   {
      if(isset($this->listprices))
      {
         foreach($this->listprices  as &$row)
         {
            if($row['PRIJSTYPE'] == $onixcode and $row['VALUTACODE']==$currency)
            {
            $row['BEDRAG'] = $price;
            }
         }
      }
   }

   function focusprice($nr)
   {
      if($this->dbdf)
      {
         $this->clear();
         $this->dbdf->row2class($this->listprices[$nr], $this, true, true, '', $this->tablename);
      }

   }
   function settitelid($titelid)
   {

      $this->f_titelid = $titelid;
      $i = 0;
      if(isset($this->listprices))
      {
         foreach($this->listprices  as $row)
         {
            $this->listprices[$i]['TITELID'] = $titelid;
            $i++;
         }
      }
   }
   function addprice()
   {
      $tmparr = array();
      foreach($this as $name => $value)
      {
         if(substr($name, 0, 2) == 'f_')
         {
            $tmparr[strtoupper(substr($name, 2))] = $value;
         }
      }
      $this->listprices[] = $tmparr;
   }

}

//*******************************************************************************************
//********************************************************************* Other Text
//*******************************************************************************************

class othertext extends dbmodel
{
   function othertext($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'producttext';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }

   function loadtext($ean = null , $dbprovider = null , $titelid = null)
   {
      if(isset($ean))
      {
         $mode = 'ean';
      }
      else if(isset($titelid))
      {
         $mode = 'id';
      }
      else
      {
         $mode = 'none';

      }

      switch($mode)
      {
         case 'ean':
            $sql = 'select a.*,b.onyxcode from producttext a left join producttexttype b on b.typetext=a.typetext join parking c on c.titelid=a.titelid where c.dbproviderid=' . $dbprovider . ' and c.ean=\'' . $ean . '\'';
            break;
         case 'id' :
            $sql = 'select a.*,b.onyxcode from producttext a left join producttexttype b on b.typetext=a.typetext where a.titelid=\'' . $titelid . '\'';
            break;
      }
      
      $this->f_titelid = $titelid;
      $this->dbdf->requete($sql, 'text');
      $i = 0;
      $row = $this->dbdf->resultat('text');
      //echo $sql;
      //print_r($row);
      $rsarray = array();
      while(!$row == false)
      {
         //print_r($row);
         $rsarray[$i] = $row;
         $i++;
         $row = $this->dbdf->resultat('text');
      }

      $this->listtext = $rsarray;
      return $rsarray;

   }

   function gettext($onixcode)
   {
      foreach($this->listtext  as $row)
      {
         if($onixcode == $row['ONYXCODE'])
         {
            $blob_data = ibase_blob_info($row['TEXT']);
            $blob_hndl = ibase_blob_open($row['TEXT']);
            return ibase_blob_get($blob_hndl, $blob_data[0]);
            break;
         }
      }

   }
   function deleteallothertext($titelid)
   {
      $sql = "delete from producttext a where a.titelid='" . $titelid . "'";
      $this->dbdf->requete($sql, 'deletetext');
   }

   function saveothertext()
   {
      $i = 0;
      if(isset($this->listtext))
      {
         foreach($this->listtext  as $row)
         {
            $this->focustext($i);
            if($this->f_titelid <> '') $this->dbdf->requete("delete from producttext where titelid = '" . $this->f_titelid . "' and typetext = '" . $this->f_typetext . "'", 'delete');
            $sql = $this->buildinsertsql();
            $this->dbdf->requete($sql, 'insert');

            //echo $sql.'<br /><br />';
            $i++;
         }
      }


   }
   function focustext($nr)
   {
      $this->clear();
      $this->dbdf->row2class($this->listtext[$nr], $this, true, true, '', $this->tablename);

   }
   function settitelid($titelid)
   {

      $this->f_titelid = $titelid;
      $i = 0;
      if(isset($this->listtext))
      {
         foreach($this->listtext  as $row)
         {
            $this->listtext[$i]['TITELID'] = $titelid;
            $i++;
         }
      }
   }
   function addtext()
   {
      $tmparr = array();
      foreach($this as $name => $value)
      {
         if(substr($name, 0, 2) == 'f_')
         {
            $tmparr[strtoupper(substr($name, 2))] = $value;
         }
      }
      $this->listtext[] = $tmparr;
   }

}

class publication extends dbmodel
{
   function publication($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'publication';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
      //$this->domainpub = new domain_pub($this->dbdf);
   }

   /*function __destruct()
   {
   unset($this->domainpub);
   }*/

   function loadpub($ean = null , $dbprovider = null , $titelid = null)
   {
      if(isset($ean))
      {
         $mode = 'ean';
      }
      else if(isset($titelid))
      {
         $mode = 'id';
      }
      else
      {
         $mode = 'none';

      }

      switch($mode)
      {
         case 'ean':
            $sql = "select * from publication where pub_ean='" . $ean . "'";
            break;
      }
      $this->dbdf->requete($sql, 'pub');
      $i = 0;
      $row = $this->dbdf->resultat('pub');
      //echo $sql;
      //print_r($row);
      $rsarray = array();
      while(!$row == false)
      {

         $rsarray[$i] = $row;
         $i++;
         $row = $this->dbdf->resultat('pub');
      }

      $this->listpub = $rsarray;
      return $rsarray;

   }
   function getpub($pubtype)
   {
      if(isset($this->listpub))
      {
         foreach($this->listpub  as $row)
         {
            if($pubtype == $row['PUB_TYPE'])
            {
               return $row;
               break;
            }
         }
      }
      return false;

   }
   function deleteallpublications($ean)
   {
      $sql = "delete from publication a where a.ean'" . $ean . "'";
      $this->dbdf->requete($sql, 'delete');
   }

   function savepublications()
   {

      $i = 0;
      if(isset($this->listpub))
      {
         foreach($this->listpub  as $row)
         {
            $this->focuspub($i);
            if($this->f_pub_id <> '')
               $sql = $this->buildupdatesql() . ' where pub_id=' . $this->f_pub_id;
            else
               $sql = $this->buildinsertsql();

            $this->dbdf->requete($sql, 'insert');

            $this->clear();
            //echo $sql . '<br>';

            $i++;

         }
      }


   }

   function savepublications_insert()
   {
      $i = 0;
      if(isset($this->listpub))
      {
         foreach($this->listpub  as $row)
         {
            $this->focuspub($i);
            $sql = $this->buildinsertsql();
            //echo $sql;
            $this->dbdf->requete($sql, 'insert');
            $this->clear();
            $i++;
         }
      }
   }

   function focuspub($nr)
   {
      $this->clear();
      $this->dbdf->row2class($this->listpub[$nr], $this, true, true, '', $this->tablename);

   }
   function addpub()
   {
      $tmparr = array();
      foreach($this as $name => $value)
      {
         if(substr($name, 0, 2) == 'f_')
         {
            $tmparr[strtoupper(substr($name, 2))] = $value;
         }
      }
      $this->clear();
      $this->listpub[] = $tmparr;
   }
   /*   function clear()
   {
   foreach($this as $name => $value)
   {
   if(substr($name, 0, 2) == 'f_')
   {
   unset($this->$name);
   }
   }

   }*/

}

class todoupdate extends dbmodel
{
   function todoupdate($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'todoupdate';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }

   function deletetodoprices($titelid)
   {
      $sql = "delete from todoupdate a where a.status=0 and a.destfield='price' and a.titelid='" . $titelid . "'";
      //	  echo $sql;
      $this->dbdf->requete($sql, 'deletetodoprices');
   }

   function focustodoupdate($nr)
   {
      $this->clear();
      if($this->dbdf) $this->dbdf->row2class($this->listtodoupdate[$nr], $this, true, true, '', $this->tablename);
   }

   function savetodoupdate($titelid)
   {
      $this->deletetodoprices($titelid);
      $i = 0;
      if(isset($this->listtodoupdate))
      {
         foreach($this->listtodoupdate  as $row)
         {
            $this->focustodoupdate($i);
            $sql = $this->buildinsertsql();
            $this->dbdf->requete($sql, 'insert');
            $i++;
         }
      }
   }

   function addtodoupdate()
   {
      $tmparr = array();
      foreach($this as $name => $value)
      {

         if(substr($name, 0, 2) == 'f_')
         {
            //echo $value.' ';
            $tmparr[strtoupper(substr($name, 2))] = $value;
            //echo $tmparr[strtoupper(substr($name, 2))];
         }
      }
      $this->listtodoupdate[] = $tmparr;
   }

   function loadtodoupdateprices($titelid, $prices)
   {
      //echo 'loadtodoupdateprices<br />';
      $i = 0;
      $today = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
      //echo date("n-j-Y").'<br />';
      if(isset($prices->listprices))
      {
         foreach($prices->listprices  as $row)
         {
            $prices->focusprice($i);
            $startdate = mktime(0, 0, 0, substr($prices->f_datumgeldigvanaf, 5, 2), substr($prices->f_datumgeldigvanaf, 8, 2), substr($prices->f_datumgeldigvanaf, 0, 4));
            //echo $prices->f_datumgeldigvanaf .' - '.'<br />';
            if(($startdate > $today) && (($prices->f_prijstype == '02') || ($prices->f_prijstype == '12')))
            // Si on doit grer les prix promotion, alors il faut le grer ici le code typeprix 12 !
            // et quand c'est un type 12 il faut grer le todotupdate pour remettre le prix
            {
               $this->clear();
               $this->f_destfield = 'price';
               $this->f_destvalue = $prices->f_bedrag;
               $this->f_dateupdate = $prices->f_datumgeldigvanaf;
               $this->f_titelid = $titelid;
               //echo 'ici'.$this->f_destfield.$this->f_destvalue.$this->f_dateupdate.$this->f_titelid.'<br />';
               $this->addtodoupdate();
            }
            else if(isset($prices->f_datumgeldigtot))
            {
               $enddate = mktime(0, 0, 0, substr($prices->f_datumgeldigtot, 5, 2), substr($prices->f_datumgeldigtot, 8, 2), substr($prices->f_datumgeldigtot, 0, 4));
               if(($enddate > $today) && ($prices->f_prijstype == '12'))
               {
                  // 	ajouter un todoupdate... avec le prix pour aprs cette date
                  $this->clear();
                  $this->f_destfield = 'price';
                  $this->f_destvalue = $prices->getdayprice('02', date('Ymd', $enddate + 86400));
                  $this->f_dateupdate = date("Y-m-d", $enddate + 86400);
                  $this->f_titelid = $titelid;
                  //	echo 'ici'.$this->f_destfield.$this->f_destvalue.$this->f_dateupdate.$this->f_titelid.'<br />';
                  $this->addtodoupdate();
               }
            }
            $i++;
         }
      }
   }


}

class domain_cat extends dbmodel
{
   function domain_cat($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'domain_cat';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }

   function loaddomain_cat($dc)
   {//first(10)
      $sql = "select * from domain_cat dc where dc.domain_code=" . $dc;
      $this->dbdf->requete($sql, 'domain_cat');
      //if ($this->nextdomain_cat()==false) return false;
      //else return true;
   }

   function nextdomain_cat()
   {
      $row = $this->dbdf->resultat('domain_cat');
      if($row == false)
         return false;
      else
      {
         $this->dbdf->row2class($row, $this, true, true, 'domain_cat', $this->tablename);
         return true;
      }
   }

   function copyvalues($exobj, $utf8 = 1)
   {
      foreach($this as $name => $value)
      {
         if(substr($name, 0, 2) == 'f_')
         {
            if($utf8)
               $exobj->$name = utf8encodeifnecessary($this->$name);
            else
               $exobj->$name = $this->$name;
         }
         // if(substr($name, 0, 2) == 'i_') $exobj->$name =$this->$name;
      }
   }

   function save()
   {
      $this->delete($this->f_domain_code, $this->f_ean);
      $sql = $this->buildinsertsql();
      $this->dbdf->requete($sql, 'insertdomaincat');
   }

   function delete($dc, $ean)
   {
      $sql = "delete from domain_cat dc where dc.domain_code=" . $dc . " and ean='" . $ean . "'";
      $this->dbdf->requete($sql, 'deletedomaincat');
   }
}

class tldbsdata extends dbmodel
{
   function tldbsdata($dbconnexion = null , $server = '', $login = '', $pass = '', $path = '', $debug = 0)
   {
      $this->tablename = 'tldbsdata';
      $this->dbmodel($dbconnexion, $server, $login, $pass, $path, $debug);
   }
   function save()
   {
      $this->delete($this->f_dbpid, $this->f_ean);
      $sql = $this->buildinsertsql();
      $this->dbdf->requete($sql, 'savetldbsdata');
   }

   function delete($dbpid, $ean)
   {
      $sql = "delete from tldbsdata t where t.dbpid=" . $dbpid . " and t.ean='" . $ean . "'";
      $this->dbdf->requete($sql, 'deletetldbsdata');
   }

}

function XMLEntities($string)
{
   $string = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '_privateXMLEntities("$0")', $string);
   return $string;
}

function _privateXMLEntities($num)
{
   $chars = array(
                  128 => '&#8364;',
                  130 => '&#8218;',
                  131 => '&#402;',
                  132 => '&#8222;',
                  133 => '&#8230;',
                  134 => '&#8224;',
                  135 => '&#8225;',
                  136 => '&#710;',
                  137 => '&#8240;',
                  138 => '&#352;',
                  139 => '&#8249;',
                  140 => '&#338;',
                  142 => '&#381;',
                  145 => '&#8216;',
                  146 => '&#8217;',
                  147 => '&#8220;',
                  148 => '&#8221;',
                  149 => '&#8226;',
                  150 => '&#8211;',
                  151 => '&#8212;',
                  152 => '&#732;',
                  153 => '&#8482;',
                  154 => '&#353;',
                  155 => '&#8250;',
                  156 => '&#339;',
                  158 => '&#382;',
                  159 => '&#376;');
   $num = ord($num);
   return(($num > 127 && $num < 160) ? $chars[$num] : "&#" . $num . ";");
}

function xmlEntities2($str)
{
   $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;', '&#8211');
   $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&ndash;');
   $str = str_replace($html, $xml, $str);
   $str = str_ireplace($html, $xml, $str);
   return $str;
}

function get_html_translation_table_CP1252()
{
   $trans = get_html_translation_table(HTML_ENTITIES);
   $trans[chr(130)] = '&sbquo;';// Single Low-9 Quotation Mark
   $trans[chr(131)] = '&fnof;';// Latin Small Letter F With Hook
   $trans[chr(132)] = '&bdquo;';// Double Low-9 Quotation Mark
   $trans[chr(133)] = '&hellip;';// Horizontal Ellipsis
   $trans[chr(134)] = '&dagger;';// Dagger
   $trans[chr(135)] = '&Dagger;';// Double Dagger
   $trans[chr(136)] = '&circ;';// Modifier Letter Circumflex Accent
   $trans[chr(137)] = '&permil;';// Per Mille Sign
   $trans[chr(138)] = '&Scaron;';// Latin Capital Letter S With Caron
   $trans[chr(139)] = '&lsaquo;';// Single Left-Pointing Angle Quotation Mark
   $trans[chr(140)] = '&OElig;    ';// Latin Capital Ligature OE
   $trans[chr(145)] = '&lsquo;';// Left Single Quotation Mark
   $trans[chr(146)] = '&rsquo;';// Right Single Quotation Mark
   $trans[chr(147)] = '&ldquo;';// Left Double Quotation Mark
   $trans[chr(148)] = '&rdquo;';// Right Double Quotation Mark
   $trans[chr(149)] = '&bull;';// Bullet
   $trans[chr(150)] = '&ndash;';// En Dash
   $trans[chr(151)] = '&mdash;';// Em Dash
   $trans[chr(152)] = '&tilde;';// Small Tilde
   $trans[chr(153)] = '&trade;';// Trade Mark Sign
   $trans[chr(154)] = '&scaron;';// Latin Small Letter S With Caron
   $trans[chr(155)] = '&rsaquo;';// Single Right-Pointing Angle Quotation Mark
   $trans[chr(156)] = '&oelig;';// Latin Small Ligature OE
   $trans[chr(159)] = '&Yuml;';// Latin Capital Letter Y With Diaeresis
   ksort($trans);
   return $trans;
}

function xmlEntities3($s)
{
   //build first an assoc. array with the entities we want to match
   $table1 = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
   //echo count($table1);
   //print_r $table1;

   //now build another assoc. array with the entities we want to replace (numeric entities)
   foreach($table1 as $k => $v)
   {
      $table1[$k] = "/$v/";
      $c = htmlentities($k, ENT_QUOTES, "UTF-8");
      $table2[$c] = "&#" . ord($k) . ";";
   }
   //now perform a replacement using preg_replace
   //each matched value in array 1 will be replaced with the corresponding value in array 2
   $s = preg_replace($table1, $table2, $s);

   return $s;

}


## Fonction qui transforme les entits hexadecimales en entits dcimales
##Exemple d'utilisation  :
##$stri=' en niet &#xE9;&#xA5;n maar drie keer?';
##$tmp = hexentities_to_decentities($stri);
##echo $tmp;

function hexentities_to_decentities($chaine)
{
   preg_match_all('/&#([a-zA-Z0-9]*);/', $chaine, $matches);
   $cpt = 0;
   foreach($matches[0] as $subval)
   {
      //echo $subval.'<br />';
      $rep = '&#' . hexdec($matches[1][$cpt]) . ';';
      $chaine = str_replace($subval, $rep, $chaine);
      $cpt++;
   }
   return($chaine);
}


?>