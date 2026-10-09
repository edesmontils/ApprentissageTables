<?php
// Échappe une valeur pour l'afficher dans du HTML.
function h($s) {
	return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Échappe une valeur pour l'insérer dans du JavaScript (chaîne entre guillemets comprise).
function js($s) {
	return json_encode((string)$s, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}

// Symbole de l'opération.
function signe($type) {
	return $type == 'addition' ? '+' : '×';
}

function redirige($page) {
	header('Location: '.$page, true, 303);
	exit;
}
