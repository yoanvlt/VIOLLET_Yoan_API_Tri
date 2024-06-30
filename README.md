# VIOLLET_Yoan_API_Tri

## Aperçu du Projet

VIOLLET_Yoan_API_Tri est une API RESTful conçue pour gérer les opérations CRUD sur une base de données utilisateur. Ce projet a été réalisé dans le cadre d'un devoir scolaire.

## Objectif

L'objectif principal de cette API est de fournir un accès simplifié et sécurisé aux opérations de base de données.

## Installation

git clone https://github.com/yoanvlt/VIOLLET_Yoan_API_Tri.git

## Configuration

Avant de lancer l'API, assurez-vous de télécharger la base de données et les informations d'authentification :
Mettre le mot de passe ainsi que le nom d'utilisateur pour la base de données dans un fichier json qui se trouve dans le dossier mot de passe au même niveau que le dossier www.

## Requêtes d'Exemple

Signup : http://localhost/VIOLLET_Yoan_API_Tri/api/public/index.php?method=signup&json={"username":"newuser","password":"NewPass123!","email":"newuser@example.com"}

Signin = http://localhost/VIOLLET_Yoan_API_Tri/api/public/index.php?method=signin&json={"username":"newuser","password":"NewPass123!"}

Delete = localhost/VIOLLET_Yoan_API_Tri/api/public/index2.php?method=delete&json={"id_utilisateur":x}

Change Password = http://localhost/VIOLLET_Yoan_API_Tri/api/public/index.php?method=changepwd&json={"username":"newuser","old_password":"OldPass123!","new_password":"NewPass123!"}

Check Signed In Status = http://localhost/VIOLLET_Yoan_API_Tri/api/public/index.php?method=signedin
