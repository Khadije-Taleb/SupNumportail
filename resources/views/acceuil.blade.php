<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Accueil - SupNumPortail | Institut Supérieur du Numérique</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Header Styles */
        header {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 8px;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #0D6EFD 0%, #3dd598 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-text h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
        }

        .sup-text {
            color: #22c55e;
        }

        .num-text {
            color: #1e40af;
        }

        .logo-text p {
            font-size: 0.75rem;
            color: #6c757d;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #495057;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #0D6EFD;
        }

        .btn-login {
            background: linear-gradient(135deg, #0D6EFD 0%, #3dd598 100%);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            color: white;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #0D6EFD 0%, #3dd598 100%);
            color: white;
            padding: 4rem 2rem;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            color: white;
        }

        .hero-content p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.8;
            color: white;
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background-color: white;
            color: #0D6EFD;
            padding: 0.9rem 2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            background-color: #f8f9fa;
        }

        .btn-secondary {
            color: white;
            padding: 0.9rem 2rem;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid white;
            border-radius: 6px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .hero-image {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .hero-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
        }

        .dashboard-mockup {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .mockup-header {
            display: flex;
            gap: 6px;
            margin-bottom: 1rem;
        }

        .mockup-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .mockup-dot:nth-child(1) { background-color: #ff5f56; }
        .mockup-dot:nth-child(2) { background-color: #ffbd2e; }
        .mockup-dot:nth-child(3) { background-color: #27c93f; }

        .mockup-content {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 1.5rem;
        }

        .mockup-item {
            background-color: white;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mockup-icon {
            width: 30px;
            height: 30px;
            background-color: #3dd598;
            border-radius: 4px;
        }

        .mockup-bar {
            flex: 1;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
        }

        /* Description Section */
        .description {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            text-align: center;
        }

        .description h3 {
            font-size: 1.8rem;
            color: #212529;
            margin-bottom: 1rem;
        }

        .description p {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Features Section */
        .features {
            background-color: white;
            padding: 4rem 2rem;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features h3 {
            text-align: center;
            font-size: 2rem;
            color: #212529;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border-color: #0D6EFD;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .feature-card:nth-child(1) .feature-icon {
            background: linear-gradient(135deg, #0D6EFD 0%, #3dd598 100%);
            color: white;
        }

        .feature-card:nth-child(2) .feature-icon {
            background: linear-gradient(135deg, #3dd598 0%, #0D6EFD 100%);
            color: white;
        }

        .feature-card:nth-child(3) .feature-icon {
            background: linear-gradient(135deg, #0D6EFD 0%, #3dd598 100%);
            color: white;
        }

        .feature-card:nth-child(4) .feature-icon {
            background: linear-gradient(135deg, #3dd598 0%, #0D6EFD 100%);
            color: white;
        }

        .feature-card h4 {
            font-size: 1.2rem;
            color: #212529;
            margin-bottom: 0.8rem;
        }

        .feature-card p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #3dd598 0%, #0D6EFD 100%);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
        }

        .cta h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .btn-cta {
            background-color: white;
            color: #0D6EFD;
            padding: 1rem 2.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
            font-size: 1.1rem;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        /* Footer */
        footer {
            background-color: #212529;
            color: #adb5bd;
            padding: 2rem;
            text-align: center;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-container h4 {
            color: white;
            margin-bottom: 0.5rem;
        }

        .footer-container p {
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }

            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero-content h2 {
                font-size: 1.8rem;
            }

            .hero-image {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <div class="logo-text">
                    <h1><span class="sup-text">Sup</span><span class="num-text">NumPortail</span></h1>
                    <p>Institut Supérieur du Numérique</p>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#apropos">À propos</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="{{ route('login') }}" class="btn-login">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="hero-container">
            <div class="hero-content">
                <h2>Bienvenue sur SupNumPortail</h2>
                <p>La plateforme numérique officielle de gestion des services académiques de l'Institut Supérieur du Numérique</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-primary">Accéder à SupNumPortail</a>
                    <a href="#aide" class="btn-secondary">Aide à la connexion</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80" alt="Étudiants travaillant sur des ordinateurs">
            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="description">
        <h3>Une plateforme complète pour votre parcours académique</h3>
        <p>SupNumPortail centralise l'ensemble de vos services académiques et administratifs en un seul endroit. Accédez facilement à vos demandes administratives, consultez vos certificats médicaux, téléchargez vos documents officiels et recevez des notifications en temps réel sur l'évolution de vos dossiers.</p>
    </section>

    <!-- Features Section -->
    <section class="features" id="services">
        <div class="features-container">
            <h3>Nos Services</h3>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <h4>Gestion des demandes</h4>
                    <p>Soumettez et suivez vos demandes administratives en ligne de manière simple et efficace</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏥</div>
                    <h4>Certificats médicaux</h4>
                    <p>Gérez vos certificats médicaux et justificatifs d'absence en toute sécurité</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h4>Notifications en temps réel</h4>
                    <p>Recevez des alertes instantanées sur l'état de vos demandes et documents</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h4>Services académiques</h4>
                    <p>Accédez à tous vos services académiques depuis une interface unique et intuitive</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <h3>Étudiant ou administrateur de SupNum ?</h3>
        <a href="{{ route('login') }}" class="btn-cta">Se connecter</a>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-container">
            <h4>Institut Supérieur du Numérique – SupNum</h4>
            <p>&copy; {{ date('Y') }} SupNumPortail. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>