<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur SupNumPortail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #F0F4FF 0%, #E0E7FF 100%);
        }
        
        /* Fade-in animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        /* Apply animations */
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        
        
        /* Initial state for animated elements - set to 0 before animation */
        .animate-fadeInUp,
        .animate-slideInLeft,
        .animate-fadeIn {
            opacity: 0;
        }
        
        /* Hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .icon-float:hover {
            animation: float 2s ease-in-out infinite;
        }
        
        /* Remove pulse animation on hover to prevent conflict with fadeInUp */
        .btn-pulse {
            /* Pulse animation removed to prevent visibility issues */
        }

        
        /* Smooth transitions for specific elements only */
        a, button {
            transition: color 0.3s ease, background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 animate-fadeIn">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="bg-blue-600 p-1.5 rounded">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold">
                    <span class="text-green-600">SupNum</span><span class="text-blue-700">Portail</span>
                </span>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-700">
                <a href="#" class="hover:text-blue-600 transition-colors">Accueil</a>
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-green-600 active:bg-green-600 text-white px-5 py-2 rounded-lg transition-colors">Connexion</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-bg py-16 md:py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight mb-6 animate-fadeInUp delay-100">
                        Simplifiez vos démarches<br>académiques avec<br>
                        <span class="text-green-600">SupNumPortail</span>.
                    </h1>
                    <p class="text-base md:text-lg text-gray-600 mb-8 animate-fadeInUp delay-200">
                        La plateforme centralisée pour vos demandes administratives, le dépôt de certificats médicaux et le suivi de votre dossier étudiant à l'Institut SupNum.
                    </p>
                    <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-green-600 active:bg-green-600 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all hover:shadow-xl animate-fadeInUp delay-300 btn-pulse">
                        Accéder au portail
                    </a>
                </div>
                
                <!-- Hero Image -->
                <div class="animate-fadeInUp delay-400">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/hero-students.jpg') }}" alt="Étudiants SupNum" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 md:py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center mb-12 animate-slideInLeft delay-200">
                <div class="h-1 w-12 bg-green-500 mr-4"></div>
                <h2 class="text-xs font-bold text-green-600 uppercase tracking-wider">Plateforme Étudiante</h2>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-12 animate-fadeInUp delay-300">Services disponibles</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Demandes Administratives -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover animate-fadeInUp delay-400">
                    <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6 icon-float">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Demandes Administratives</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Commandez vos certificats de scolarité, relevés de notes et attestations de réussite directement depuis votre espace.
                    </p>
                </div>

                <!-- Certificats Médicaux -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover animate-fadeInUp delay-500">
                    <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6 icon-float">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Certificats Médicaux</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Déposez vos justificatifs d'absence en quelques clics pour une validation rapide par le secrétariat pédagogique.
                    </p>
                </div>

                <!-- Suivi en Temps Réel -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover animate-fadeInUp delay-400">
                    <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6 icon-float">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Suivi en Temps Réel</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Recevez des alertes instantanées par email et sur tableau de bord dès qu'un document est prêt ou validé.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 md:py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 animate-fadeInUp">Prêt à commencer ?</h2>
            <p class="text-gray-600 mb-8 animate-fadeInUp delay-100">
                Connectez-vous avec vos identifiants institutionnels pour accéder à votre espace personnel sécurisé.
            </p>
            <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-green-600 active:bg-green-600 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-all hover:shadow-xl mb-4 animate-fadeInUp delay-200 btn-pulse">
                Se connecter maintenant
            </a>
            <div class="flex items-center justify-center text-sm text-gray-500">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Authentification sécurisée par Institut SupNum
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-2 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <span class="text-xs font-semibold">Institut SupNum</span>
                </div>
                
                <p class="text-xs text-gray-500">© 2025 SupNumPortail. Tous droits réservés.</p>
                
                <div class="flex space-x-6 text-xs text-gray-500">
                    <a href="#" class="hover:text-blue-600 transition-colors">Mentions Légales</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Politique de Confidentialité</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Support Technique</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>