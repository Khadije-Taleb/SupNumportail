<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\CertificatMedicalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('acceuil');
});

// Generic dashboard route - redirects based on role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (strtolower(Auth::user()->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('etudiant.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Etudiant
Route::middleware(['auth', 'role:ETUDIANT'])->prefix('etudiant')->as('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantController::class, 'index'])->name('dashboard');
    
    // Demandes
    Route::get('/nouvelle-demande', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/mes-demandes', [DemandeController::class, 'index'])->name('demandes.index');
    
    // Certificats
    Route::get('/certificat-medical', [CertificatMedicalController::class, 'create'])->name('certificats.create');
    Route::post('/certificats', [CertificatMedicalController::class, 'store'])->name('certificats.store');
    Route::get('/historique-certificats', [CertificatMedicalController::class, 'index'])->name('certificats.index');
    
    // Notifications
    Route::get('/notifications', [EtudiantController::class, 'notifications'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    
    // Profil
    Route::get('/profil', [EtudiantController::class, 'profil'])->name('profil');
});

// Routes Admin
Route::middleware(['auth', 'role:ADMIN'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Manage Demandes
    Route::get('/demandes/{demande}', [DemandeController::class, 'adminShow'])->name('demandes.show');
    Route::put('/demandes/{demande}/statut', [DemandeController::class, 'updateStatus'])->name('demandes.updateStatus');

    // Manage Certificats
    Route::get('/certificats', [CertificatMedicalController::class, 'adminIndex'])->name('certificats.index');
    Route::get('/certificats/{certificat}', [CertificatMedicalController::class, 'adminShow'])->name('certificats.show');
    Route::get('/certificats/{certificat}/fichier', [CertificatMedicalController::class, 'adminViewFile'])->name('certificats.viewFile');
    Route::put('/certificats/{certificat}/statut', [CertificatMedicalController::class, 'adminUpdateStatus'])->name('certificats.updateStatus');

    // Import Students
    Route::get('/importer-etudiants', [AdminController::class, 'showImportForm'])->name('import');
    Route::post('/importer-etudiants', [AdminController::class, 'importStudents'])->name('import.store');
    
});

// Initial Password Change (Force Change) - Accessible to all roles
Route::middleware('auth')->group(function () {
    Route::get('/changer-mot-de-passe', [\App\Http\Controllers\Auth\InitialPasswordController::class, 'create'])->name('password.change');
    Route::put('/changer-mot-de-passe', [\App\Http\Controllers\Auth\InitialPasswordController::class, 'store'])->name('password.update_initial');
});

require __DIR__.'/auth.php';
