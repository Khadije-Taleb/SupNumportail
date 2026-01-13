# Documentation Complète du Projet - SupNumPortail

## 📋 Vue d'ensemble

**SupNumPortail** est une application web de gestion documentaire académique développée avec **Laravel 11** et **PHP 8.2**. Elle permet aux étudiants de soumettre des demandes de documents administratifs et des certificats médicaux, et aux administrateurs de les traiter.

---

## 🏗️ Architecture et Structure du Projet

### Structure des Dossiers

```
gestion-document/
├── app/                          # Code applicatif principal
│   ├── Http/
│   │   ├── Controllers/         # Contrôleurs (logique métier)
│   │   ├── Middleware/          # Middlewares (authentification, rôles)
│   │   └── Requests/            # Form Requests (validation)
│   ├── Models/                  # Modèles Eloquent (ORM)
│   ├── Imports/                 # Classes d'import Excel
│   └── Providers/               # Service Providers
├── bootstrap/                    # Fichiers de démarrage Laravel
├── config/                       # Fichiers de configuration
├── database/
│   ├── migrations/              # Migrations de base de données
│   └── seeders/                 # Seeders pour données initiales
├── public/                       # Point d'entrée public (assets, images)
├── resources/
│   ├── views/                   # Vues Blade (templates)
│   ├── css/                     # Styles CSS
│   └── js/                      # JavaScript
├── routes/                       # Définition des routes
├── storage/                      # Fichiers uploadés, logs, cache
└── tests/                       # Tests unitaires et fonctionnels
```

---

## 🛠️ Technologies et Bibliothèques

### Backend (PHP/Laravel)

1. **Laravel Framework 11.0**
   - Framework PHP MVC
   - ORM Eloquent pour la base de données
   - Système de routing
   - Middleware pour l'authentification et autorisation

2. **Maatwebsite Excel 3.1** (`maatwebsite/excel`)
   - Import/Export de fichiers Excel
   - Utilisé pour l'importation en masse d'étudiants
   - Classes: `EtudiantsImport`, `UsersImport`

3. **Laravel Breeze 2.3** (dev)
   - Système d'authentification pré-configuré
   - Gestion des sessions utilisateur

### Frontend

1. **Tailwind CSS 3.1.0**
   - Framework CSS utility-first
   - Configuration dans `tailwind.config.js`
   - Plugin `@tailwindcss/forms` pour les formulaires

2. **Alpine.js 3.4.2**
   - Framework JavaScript léger
   - Utilisé pour les interactions dynamiques (menus déroulants, etc.)

3. **Vite 7.0.7**
   - Build tool moderne
   - Compilation des assets CSS/JS
   - Hot Module Replacement (HMR) en développement

4. **Axios 1.11.0**
   - Client HTTP pour requêtes AJAX

---

## 📊 Modèles de Données (Eloquent Models)

### 1. **User** (`app/Models/User.php`)
- **Table**: `utilisateur`
- **Clé primaire**: `id`
- **Relations**:
  - `hasOne(Etudiant)` - Relation avec le profil étudiant
  - `hasOne(Admin)` - Relation avec le profil admin
  - `hasMany(Notification)` - Notifications de l'utilisateur
- **Attributs accesseurs**:
  - `getFullNameAttribute()` - Nom complet (prénom + nom)
  - `getInitialsAttribute()` - Initiales pour avatar
- **Rôles**: `etudiant`, `admin`

### 2. **Etudiant** (`app/Models/Etudiant.php`)
- **Table**: `etudiant`
- **Clé primaire**: `matricule` (string, non auto-incrémenté)
- **Relations**:
  - `belongsTo(User)` - Utilisateur associé
  - `hasMany(Demande)` - Demandes de documents
  - `hasMany(CertificatMedical)` - Certificats médicaux
- **Champs**: matricule, nom, prenom, filiere, annee, email, utilisateur_id

### 3. **Demande** (`app/Models/Demande.php`)
- **Table**: `demande`
- **Statuts**: `en_attente`, `en_cours_traitement`, `acceptee`, `rejetee`, `fin`
- **Relations**:
  - `belongsTo(Etudiant)` - Étudiant demandeur
  - `belongsTo(Document)` - Type de document demandé
  - `belongsTo(Admin)` - Admin qui a traité
- **Champs**: matricule_etudiant, document_id, statut, remarque_admin, admin_id

### 4. **CertificatMedical** (`app/Models/CertificatMedical.php`)
- **Table**: `certificat_medical`
- **Statuts**: `EN_ATTENTE`, `VALIDE`, `REFUSE`, `EN_COURS`
- **Relations**:
  - `belongsTo(Etudiant)` - Étudiant
  - `belongsTo(Admin)` - Admin qui a traité
  - `belongsTo(Evaluation)` - Évaluation associée
