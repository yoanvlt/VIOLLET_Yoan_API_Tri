# VIOLLET_Yoan_API_Tri

## Aperçu du Projet

VIOLLET_Yoan_API_Tri est une API RESTful conçue pour gérer les opérations CRUD sur une base de données utilisateur. Ce projet a été réalisé dans le cadre d'un devoir scolaire.

## Objectif

L'objectif principal de cette API est de fournir un accès simplifié et sécurisé aux opérations de base de données, sans implémenter de fonctionnalités avancées telles que les jointures SQL, les clauses ORDER BY ou GROUP BY, ou le stockage de données volumineuses.

## Installation

git clone https://github.com/yoanvlt/VIOLLET_Yoan_API_Tri.git

## Configuration

Avant de lancer l'API, assurez-vous de télécharger la base de données et les informations d'authentification :

Voici des pré requêtes d'exemple :

Insert = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=insert&json={"email":"example@mail","nom":"example","mot_de_passe":"motdepasse1234"}

Update = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=update&json={"id_utilisateur":x,"email":"example@mail","nom":"example_updated","mot_de_passe":"motdepasse1234"}

Delete = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=delete&json={"id_utilisateur":x}

Display = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=display

Display = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=display&id=7
