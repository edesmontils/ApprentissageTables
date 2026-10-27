<?php
session_start();
require 'fonctions.php';
$max = 10;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prenom'])) {
	// Nouvelle partie
	$prenom = trim($_POST['prenom']);
	$type = ($_POST['type'] ?? '') == 'multiplication' ? 'multiplication' : 'addition';
	$nb = trim($_POST['nb'] ?? '');
	if ($prenom == '') redirige('tables_init.php');

	$t = array();
	for ($i = 1; $i < $max; $i++)
		for ($j = 1; $j < $max; $j++) $t[] = array($i, $j);
	shuffle($t);

	$_SESSION['prenom'] = $prenom;
	$_SESSION['type'] = $type;
	$_SESSION['nb_demande'] = $nb;
	$_SESSION['nb'] = (ctype_digit($nb) && $nb >= 1) ? min((int)$nb, count($t)) : count($t);
	$_SESSION['t'] = $t;
	$_SESSION['i'] = 0;
	$_SESSION['ok'] = 0;
	$_SESSION['ko'] = 0;
	$_SESSION['out'] = 0;
	$_SESSION['histo'] = array();
	$_SESSION['message'] = 'C\'est parti !';
	$_SESSION['verdict'] = 'debut';
	redirige('tables.php');
}

if (!isset($_SESSION['t'])) redirige('tables_init.php');

$type = $_SESSION['type'];
$prenom = $_SESSION['prenom'];
$nb = $_SESSION['nb'];
$t = $_SESSION['t'];
$i = $_SESSION['i'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['q'])) {
	// Réponse à l'opération n° q (ignorée si elle a déjà été traitée)
	if ((int)$_POST['q'] === $i && $i < $nb) {
		list($x, $y) = $t[$i];
		$s = ($type == 'addition') ? $x + $y : $x * $y;
		$op = $x.' '.signe($type).' '.$y.' = '.$s;
		$rep = trim($_POST['rep'] ?? '');
		if ($rep == '') {
			$_SESSION['out']++;
			$_SESSION['verdict'] = 'out';
			$_SESSION['message'] = 'Pas de réponse ? Rappelle-toi : '.$op.' !';
			$_SESSION['histo'][] = array($x, $y, $s);
		} else if (ctype_digit($rep) && (int)$rep === $s) {
			$_SESSION['ok']++;
			$_SESSION['verdict'] = 'ok';
			$_SESSION['message'] = $op.'. Bien '.$prenom.' !';
		} else {
			$_SESSION['ko']++;
			$_SESSION['verdict'] = 'ko';
			$_SESSION['message'] = 'Non ! Rappelle-toi : '.$op.' (tu as répondu '.$rep.')';
			$_SESSION['histo'][] = array($x, $y, $s);
		}
		$_SESSION['i'] = $i + 1;
	}
	redirige('tables.php');
}

$fin = ($i >= $nb);
$message = $_SESSION['message'] ?? '';
$verdict = $_SESSION['verdict'] ?? 'debut';
$titre = $fin ? 'Résultats' : 'Opération '.($i + 1).' sur '.$nb;
?>

<?php include 'header.php'; ?>
<?php
if ($fin) {
	$note = round($_SESSION['ok'] * 20 / $nb);
	if ($note >= 18) $appreciation = 'Parfait !';
	else if ($note >= 16) $appreciation = 'Très bien !';
	else if ($note >= 15) $appreciation = 'Bien !';
	else if ($note >= 14) $appreciation = 'Assez bien.';
	else if ($note >= 12) $appreciation = 'Bon.';
	else if ($note >= 10) $appreciation = 'Trop juste '.$prenom.' !';
	else $appreciation = 'Il faut revoir tes tables '.$prenom.' !';
?>
		<h1>C'est terminé <?php echo h($prenom); ?> !</h1>
		<p class="remarque remarque-<?php echo h($verdict); ?>"><?php echo h($message); ?></p>

		<h2>Voici les résultats</h2>
		<dl class="comptes">
			<dt>Bonnes réponses</dt><dd><?php echo $_SESSION['ok']; ?></dd>
			<dt>Mauvaises réponses</dt><dd><?php echo $_SESSION['ko']; ?></dd>
			<dt>Absence de réponse</dt><dd><?php echo $_SESSION['out']; ?></dd>
		</dl>

		<p class="note">
			<svg class="cercle" viewBox="0 0 220 120" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M26 64 C 14 24, 100 6, 186 22 C 232 34, 216 100, 120 110 C 48 116, 6 92, 30 40" /></svg>
			<span class="note-chiffre"><?php echo $note; ?></span><span class="note-sur">/ 20</span>
		</p>
		<p class="appreciation"><?php echo h($appreciation); ?></p>
<?php if (count($_SESSION['histo'])) { ?>
		<h2>Et souviens-toi :</h2>
		<ul class="rappel">
<?php foreach ($_SESSION['histo'] as $pb) { ?>
			<li><?php echo $pb[0].' '.signe($type).' '.$pb[1].' = '.$pb[2]; ?></li>
<?php } ?>
		</ul>
<?php } ?>
		<p><a class="bouton" href="tables_init.php">Recommencer</a></p>
<?php } else {
	list($x, $y) = $t[$i];
?>
<script>
window.onload = function () {
	document.saisie.rep.focus();
};
function verif() {
	if (/^\d+$/.test(document.saisie.rep.value)) return true;
	alert('Attention ' + <?php echo js($prenom); ?> + ', il faut entrer un nombre !');
	document.saisie.rep.focus();
	return false;
}
</script>
		<p class="remarque remarque-<?php echo h($verdict); ?>"><?php echo h($message); ?></p>
		<form name="saisie" action="tables.php" method="post">
			<p class="compteur">Opération <?php echo ($i + 1); ?> sur <?php echo $nb; ?></p>
			<progress max="<?php echo $nb; ?>" value="<?php echo $i; ?>" aria-label="Avancement"><?php echo $i; ?> sur <?php echo $nb; ?></progress>
			<div class="operation">
				<label for="rep"><?php echo $x.' '.signe($type).' '.$y.' ='; ?></label>
				<input class="reponse" type="text" name="rep" id="rep" inputmode="numeric" autocomplete="off" />
			</div>
			<input type="hidden" name="q" value="<?php echo $i; ?>" />
			<button class="bouton" type="submit" onclick="return verif();">Proposer</button>
		</form>
<?php } ?>
<?php include 'footer.php'; ?>
