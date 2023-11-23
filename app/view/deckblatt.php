<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> Deckblatt grundriss24.de </title>
        <meta name="description" content="Der Service für Immobilienmakler: Wir verwandeln Ihre Vorlagen in verkaufsfördernde und attraktive Grundrisse." />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="language" content="de" />

<link href="../css/deckblatt_style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">

function closeWindow()
{
window.close();
window.opener.location.replace('../Auftraege');
}
</script>
</head>
<body>
<?
   $u = $_SESSION['u'];
   if (isset($_GET['a'])) {
      $a = $_GET['a'];}
      else {
      $a = $auftragsnummer; }
      
   include "opendb.php";
   $gehoertzu = $_SESSION['logged_in_userid'];
   if ($a<1) {
      die ("Fehler bei der Verarbeitung. Bitte melden Sie sich erneut an!!!");}
   
   $select = "select * from tbl_auftraege where auftragsnummer=$a and gehoertzu=$gehoertzu";
   $RS=mysql_query($select,$Conn);
   if (mysql_num_rows($RS)==0) {
      die ("Fehler!!!");}
   
   $select = "select * from tbl_auftraege where auftragsnummer=$a";
   $RS=mysql_query($select,$Conn);
   $row = mysql_fetch_object($RS);
   $auftragsname = $row->auftragsname;
   $design = $row->design;
   $holzboden = $row->holzboden;
   if ($row->web==1) {
	  $web = "mit Web-Grafiken";}
	  else {
	  $web = "ohne Web-Grafiken";}
   
   $angaben = "";
   if ($row->info == 1) {
      $angaben = "mit Objektinfos, ";}
   if ($row->bezeichnungen == 1) {
      $angaben = $angaben . "mit Raumbezeichnungen, ";}
   if ($row->qm == 1) {
      $angaben = $angaben . "mit qm-Angaben";}
   
   $ansprechpartner = $row->ansprechpartner;
   $bemerkung = $row->bemerkung;
   $select2 = "select * from tbl_user where id=$row->gehoertzu";
   $RS2=mysql_query($select2,$Conn);
   $row2 = mysql_fetch_object($RS2);
?>
<table width="640" border="0" cellpadding="0" cellspacing="0">
  <tr> 
     <td>
     <table width="640" border="0">
        <tr>
     <td align="left">
     <form name="1" action="javascript:window.print()">&nbsp;&nbsp;&nbsp;&nbsp;<input name="btndrucken" type="submit" value="Drucken" /></form>
     <form name="2" action="javascript:closeWindow()">&nbsp;&nbsp;&nbsp;&nbsp;<input name="btnschliessen" type="submit" value="Schließen" /></form>
     </td><td height="80" align="right"><img src="../images/logo.gif" />;</td>
     </tr>
     </table>     
     </td>
    
  </tr>
  <tr> 
    <td><font size="-4" face="Tahoma">&nbsp;&nbsp;&nbsp;&nbsp</font> </td>
  </tr>
  <tr> 
    <td><table width="640" border="0">
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="620" class="textgross">grundriss24.de<br>
            Allersberger Straße 185/O<br>
            90461 Nürnberg<br>
            <br>
            <!-- <span class="textbold">Fax bitte an: 0911 / 46 20 68 62</span></td>-->
            <span class="textbold">Fax bitte an: 0800 / 74 66 324</span></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="81">&nbsp;</td>
  </tr>
  <tr> 
      <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="textsehrgross">Auftrag für Grundriss 24.de</span><br><br>
    
    <table width="650" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Auftragsnummer:</td>
          <td valign="top" class="textgross"> <?echo $a;?></td>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Auftragsname:</td>
          <td valign="top" class="textgross"> <?echo $auftragsname;?></td>
    <tr>
          <td valign="top"><img src="bilder/grundriss.gif" width="132" height="20"></td>
		  <td valign="top"><img src="bilder/grundriss.gif" width="268" height="20"></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Auftraggeber:</td>
          <td valign="top" class="textgross"><?echo $row2->firma;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross"></td>
          <td valign="top" class="textgross"><?echo $row2->strasse;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross"></td>
          <td valign="top" class="textgross"><?echo $row2->plz . " " .$row2->ort;?></td>
        </tr>
    <tr>
          <td valign="top">&nbsp;</td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Ansprechpartner:</td>
          <td valign="top" class="textgross"> <?echo $ansprechpartner;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Telefon:</td>
          <td valign="top" class="textgross"> <?echo $row2->tel;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Fax:</td>
          <td valign="top" class="textgross"> <?echo $row2->fax;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Mobiltelefon:</td>
          <td valign="top" class="textgross"> <?echo $row2->mobil;?></td>
        </tr>
    <tr>
          <td valign="top">&nbsp;</td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Design:</td>
          <td valign="top" class="textgross"> <?echo $design;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Grafiken:</td>
          <td valign="top" class="textgross"> <?echo $web;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Parkett/Holzboden in:</td>
          <td valign="top" class="textgross"> <?echo $holzboden;?></td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Weitere Angaben:</td>
          <td valign="top" class="textgross"> <?echo $angaben;?></td>
        </tr>
    <tr>
          <td valign="top">&nbsp;</td>
        </tr>
    <tr>
          <td valign="top" class="textgross">&nbsp;&nbsp;&nbsp;&nbsp;Bemerkung:</td>
          <td valign="top" class="textgross"> <?echo $bemerkung;?></td>
    </table>
    </td>
  </tr>
  <tr> 
    <td height="41">&nbsp;</td>
  </tr>
  <tr> 
    <td height="47">&nbsp;</td>
  </tr>
  <tr> 
    <td height="62">&nbsp;</td>
  </tr>
</table>
<font size="-5" face="Tahoma"></font> 
</body>
</html>
