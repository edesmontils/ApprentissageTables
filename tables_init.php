<?php
session_start();
require 'fonctions.php';
$prenom = $_SESSION['prenom'] ?? '';
$type = $_SESSION['type'] ?? 'addition';
$nb = $_SESSION['nb_demande'] ?? '';
$max = 81;
$titre = 'Réviser les tables';
?>

<?php include 'header.php'; ?>
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

		<h1>Réviser les tables</h1>

		<form name="infos" action="tables.php" method="post">
			<p class="champ">
				<label for="prenom">Comment t'appelles-tu ?</label>
				<input class="ligne" type="text" id="prenom" name="prenom" autocomplete="given-name" value="<?php echo h($prenom); ?>" />
			</p>
			<fieldset class="champ">
				<legend>Que veux-tu réviser ?</legend>
				<div class="choix-liste">
					<label class="choix">
						<input type="radio" name="type" value="addition" <?php echo $type == 'addition' ? 'checked' : ''; ?> />
						<span class="choix-corps"><span class="choix-signe" aria-hidden="true">+</span>Des additions</span>
					</label>
					<label class="choix">
						<input type="radio" name="type" value="multiplication" <?php echo $type == 'multiplication' ? 'checked' : ''; ?> />
						<span class="choix-corps"><span class="choix-signe" aria-hidden="true">×</span>Des multiplications</span>
					</label>
				</div>
			</fieldset>
			<p class="champ">
				<label for="nb">Combien d'opérations veux-tu faire ?</label>
				<input class="nombre" type="text" id="nb" name="nb" inputmode="numeric" aria-describedby="aide-nb" value="<?php echo h($nb); ?>" />
				<span class="aide" id="aide-nb">Laisse vide pour faire toutes les tables (<?php echo $max; ?> opérations).</span>
			</p>
			<button class="bouton" type="submit" onclick="return verif();">Commencer</button>
		</form>

<?php include 'footer.php'; ?>
