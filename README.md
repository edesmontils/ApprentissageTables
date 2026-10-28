# ApprentissageTables

Apprentissage des tables pour les enfants : un petit site PHP qui fait réviser les tables d'addition et de multiplication (de 1 à 9) aux élèves de primaire.

## Utilisation

Aucune dépendance ni base de données : il suffit d'un PHP ≥ 7.0 avec les sessions.

```sh
php -S localhost:8000
```

puis ouvrir <http://localhost:8000>.

## Fichiers

- `index.php` : page d'accueil
- `tables_init.php` : choix du prénom, du type d'opération et du nombre d'opérations
- `tables.php` : le questionnaire, la correction et la note finale
- `fonctions.php` : fonctions utilitaires (échappement, redirection…) et `entete_html()`, qui annonce l'encodage UTF-8 : chaque page HTML doit l'appeler avant tout affichage
- `header.php`, `footer.php`, `default.css`, `polices/` : mise en page, sur le thème d'une page de cahier Seyès (encre bleue pour l'élève, stylo rouge pour la correction)
- `polices/` : Andika et Playpen Sans, sous licence SIL OFL, hébergées avec le site
- `sidebar.php` : barre latérale, pas utilisée pour l'instant
