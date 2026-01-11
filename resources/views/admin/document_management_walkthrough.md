# Gestion des Types de Documents 📄

L'administrateur a désormais le contrôle total sur les documents disponibles pour les étudiants.

## Fonctionnalités Admin
- **Liste des Documents** : Vue d'ensemble de tous les documents (actifs et désactivés).
- **Création / Modification** : Formulaires dédiés pour définir le nom et la description.
- **Activation / Désactivation** : Bouton rapide pour masquer un document aux étudiants sans le supprimer.
- **Sécurité** : Suppression empêchée si le document est déjà lié à des demandes existantes.

## Interface Étudiant
- **Filtrage Dynamique** : Seuls les documents marqués comme "Actifs" apparaissent dans le menu déroulant lors d'une nouvelle demande.
- **Validation Backend** : Sécurité renforcée qui empêche la soumission d'une demande pour un document désactivé, même via manipulation de l'inspecteur d'éléments.

## Captures d'écran & Navigation
- **Nouvelle page de gestion** : [admin/document-types](file:///c:/wamp64/www/gestion-document/resources/views/admin/document_types/index.blade.php)
- **Mise à jour du Dashboard** : Le lien "Documents" est ajouté à la barre de navigation.
