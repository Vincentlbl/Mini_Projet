# Mini_Projet

Projet : Livre d'or en PHP procédural
Description
Livre d'or développé en PHP procédural permettant aux utilisateurs de s'inscrire, se connecter et laisser des messages associés à leur compte. Les messages sont visibles par tous les utilisateurs dans l'ordre chronologique inverse. La sécurité est assurée via des mots de passe hachés et des requêtes préparées avec PDO.

Objectifs pédagogiques
Appliquer les bases du PHP procédural.
Utiliser PDO pour interagir avec une base de données MySQL.
Gérer les sessions PHP.
Valider et sécuriser les données utilisateurs.
Fonctionnalités
Inscription : Création de compte avec validation des champs et hachage du mot de passe.
Connexion : Authentification via nom d'utilisateur et mot de passe.
Soumission de messages : Envoi de messages après connexion, validation des messages non vides.
Affichage : Liste des messages avec nom d'utilisateur, affichés dans l'ordre inverse de leur soumission.
Déconnexion : Fin de session utilisateur.