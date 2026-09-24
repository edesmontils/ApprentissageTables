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
- `fonctions.php` : fonctions utilitaires (échappement, redirection…)
- `header.php`, `footer.php`, `sidebar.php`, `default.css`, `images/` : mise en page (modèle « DesertSand » de Free CSS Templates)
