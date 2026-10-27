<?php
require 'fonctions.php';
$titre = 'Accueil';
$a = random_int(2, 9);
$b = random_int(2, 9);
include 'header.php';
?>
		<p class="calcul-geant" aria-hidden="true"><?php echo $a.' × '.$b.' = '.($a * $b); ?></p>
		<h1>Bienvenue !</h1>
		<p class="chapeau">Des petits outils pour réviser à ton rythme. Pour l'instant, tu peux t'entraîner sur les additions et les multiplications de 1 à 9.</p>
		<p><a class="bouton" href="tables_init.php">Réviser mes tables</a></p>
<?php include 'footer.php'; ?>