- **Champs**: matricule_etudiant, photo_certificat, annee, evaluation_id, date_absence, statut, remarque_admin, admin_id

### 5. **Document** (`app/Models/Document.php`)
- **Table**: `document`
- **Relations**: `hasMany(Demande)`
- **Champs**: nom_document, description, actif (booléen pour activation/désactivation)

### 6. **Evaluation** (`app/Models/Evaluation.php`)
- **Table**: `evaluation`
- **Relations**: `hasMany(CertificatMedical)`
- **Champs**: nom_matiere, type_evaluation
- **Types d'évaluation**: `devoir_ecrit`, `devoir_pratique`, `tp_note`, `examen_final`

### 7. **Notification** (`app/Models/Notification.php`)
- **Table**: `notification`
- **Relations**:
  - `belongsTo(User)` - Utilisateur destinataire
  - `belongsTo(Etudiant)` - Étudiant concerné (optionnel)
- **Champs**: id_utilisateur, role, title, message, type, link, is_read, matricule_etudiant

### 8. **Admin** (`app/Models/Admin.php`)
- **Table**: `admin`
- **Relations**: `belongsTo(User)`

---

## 🎮 Contrôleurs Principaux

### 1. **EtudiantController** (`app/Http/Controllers/EtudiantController.php`)
**Méthodes**:
- `index()` - Dashboard étudiant avec statistiques
- `profil()` - Affichage du profil étudiant

**Fonctionnalités**:
- Affichage des statistiques des demandes (total, en attente, acceptées, rejetées)
- Liste des notifications récentes

### 2. **AdminController** (`app/Http/Controllers/AdminController.php`)
**Méthodes**:
- `index(Request $request)` - Dashboard admin avec filtres
- `showImportForm()` - Formulaire d'import d'étudiants
- `importStudents(Request $request)` - Traitement de l'import

**Fonctionnalités**:
- Statistiques globales (demandes + certificats)
- Filtrage par type (demande/certificat) et statut
- Gestion de l'import Excel d'étudiants

### 3. **DemandeController** (`app/Http/Controllers/DemandeController.php`)
**Méthodes Étudiant**:
- `index()` - Liste des demandes de l'étudiant
- `create()` - Formulaire de nouvelle demande
- `store(Request $request)` - Création d'une demande

**Méthodes Admin**:
- `adminShow(Demande $demande)` - Détails d'une demande
- `updateStatus(Request $request, Demande $demande)` - Mise à jour du statut

**Fonctionnalités**:
- Upload de justificatifs (stockage dans `storage/app/public/justificatifs`)
- Validation des documents actifs
- Notifications automatiques aux admins

### 4. **CertificatMedicalController** (`app/Http/Controllers/CertificatMedicalController.php`)
**Méthodes Étudiant**:
- `index()` - Liste des certificats
- `create()` - Formulaire de dépôt
- `store(Request $request)` - Dépôt d'un certificat

**Méthodes Admin**:
- `adminIndex(Request $request)` - Liste avec filtres (statut, matière, type évaluation)
- `adminShow(CertificatMedical $certificat)` - Détails d'un certificat
- `adminViewFile(CertificatMedical $certificat)` - Affichage du fichier PDF/image
- `adminUpdateStatus(Request $request, CertificatMedical $certificat)` - Validation/Refus

