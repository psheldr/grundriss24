<form method="post" action="index.php?action=suche_kunden">
    <input type="text" name="search_user" />
    <input type="submit" value="Suche nach Kunde"/>
</form>


<?php if($kunden != NULL) { foreach($kunden as $kunde) { ?>
<br /><a style="font-weight: bold; font-size: 14px;" href="index.php?action=auftrag_als_kunde&id=<?php echo $kunde->getId() ?>&login=<?php echo $kunde->getLogin() ?>&p=<?php echo $kunde->getPasswort() ?>"><?php echo $kunde->getFirma() ?></a><br />

<?php }} ?>