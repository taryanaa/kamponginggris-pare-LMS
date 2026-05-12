<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kampong Inggris Pare</title>
    <link rel="shortcut icon" href="{{ asset("")  }}/assets/compiled/svg/fav.jpg" type="image">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-100px) translateX(50px);
                opacity: 0.6;
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            width: 420px;
            max-width: 90%;
            animation: slideIn 0.6s ease-out;
            position: relative;
            z-index: 10;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-out 0.2s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .logo {
            width: 200px;
            height: auto;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
        }

        .logo img {
            width: 100%;
            height: auto;
            display: block;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-group {
            margin-bottom: 25px;
            animation: fadeIn 1s ease-out both;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.4s;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: color 0.3s;
            pointer-events: none;
            z-index: 1;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
            position: relative;
            z-index: 0;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        input[type="email"]:focus ~ .input-icon,
        input[type="password"]:focus ~ .input-icon {
            color: #667eea;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-login.loading {
            pointer-events: none;
            color: transparent;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div id="particles"></div>

    <div class="login-container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset("")  }}/assets/compiled/png/logo.png" alt="Kampong Inggris Pare">
            </div>
            <h2>Welcome Back</h2>
            <p class="subtitle">Please login to your account</p>
        </div>

        <form method="POST" action="/dashboard/" id="loginForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
            </div>

            <div class="checkbox-wrapper">
                <label class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <span>Remember Me</span>
                </label>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">Login</button>
        </form>
    </div>

    <script>
        // Generate animated background particles
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 100 + 50;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 5 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }

        // Get form elements
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('btnLogin');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        // Debug info
        console.log('=== LOGIN PAGE DEBUG ===');
        console.log('Form found:', loginForm ? 'YES' : 'NO');
        console.log('Form action:', loginForm ? loginForm.action : 'N/A');
        console.log('Form method:', loginForm ? loginForm.method : 'N/A');
        console.log('Button found:', loginBtn ? 'YES' : 'NO');
        console.log('Email input found:', emailInput ? 'YES' : 'NO');
        console.log('Password input found:', passwordInput ? 'YES' : 'NO');

        // Button click handler untuk debugging
        if (loginBtn) {
            loginBtn.addEventListener('click', function(e) {
                console.log('=== BUTTON CLICKED ===');
                console.log('Email value:', emailInput.value);
                console.log('Password filled:', passwordInput.value ? 'YES' : 'NO');
                console.log('Form will submit...');
            });
        }

        // Form submission handler
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                console.log('=== FORM SUBMIT EVENT ===');
                console.log('Email:', emailInput.value);
                console.log('Password length:', passwordInput.value.length);
                console.log('Form action:', this.action);
                console.log('Form method:', this.method);
                
                // Validasi manual
                if (!emailInput.value || !passwordInput.value) {
                    e.preventDefault();
                    alert('Email dan Password harus diisi!');
                    console.log('Form submission blocked - empty fields');
                    return false;
                }
                
                // Tampilkan loading
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
                
                console.log('Form submitting to server...');
                // Form akan submit secara normal
            });
        }

        // Input focus animation
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transition = 'transform 0.3s';
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>