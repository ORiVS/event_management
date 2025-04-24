
# Event Management API

Ce projet est une API Laravel 11 pour la gestion d'événements, de réservations de tickets, de notifications et de génération de tickets PDF avec QR code intégré.

## Fonctionnalités

### Gestion des événements
- Création, mise à jour, suppression d'événements
- Attribution automatique de l'utilisateur connecté comme organisateur
- Liste publique des événements

### Gestion des tickets
- Réservation de ticket avec contrôle de capacité
- Génération d'un code de ticket unique
- Téléchargement du ticket en PDF avec :
  - Infos invité
  - Infos réservant (utilisateur connecté)
  - Détails de l'événement
  - QR code intégré

### Notifications
- Notification automatique à l’organisateur lors d’une réservation
- Consultation des notifications
- Marquage de notification comme envoyée

### Authentification
- Inscription et connexion via API (Sanctum)
- Gestion des accès sécurisés aux routes

## Stack technique
- Laravel 11
- Sanctum pour l'authentification API
- domPDF pour la génération de PDF
- BaconQrCode (SVG) pour l’intégration de QR codes
- PostgreSQL (ou autre base compatible Laravel)

## Routes principales

### Auth
- `POST /api/register` – Inscription
- `POST /api/login` – Connexion

### Événements
- `GET /api/events` – Liste des événements
- `POST /api/events` – Créer un événement
- `PUT /api/events/{id}` – Modifier un événement
- `DELETE /api/events/{id}` – Supprimer un événement

### Tickets
- `POST /api/events/{id}/tickets` – Réserver un ticket
- `GET /api/tickets/{id}/download` – Télécharger un ticket en PDF

### Notifications
- `GET /api/notifications` – Liste des notifications
- `POST /api/notifications/{id}/mark-sent` – Marquer une notification comme envoyée

## Démarrage rapide

1. Cloner le projet
2. Installer les dépendances :
    ```bash
    composer install
    ```
3. Configurer le fichier `.env` et la base de données
4. Lancer les migrations :
    ```bash
    php artisan migrate
    ```
5. Lancer le serveur :
    ```bash
    php artisan serve
    ```
6. Importer le fichier Postman inclus pour tester les endpoints


---

Développé par Orias DOGBEVI – 2025
