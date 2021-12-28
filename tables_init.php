<?php
session_start();
if (isset($_SESSION['prenom'])) {
	$prenom = $_SESSION['prenom'];
	$type = $_SESSION['type'];
	$nb = $_SESSION['nb'];
}
?>

<?php include 'header.php'; ?>
			<div id="splash">
				<div class="top"><img src="images/Math.png" alt="" width="460" height="180" /></div>
				<div class="bottom"></div>
			</div>
			<div id="samples">

<script type="text/javascript">
window.onload =function setFocus(){
    document.infos.prenom.focus();
    return true;
}
function verif(){
	var reg = /^[\d]+$/;
	if (document.infos.prenom.value == "") {
		alert('Attention, tu dois indiquer ton prénom !'); 
		document.infos.prenom.focus();
    	return false;
		
	} else if (document.infos.nb.value == "") return true;
    else if (reg.test(document.infos.nb.value)) return true;
    else {
    	alert('Attention '+document.infos.prenom.value+', pour le nombre d\'opérations, tu dois mettre un nombre ou rien');
    	document.infos.nb.focus();
    	return false;
    }
}
</script>

<h1>Programme pour apprendre les tables</h1>

<FORM name="infos" action="tables.php" method="GET">
		<p>Indique ton prénom : <INPUT type="text" name="prenom" value="<?php echo $prenom;?>"/></p>
		<p>Veux tu faire des additions ou des multiplications ?   <br/>
			<INPUT type="radio" name="type" value="addition" <?php echo (isset($type)?($type=='addition'?'checked':''):'checked');?>/> Des additions <br/>
			<INPUT type="radio" name="type" value="multiplication" <?php echo ($type=='multiplication'?'checked':'');?>/> Des multiplications
			</p>
		<p>Combien d'opérations veux-tu faire ?  <INPUT type="text" name="nb" value="<?php echo $nb;?>"/> (ne mets pas de valeur si tu veux faire toutes les tables)</p>
		<INPUT type="submit" name="Envoyer" value="Commencer" onClick="return verif();"/>
</FORM>


			</div>
<?php include 'footer.php'; ?>