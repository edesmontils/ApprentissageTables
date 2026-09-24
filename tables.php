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
			$_SESSION['message'] = 'Pas de réponse ? Rappelle-toi : '.$op.' !';
			$_SESSION['histo'][] = array($x, $y, $s);
		} else if (ctype_digit($rep) && (int)$rep === $s) {
			$_SESSION['ok']++;
			$_SESSION['message'] = $op.'. Bien '.$prenom.' !';
		} else {
			$_SESSION['ko']++;
			$_SESSION['message'] = 'Non ! Rappelle-toi : '.$op.' (tu as répondu '.$rep.')';
			$_SESSION['histo'][] = array($x, $y, $s);
		}
		$_SESSION['i'] = $i + 1;
	}
	redirige('tables.php');
}

$fin = ($i >= $nb);
$message = $_SESSION['message'] ?? '';
?>

<?php include 'header.php'; ?>
			<div id="splash">
				<div class="top"><img src="images/Math.png" alt="" width="460" height="180" /></div>
				<div class="bottom"></div>
			</div>
			<div id="samples">

<?php
if ($fin) {
	echo '<p>'.h($message).'</p>';
	echo '<p>C\'est terminé '.h($prenom).' !</p> <p>Voici les résultats :</p>';
	echo '<p>Bonnes réponses : '.$_SESSION['ok'].'<br />';
	echo 'Mauvaises réponses : '.$_SESSION['ko'].'<br />';
	echo 'Absence de réponse : '.$_SESSION['out'].'</p>';
	$note = round($_SESSION['ok'] * 20 / $nb);
	echo '<p>Note : '.$note.' / 20 - ';
	if ($note >= 18) echo 'Parfait !';
	else if ($note >= 16) echo 'Très bien !';
	else if ($note >= 15) echo 'Bien !';
	else if ($note >= 14) echo 'Assez bien.';
	else if ($note >= 12) echo 'Bon.';
	else if ($note >= 10) echo 'Trop juste '.h($prenom).' !';
	else echo 'Il faut revoir tes tables '.h($prenom).' !';
	echo '</p>';
	if (count($_SESSION['histo'])) {
		echo '<p>Et souviens-toi :</p><ul>';
		foreach ($_SESSION['histo'] as $pb) {
			echo '<li>'.$pb[0].' '.signe($type).' '.$pb[1].' = '.$pb[2].'</li>';
		}
		echo '</ul>';
	}
	echo '<p><a href="tables_init.php">Recommencer</a></p>';
} else {
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
	<p><?php echo h($message); ?></p>
	<form name="saisie" action="tables.php" method="post">
		<p>Opération <?php echo ($i + 1).' (sur '.$nb.')'; ?> :<br /> <?php echo $x.' '.signe($type).' '.$y; ?> = <input type="text" name="rep" id="rep" inputmode="numeric" autocomplete="off" /></p>
		<input type="hidden" name="q" value="<?php echo $i; ?>" />
		<input type="submit" value="Proposer" onclick="return verif();" />
	</form>
<?php } ?>

			</div>
<?php include 'footer.php'; ?>