**Fonctionnalités**:
- Upload de fichiers (PDF, JPG, PNG) max 2MB
- Association automatique avec une évaluation (création si n'existe pas)
- Filtrage avancé par matière et type d'évaluation
- Prévisualisation des fichiers

### 5. **NotificationController** (`app/Http/Controllers/NotificationController.php`)
**Méthodes**:
- `index()` - Liste des notifications (filtrées par rôle)
- `markAsRead(Request $request, $notificationId)` - Marquer comme lu
- `markAllRead(Request $request)` - Tout marquer comme lu

**Méthodes statiques**:
- `storeForAdmin($title, $message, $type, $student_matricule, $link)` - Notifier tous les admins
- `storeForStudent($userId, $title, $message, $type, $student_matricule, $link)` - Notifier un étudiant

### 6. **Admin Controllers** (`app/Http/Controllers/Admin/`)

#### **DemandeController**
- Gestion des demandes côté admin
- Mise à jour des statuts

#### **DocumentManagementController**
- CRUD complet des types de documents
- Activation/désactivation (`toggleStatus`)

#### **EtudiantImportController**
- Import en masse d'étudiants via Excel
- Téléchargement de template Excel
- Validation et création des utilisateurs/étudiants

---

## 🔐 Système d'Authentification et Autorisation

### Middleware

1. **RoleMiddleware** (`app/Http/Middleware/RoleMiddleware.php`)
   - Vérifie le rôle de l'utilisateur
   - Utilisation: `middleware('role:ADMIN')` ou `middleware('role:ETUDIANT')`
   - Retourne 403 si le rôle ne correspond pas

2. **AuthenticatedSessionController**
   - Gestion de la connexion/déconnexion
   - Utilise Laravel Breeze

3. **InitialPasswordController**
   - Force le changement de mot de passe à la première connexion
   - Vérifie `premiere_connexion` dans la table `utilisateur`

### Routes Protégées

```php
// Routes étudiant
Route::middleware(['auth', 'role:ETUDIANT'])->prefix('etudiant')

// Routes admin
Route::middleware(['auth', 'role:ADMIN'])->prefix('admin')
```

---

## 📁 Gestion des Fichiers

### Stockage

- **Justificatifs**: `storage/app/public/justificatifs/`
- **Certificats**: `storage/app/public/certificats/`
- **Images publiques**: `public/images/` (logo, hero-students.jpg)

### Configuration

- **Disque**: `public` (défini dans `config/filesystems.php`)
- **Lien symbolique**: `php artisan storage:link` (pour accéder aux fichiers via URL)

### Upload

```php
// Exemple dans DemandeController
$path = $request->file('justificatif')->store('justificatifs', 'public');
```

---

## 🔔 Système de Notifications

### Structure

- **Table**: `notification`
- **Types**: `demande`, `certificat`, etc.
- **Rôles**: `admin`, `student`
- **Champs**: title, message, type, link, is_read

### Création de Notifications

```php
// Notifier tous les admins
NotificationController::storeForAdmin(
    "Titre",
    "Message",
    "type",
    "matricule",
    route('admin.demandes.show', $id)
);

// Notifier un étudiant
NotificationController::storeForStudent(
    $userId,
    "Titre",
    "Message",
    "type",
    "matricule",
    route('etudiant.demandes.index')
);
```

---

## 📥 Import Excel (Maatwebsite Excel)

### Classe: `EtudiantsImport` (`app/Imports/EtudiantsImport.php`)

**Interface**: `ToCollection`, `WithHeadingRow`

**Processus**:
1. Lit le fichier Excel ligne par ligne
2. Vérifie l'existence du matricule/email
3. Crée un `User` avec rôle `etudiant`
4. Crée un `Etudiant` lié au `User`
5. Compte les imports réussis/échoués

**Colonnes attendues**:
- matricule
- email
- password
- nom
- prenom
- annee
- filiere

---

## 🎨 Frontend et Vues

### Layouts

1. **`layouts/admin.blade.php`**
   - Layout pour les pages admin
   - Header avec navigation
   - Footer

2. **`layouts/student.blade.php`**
   - Layout pour les pages étudiant
   - Header avec logo et navigation
   - Zone de notifications

3. **`layouts/navigation.blade.php`**
   - Navigation partagée (Laravel Breeze)
   - Responsive avec menu hamburger

4. **`layouts/app.blade.php`**
   - Layout de base Laravel
   - Utilise Vite pour les assets

### Vues Principales

**Étudiant**:
- `etudiant/dashboard.blade.php` - Tableau de bord
- `etudiant/nouvelle_demande.blade.php` - Formulaire de demande
- `etudiant/mes_demandes.blade.php` - Liste des demandes
- `etudiant/certificat_medical.blade.php` - Gestion des certificats
- `etudiant/profil.blade.php` - Profil étudiant
- `etudiant/notifications.blade.php` - Notifications

**Admin**:
- `admin/dashboard.blade.php` - Tableau de bord admin
- `admin/demandes/index.blade.php` - Liste des demandes
- `admin/demandes/show.blade.php` - Détails d'une demande
- `admin/certificats/index.blade.php` - Gestion des certificats
- `admin/document-types/index.blade.php` - Gestion des types de documents
- `admin/etudiants/import.blade.php` - Import d'étudiants

**Authentification**:
- `auth/login.blade.php` - Page de connexion
- `acceuil.blade.php` - Page d'accueil publique

---

## 🗄️ Base de Données

### Tables Principales

1. **utilisateur**
   - id, email, password, role, premiere_connexion

2. **etudiant**
   - matricule (PK), nom, prenom, filiere, annee, email, utilisateur_id

3. **admin**
   - id_admin, nom, prenom, utilisateur_id

4. **demande**
   - id, matricule_etudiant, document_id, statut, remarque_admin, admin_id, created_at, updated_at

5. **certificat_medical**
   - id, matricule_etudiant, photo_certificat, annee, evaluation_id, date_absence, statut, remarque_admin, admin_id, created_at

6. **document**
   - id, nom_document, description, actif

7. **evaluation**
   - id, nom_matiere, type_evaluation

8. **notification**
   - id, id_utilisateur, role, title, message, type, link, is_read, matricule_etudiant, created_at

### Migrations

Les migrations sont dans `database/migrations/`:
- Création des tables
- Ajout de colonnes
- Modification des enums
- Refactoring de structure

---

## 🔄 Workflows Principaux

### 1. Workflow de Demande de Document

1. **Étudiant** crée une demande via `DemandeController@store`
2. Upload du justificatif (optionnel)
3. Création de la demande avec statut `en_attente`
4. Notification envoyée à tous les admins
5. **Admin** consulte la demande via `admin/demandes/show`
6. **Admin** met à jour le statut (acceptée/rejetée)
7. Notification envoyée à l'étudiant

### 2. Workflow de Certificat Médical

1. **Étudiant** dépose un certificat via `CertificatMedicalController@store`
2. Sélection de l'année, matière, type d'évaluation, date
3. Upload du fichier (PDF/image)
4. Création ou récupération de l'évaluation
5. Création du certificat avec statut `EN_ATTENTE`
6. Notification aux admins
7. **Admin** consulte via `admin/certificats/index`
8. Filtrage par statut, matière, type
9. **Admin** valide ou refuse avec remarque
10. Notification à l'étudiant

### 3. Workflow d'Import d'Étudiants

1. **Admin** télécharge le template Excel
2. Remplit le fichier avec les données
3. Upload via `EtudiantImportController@import`
4. `EtudiantsImport` traite chaque ligne
5. Création des utilisateurs et étudiants
6. Retour avec statistiques (importés/sautés)

---

## 🎯 Fonctions et Helpers Utiles

### Accesseurs Eloquent

```php
// User Model
$user->full_name  // Prénom + Nom
$user->initials   // Initiales pour avatar

// Relations
$user->etudiant   // Profil étudiant
$user->admin      // Profil admin
$user->notifications() // Notifications
```

### Helpers de Notification

```php
NotificationController::storeForAdmin(...)
NotificationController::storeForStudent(...)
```

### Validation des Rôles

```php
Auth::user()->role === 'admin'
Auth::user()->role === 'etudiant'
```

### Stockage de Fichiers

```php
$path = $request->file('fichier')->store('dossier', 'public');
Storage::disk('public')->exists($path);
Storage::disk('public')->url($path);
```

---

## 🚀 Commandes Artisan Utiles

```bash
# Migrations
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed

# Lien symbolique pour storage
php artisan storage:link

# Cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Génération de clé
php artisan key:generate
```

---

## 📦 Dépendances NPM

```json
{
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.2",
    "@tailwindcss/vite": "^4.0.0",
    "alpinejs": "^3.4.2",
    "autoprefixer": "^10.4.2",
    "axios": "^1.11.0",
    "concurrently": "^9.0.1",
    "laravel-vite-plugin": "^2.0.0",
    "postcss": "^8.4.31",
    "tailwindcss": "^3.1.0",
    "vite": "^7.0.7"
  }
}
```

---

## 🔧 Configuration Importante

### Fichiers de Config

- `config/app.php` - Configuration générale
- `config/database.php` - Base de données
- `config/filesystems.php` - Système de fichiers
- `config/auth.php` - Authentification

### Variables d'Environnement (.env)

```env
APP_NAME=SupNumPortail
APP_ENV=local
APP_KEY=
DB_CONNECTION=sqlite (ou mysql)
DB_DATABASE=gestion-document
```

---

## 🧪 Tests

- **Tests Feature**: `tests/Feature/`
- **Tests Unit**: `tests/Unit/`
- **Framework**: PHPUnit 11.5.3

---

## 📝 Points Importants à Retenir

1. **Rôles**: Le système utilise deux rôles principaux: `etudiant` et `admin`
2. **Statuts Demandes**: `en_attente`, `en_cours_traitement`, `acceptee`, `rejetee`, `fin`
3. **Statuts Certificats**: `EN_ATTENTE`, `VALIDE`, `REFUSE`, `EN_COURS`
4. **Clé Primaire Étudiant**: `matricule` (string, non auto-incrémenté)
5. **Timestamps**: Certaines tables n'ont pas de `updated_at` (ex: `certificat_medical`)
6. **Notifications**: Système bidirectionnel (admin ↔ étudiant)
7. **Upload**: Tous les fichiers sont stockés dans `storage/app/public/`
8. **Import Excel**: Utilise Maatwebsite Excel avec validation

---

## 🎓 Conventions de Code

- **Nommage**: PascalCase pour les classes, camelCase pour les méthodes
- **Routes**: Utilisation de `route()` helper pour les URLs nommées
- **Validation**: Form Requests ou validation dans les contrôleurs
- **Relations Eloquent**: Définies dans les modèles
- **Vues**: Utilisation de Blade avec `@extends`, `@section`, `@yield`

---

Cette documentation couvre l'essentiel du projet. Pour toute question spécifique, référez-vous aux fichiers source correspondants.
