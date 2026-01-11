<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\CertificatMedicalController;
use App\Http\Controllers\NotificationController;
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

    // Notifications (mark-all-read must come before parameterized route)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Profil
    Route::get('/profil', [EtudiantController::class, 'profil'])->name('profil');
});

// Routes Admin
Route::middleware(['auth', 'role:ADMIN'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manage Demandes
    Route::get('/demandes', [App\Http\Controllers\Admin\DemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/{demande}', [App\Http\Controllers\Admin\DemandeController::class, 'show'])->name('demandes.show');
    Route::put('/demandes/{demande}/statut', [App\Http\Controllers\Admin\DemandeController::class, 'updateStatus'])->name('demandes.updateStatus');

    // Notifications (mark-all-read must come before parameterized route)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Manage Certificats
    Route::get('/certificats', [CertificatMedicalController::class, 'adminIndex'])->name('certificats.index');
    Route::get('/certificats/{certificat}', [CertificatMedicalController::class, 'adminShow'])->name('certificats.show');
    Route::get('/certificats/{certificat}/fichier', [CertificatMedicalController::class, 'adminViewFile'])->name('certificats.viewFile');
    Route::put('/certificats/{certificat}/statut', [CertificatMedicalController::class, 'adminUpdateStatus'])->name('certificats.updateStatus');



    // Import Students
    Route::get('/etudiants/import', [App\Http\Controllers\Admin\EtudiantImportController::class, 'showImportForm'])->name('etudiants.import');
    Route::get('/etudiants/import/template', [\App\Http\Controllers\Admin\EtudiantImportController::class, 'downloadTemplate'])->name('etudiants.template');
    Route::post('/etudiants/import', [\App\Http\Controllers\Admin\EtudiantImportController::class, 'import'])->name('etudiants.import.store');

});

// Initial Password Change (Force Change) - Accessible to all roles
Route::middleware('auth')->group(function () {
    Route::get('/changer-mot-de-passe', [\App\Http\Controllers\Auth\InitialPasswordController::class, 'create'])->name('password.change');
    Route::put('/changer-mot-de-passe', [\App\Http\Controllers\Auth\InitialPasswordController::class, 'store'])->name('password.update_initial');
});

require __DIR__.'/auth.php';
