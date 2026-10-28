<?php
// $titre (facultatif) : titre de la page, avant le nom du site.
$nomSite = 'Boîte à outils pour le primaire';
$page = basename($_SERVER['SCRIPT_NAME']);
$outil = in_array($page, array('tables_init.php', 'tables.php'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo isset($titre) ? h($titre).' – ' : ''; echo h($nomSite); ?></title>
<meta name="description" content="Petits outils de révision pour les enfants de primaire" />
<link rel="preload" href="polices/PlaypenSans.woff2" as="font" type="font/woff2" crossorigin />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="cahier">
	<header id="header">
		<p id="logo">
			<a href="index.php"><?php echo h($nomSite); ?></a>
			<small>par E. Desmontils</small>
		</p>
		<nav id="menu" aria-label="Navigation principale">
			<ul>
				<li><a href="index.php" accesskey="1"<?php echo $page == 'index.php' ? ' aria-current="page"' : ''; ?>>Accueil</a></li>
				<li><a href="tables_init.php" accesskey="2"<?php echo $outil ? ' aria-current="page"' : ''; ?>>Additions et multiplications</a></li>
			</ul>
		</nav>
	</header>
	<main id="content">
