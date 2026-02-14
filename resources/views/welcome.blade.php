<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taakra - Premier Competition Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #ffffff; color: #1e293b; overflow-x: hidden; }
        
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid #e2e8f0; }
        .navbar-container { max-width: 1280px; margin: 0 auto; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 28px; font-weight: 800; color: #1e40af; letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-link { color: #475569; text-decoration: none; font-weight: 500; transition: color 0.3s; font-size: 15px; }
        .nav-link:hover { color: #1e40af; }
        
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%); overflow: hidden; }
        .hero-pattern { position: absolute; inset: 0; opacity: 0.4; background-image: radial-gradient(circle at 25% 25%, #60a5fa 1px, transparent 1px), radial-gradient(circle at 75% 75%, #3b82f6 1px, transparent 1px); background-size: 50px 50px; }
        .hero-shapes { position: absolute; inset: 0; }
        .shape { position: absolute; border-radius: 50%; }
        .shape-1 { width: 300px; height: 300px; background: linear-gradient(135deg, #3b82f6, #60a5fa); opacity: 0.1; top: 10%; left: 5%; animation: float 20s ease-in-out infinite; }
        .shape-2 { width: 400px; height: 400px; background: linear-gradient(135deg, #1e40af, #3b82f6); opacity: 0.1; bottom: 10%; right: 5%; animation: float 25s ease-in-out infinite reverse; }
        .shape-3 { width: 200px; height: 200px; background: linear-gradient(135deg, #60a5fa, #93c5fd); opacity: 0.1; top: 40%; right: 15%; animation: float 30s ease-in-out infinite; }
        
        @keyframes float { 0%, 100% { transform: translate(0, 0) rotate(0deg); } 50% { transform: translate(50px, -50px) rotate(180deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .hero-content { position: relative; z-index: 10; text-align: center; max-width: 900px; padding: 0 40px; animation: fadeInUp 1s ease-out; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: white; border: 1px solid #dbeafe; padding: 10px 20px; border-radius: 50px; font-size: 13px; font-weight: 600; color: #1e40af; margin-bottom: 32px; box-shadow: 0 4px 20px rgba(59,130,246,0.15); }
        .hero-badge .pulse { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }
        
        .hero-title { font-size: 72px; font-weight: 900; line-height: 1.1; margin-bottom: 24px; color: #0f172a; letter-spacing: -2px; }
        .hero-title .gradient-text { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .hero-subtitle { font-size: 20px; color: #475569; margin-bottom: 40px; line-height: 1.7; font-weight: 400; }
        
        .hero-cta { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn { padding: 16px 36px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; }
        .btn-primary { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; box-shadow: 0 10px 30px rgba(30,64,175,0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(30,64,175,0.4); }
        .btn-secondary { background: white; color: #1e40af; border: 2px solid #dbeafe; }
        .btn-secondary:hover { background: #eff6ff; border-color: #3b82f6; }
        
        .stats { padding: 100px 40px; background: white; }
        .stats-container { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 60px; }
        .stat-item { text-align: center; }
        .stat-number { font-size: 56px; font-weight: 900; color: #1e40af; margin-bottom: 12px; }
        .stat-label { font-size: 16px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        
        .features { padding: 120px 40px; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); }
        .section-header { text-align: center; max-width: 700px; margin: 0 auto 80px; }
        .section-title { font-size: 48px; font-weight: 900; color: #0f172a; margin-bottom: 16px; letter-spacing: -1px; }
        .section-subtitle { font-size: 18px; color: #64748b; line-height: 1.7; }
        
        .features-grid { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .feature-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; transition: all 0.3s; }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(30,64,175,0.15); border-color: #3b82f6; }
        .feature-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
        .feature-icon i { font-size: 28px; color: #1e40af; }
        .feature-title { font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        .feature-text { font-size: 15px; color: #64748b; line-height: 1.7; }
        
        .cta-section { padding: 120px 40px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; inset: 0; background: url('data:image/svg+xml,<svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>'); }
        .cta-content { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; text-align: center; color: white; }
        .cta-title { font-size: 52px; font-weight: 900; margin-bottom: 20px; letter-spacing: -1px; }
        .cta-text { font-size: 20px; margin-bottom: 40px; opacity: 0.95; }
        .cta-button { background: white; color: #1e40af; padding: 18px 40px; border-radius: 12px; font-weight: 700; font-size: 17px; text-decoration: none; display: inline-flex; align-items: center; gap: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); transition: all 0.3s; }
        .cta-button:hover { transform: translateY(-4px); box-shadow: 0 15px 50px rgba(0,0,0,0.3); }
        
        .footer { background: #0f172a; color: white; padding: 80px 40px 40px; }
        .footer-content { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; margin-bottom: 60px; }
        .footer-brand { font-size: 32px; font-weight: 900; color: white; margin-bottom: 16px; }
        .footer-desc { color: #94a3b8; line-height: 1.7; font-size: 15px; }
        .footer-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .footer-links { display: flex; flex-direction: column; gap: 12px; }
        .footer-link { color: #94a3b8; text-decoration: none; transition: color 0.3s; font-size: 15px; }
        .footer-link:hover { color: #60a5fa; }
        .footer-bottom { text-align: center; padding-top: 40px; border-top: 1px solid #1e293b; color: #64748b; }
        
        .social-login { display: flex; gap: 12px; justify-content: center; margin-top: 24px; }
        .social-btn { display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; border: 2px solid #e2e8f0; background: white; color: #475569; }
        .social-btn:hover { border-color: #3b82f6; background: #eff6ff; transform: translateY(-2px); }
        .social-btn i { font-size: 18px; }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 42px; }
            .features-grid, .stats-container, .footer-content { grid-template-columns: 1fr; }
            .navbar-container { padding: 16px 24px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">Taakra</div>
            <div class="nav-links">
                <a href="#features" class="nav-link">Features</a>
                <a href="#about" class="nav-link">About</a>
                <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">Get Started Free</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-pattern"></div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-badge">
                <span class="pulse"></span>
                <span>TRUSTED BY 10,000+ COMPETITORS</span>
            </div>
            <h1 class="hero-title">
                Compete, Excel,<br>
                <span class="gradient-text">Win Big</span>
            </h1>
            <p class="hero-subtitle">
                Join the world's premier competition platform. Discover opportunities, showcase your skills, and compete with the best talents globally.
            </p>
            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <span>Start Competing</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#features" class="btn btn-secondary">
                    <span>Learn More</span>
                </a>
            </div>
            
            {{-- <div class="social-login">
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn">
                    <i class="fab fa-google"></i>
                    <span>Continue with Google</span>
                </a>
                <a href="{{ route('social.redirect', 'github') }}" class="social-btn">
                    <i class="fab fa-github"></i>
                    <span>Continue with GitHub</span>
                </a>
            </div> --}}
        </div>
    </section>

    <section class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Active Competitions</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Happy Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">$2M+</div>
                <div class="stat-label">Prizes Awarded</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Categories</div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-header">
            <h2 class="section-title">Everything You Need to Succeed</h2>
            <p class="section-subtitle">Powerful features designed to help you discover, compete, and win in competitions worldwide.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="feature-title">Smart Discovery</h3>
                <p class="feature-text">Find perfect competitions with advanced filters, intelligent search, and personalized recommendations.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title">Instant Registration</h3>
                <p class="feature-text">One-click registration process. Get started in seconds and receive instant confirmations.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="feature-title">Amazing Prizes</h3>
                <p class="feature-text">Compete for cash rewards, exclusive opportunities, and global recognition.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="feature-title">Calendar View</h3>
                <p class="feature-text">Visualize all competitions and deadlines in a beautiful calendar interface.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Track Progress</h3>
                <p class="feature-text">Monitor registrations, competition status, and achievements in real-time.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="feature-title">24/7 Support</h3>
                <p class="feature-text">Get instant help with AI chatbot or connect with our dedicated support team.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Start Winning?</h2>
            <p class="cta-text">Join thousands of competitors already succeeding on Taakra. Your next big opportunity awaits.</p>
            <a href="{{ route('register') }}" class="cta-button">
                <span>Create Free Account</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div>
                <div class="footer-brand">Taakra</div>
                <p class="footer-desc">The premier platform connecting talented individuals with life-changing competition opportunities worldwide.</p>
            </div>
            <div>
                <h4 class="footer-title">Platform</h4>
                <div class="footer-links">
                    <a href="{{ route('competitions.index') }}" class="footer-link">Browse Competitions</a>
                    <a href="#" class="footer-link">Categories</a>
                    <a href="#" class="footer-link">How It Works</a>
                </div>
            </div>
            <div>
                <h4 class="footer-title">Support</h4>
                <div class="footer-links">
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Contact Us</a>
                    <a href="#" class="footer-link">FAQ</a>
                </div>
            </div>
            <div>
                <h4 class="footer-title">Legal</h4>
                <div class="footer-links">
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Cookie Policy</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Taakra. All rights reserved. Empowering competitors worldwide.</p>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>