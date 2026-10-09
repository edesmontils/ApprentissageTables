<?php
session_start();
require 'fonctions.php';
$prenom = $_SESSION['prenom'] ?? '';
$type = $_SESSION['type'] ?? 'addition';
$nb = $_SESSION['nb_demande'] ?? '';
$max = 81;
?>

<?php include 'header.php'; ?>
			<div id="splash">
				<div class="top"><img src="images/Math.png" alt="" width="460" height="180" /></div>
				<div class="bottom"></div>
			</div>
			<div id="samples">

<script>
window.onload = function () {
	document.infos.prenom.focus();
};
function verif() {
	var reg = /^\d+$/;
	var nb = document.infos.nb.value;
	if (document.infos.prenom.value.trim() == "") {
		alert('Attention, tu dois indiquer ton prénom !');
		document.infos.prenom.focus();
		return false;
	} else if (nb == "") return true;
	else if (reg.test(nb) && nb >= 1 && nb <= <?php echo $max; ?>) return true;
	else {
		alert('Attention ' + document.infos.prenom.value + ', pour le nombre d\'opérations, tu dois mettre un nombre entre 1 et <?php echo $max; ?> ou rien');
		document.infos.nb.focus();
		return false;
	}
}
</script>

<h1>Programme pour apprendre les tables</h1>

<form name="infos" action="tables.php" method="post">
		<p>Indique ton prénom : <input type="text" name="prenom" value="<?php echo h($prenom); ?>" /></p>
		<p>Veux-tu faire des additions ou des multiplications ?<br />
			<input type="radio" name="type" value="addition" <?php echo $type == 'addition' ? 'checked' : ''; ?> /> Des additions <br />
			<input type="radio" name="type" value="multiplication" <?php echo $type == 'multiplication' ? 'checked' : ''; ?> /> Des multiplications
		</p>
		<p>Combien d'opérations veux-tu faire ? <input type="text" name="nb" inputmode="numeric" value="<?php echo h($nb); ?>" /> (ne mets pas de valeur si tu veux faire toutes les tables)</p>
		<input type="submit" value="Commencer" onclick="return verif();" />
</form>

			</div>
<?php include 'footer.php'; ?>
