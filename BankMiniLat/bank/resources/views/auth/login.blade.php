<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Tsamaniyah 8</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--primary-green:#1a5f23;--secondary-green:#2d8c3c;--light-green:#4caf50;--accent-yellow:#ffc107;--dark-yellow:#e6a800;--white:#ffffff;--cream:#f9f7f2;--light-grey:#f5f5f5;--medium-grey:#e0e0e0;--dark-grey:#757575;--red:#e53935;--shadow:0 8px 32px rgba(0,0,0,0.1);}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif}
        body{background:linear-gradient(135deg,var(--light-green) 0%,var(--secondary-green) 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;overflow:hidden;position:relative}
        .background-shapes{position:fixed;top:0;left:0;width:100%;height:100%;z-index:0;overflow:hidden}.shape{position:absolute;border-radius:50%;background:rgba(255,255,255,0.1);animation:float 15s infinite ease-in-out}.shape:nth-child(1){width:300px;height:300px;top:-100px;left:-100px;animation-delay:0s}.shape:nth-child(2){width:200px;height:200px;bottom:-50px;right:20%;animation-delay:3s}.shape:nth-child(3){width:150px;height:150px;top:30%;right:-50px;animation-delay:6s}.shape:nth-child(4){width:100px;height:100px;top:50%;left:10%;animation-delay:2s;background:rgba(255,193,7,0.1)}.shape:nth-child(5){width:180px;height:180px;bottom:20%;left:30%;animation-delay:4s;background:rgba(255,255,255,0.08)}@keyframes float{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-20px) rotate(10deg)}}
        .pattern-overlay{position:fixed;inset:0;z-index:0;opacity:.05;background-image:repeating-linear-gradient(45deg,transparent 0,transparent 10px,var(--primary-green) 10px,var(--primary-green) 11px),repeating-linear-gradient(-45deg,transparent 0,transparent 10px,var(--primary-green) 10px,var(--primary-green) 11px);animation:patternMove 30s linear infinite}@keyframes patternMove{0%{background-position:0 0}100%{background-position:100px 100px}}
        .geometric-decoration{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none}.geo-element{position:absolute;border:2px solid rgba(255,255,255,0.15)}.geo-square{width:100px;height:100px;top:10%;left:5%;transform:rotate(45deg);animation:rotate 20s linear infinite}@keyframes rotate{0%{transform:rotate(45deg)}100%{transform:rotate(405deg)}}.geo-circle{width:150px;height:150px;border-radius:50%;bottom:15%;right:10%;animation:scale-pulse 4s ease-in-out infinite}@keyframes scale-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}.geo-triangle{width:0;height:0;border-left:60px solid transparent;border-right:60px solid transparent;border-bottom:100px solid rgba(255,193,7,0.15);top:40%;right:8%;animation:float 8s ease-in-out infinite}
        .login-container{width:500px;max-width:90%;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-radius:20px;padding:50px 45px;box-shadow:var(--shadow);border:1px solid rgba(255,255,255,0.3);animation:fadeIn 0.8s ease-out;position:relative;z-index:10;overflow:hidden}.login-container::before{content:'';position:absolute;top:-50%;right:-50%;width:200%;height:200%;background:conic-gradient(from 0deg at 50% 50%,transparent 0deg,rgba(76,175,80,0.05) 90deg,transparent 180deg);animation:containerRotate 10s linear infinite;pointer-events:none}@keyframes containerRotate{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}.login-container::after{content:'';position:absolute;bottom:-100px;left:-100px;width:200px;height:200px;background:radial-gradient(circle,rgba(255,193,7,0.1) 0%,transparent 70%);border-radius:50%;pointer-events:none}@keyframes fadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .bank-logo{display:flex;align-items:center;justify-content:center;margin-bottom:40px;position:relative;z-index:1}.logo-circle{width:80px;height:80px;background:linear-gradient(135deg,var(--accent-yellow) 0%,var(--dark-yellow) 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-right:20px;font-weight:bold;font-size:32px;color:var(--primary-green);box-shadow:0 4px 15px rgba(0,0,0,0.1);animation:logoPulse 2s infinite;position:relative}.logo-circle::before{content:'';position:absolute;inset:-8px;border-radius:50%;border:3px solid rgba(255,193,7,0.3);animation:logoRipple 2s ease-out infinite}@keyframes logoRipple{0%{transform:scale(1);opacity:1}100%{transform:scale(1.4);opacity:0}}@keyframes logoPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}.logo-circle::after{content:'';position:absolute;inset:0;border-radius:50%;background:linear-gradient(45deg,transparent 30%,rgba(255,255,255,0.3) 50%,transparent 70%);animation:shine 3s ease-in-out infinite}@keyframes shine{0%{transform:translateX(-100%) rotate(45deg)}100%{transform:translateX(200%) rotate(45deg)}}.bank-name{font-size:28px;font-weight:700;color:var(--primary-green);text-shadow:2px 2px 4px rgba(0,0,0,0.1);position:relative}
        .form-title{font-size:24px;font-weight:600;color:var(--primary-green);text-align:center;margin-bottom:35px;position:relative;z-index:1}
        .form-group{margin-bottom:25px;position:relative;z-index:1;animation:slideIn 0.5s ease-out forwards;opacity:0}.form-group:nth-child(1){animation-delay:0.1s}.form-group:nth-child(2){animation-delay:0.2s}.form-group:nth-child(3){animation-delay:0.3s}@keyframes slideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
        .input-label{display:block;margin-bottom:12px;font-weight:600;color:var(--primary-green);font-size:16px}
        .input-container{position:relative}.text-input{width:100%;padding:16px 50px 16px 20px;border:2px solid var(--medium-grey);border-radius:12px;font-size:16px;transition:all 0.3s;background:var(--light-grey);color:var(--dark-grey);position:relative}.text-input:focus{outline:none;border-color:var(--secondary-green);box-shadow:0 0 0 3px rgba(45,140,60,0.2);background:var(--white);transform:translateY(-2px)}.text-input::placeholder{color:var(--dark-grey);opacity:0.6}
        .input-icon{position:absolute;right:20px;top:50%;transform:translateY(-50%);color:var(--primary-green);font-size:20px;transition:all 0.3s}.text-input:focus~.input-icon{color:var(--secondary-green);animation:iconBounce 0.6s ease}.input-icon::before{content:'';position:absolute;inset:-5px;border-radius:50%;background:rgba(76,175,80,0.1);opacity:0;transition:opacity 0.3s}.text-input:focus~.input-icon::before{opacity:1}@keyframes iconBounce{0%,100%{transform:translateY(-50%) scale(1)}50%{transform:translateY(-50%) scale(1.2)}}
        .input-error{color:var(--red);font-size:14px;margin-top:8px;display:flex;align-items:center;font-weight:500;animation:errorShake 0.5s ease}.error-icon{margin-right:8px}@keyframes errorShake{0%,100%{transform:translateX(0)}25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
        .remember-me-container{margin:30px 0;position:relative;z-index:1;animation:slideIn 0.5s ease-out 0.4s forwards;opacity:0}
        .remember-me{display:flex;align-items:center;cursor:pointer;padding:8px;border-radius:8px;transition:background 0.3s}.remember-me:hover{background:rgba(45,140,60,0.05)}.remember-me input{width:20px;height:20px;margin-right:12px;accent-color:var(--accent-yellow);cursor:pointer}.remember-me label{color:var(--dark-grey);font-size:16px;font-weight:500;cursor:pointer;user-select:none}
        .flex-container{display:flex;align-items:center;justify-content:space-between;margin-top:30px;position:relative;z-index:1;animation:slideIn 0.5s ease-out 0.5s forwards;opacity:0}
        .forgot-password{color:var(--secondary-green);text-decoration:none;font-weight:600;font-size:16px;transition:all 0.3s;padding:8px 12px;border-radius:6px;position:relative;overflow:hidden}.forgot-password::before{content:'';position:absolute;inset:0;background:rgba(45,140,60,0.1);transform:scaleX(0);transform-origin:left;transition:transform 0.3s}.forgot-password:hover{color:var(--primary-green);text-decoration:underline}.forgot-password:hover::before{transform:scaleX(1)}
        .primary-button{padding:16px 35px;background:linear-gradient(to right,var(--primary-green),var(--secondary-green));color:var(--white);border:none;border-radius:12px;font-size:18px;font-weight:600;cursor:pointer;transition:all 0.3s;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(0,0,0,0.2);min-width:140px;position:relative;overflow:hidden}.primary-button::before{content:'';position:absolute;inset:0;background:linear-gradient(to right,var(--secondary-green),var(--light-green));opacity:0;transition:opacity 0.3s}.primary-button:hover{box-shadow:0 6px 20px rgba(0,0,0,0.3);transform:translateY(-2px)}.primary-button:hover::before{opacity:1}.primary-button:active{transform:translateY(0)}.button-icon{margin-right:10px;font-size:20px;z-index:1;position:relative}.primary-button span{position:relative;z-index:1}
        .session-status{padding:15px 20px;border-radius:10px;margin-bottom:25px;font-weight:500;font-size:15px;border-left:4px solid var(--secondary-green);background:rgba(76,175,80,0.1);color:var(--secondary-green);position:relative;z-index:1;animation:slideDown 0.5s ease-out}@keyframes slideDown{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}.session-status.error{background:rgba(229,57,53,0.1);color:var(--red);border-left-color:var(--red)}
        .security-badge{position:absolute;top:20px;right:20px;background:rgba(255,193,7,0.9);padding:8px 16px;border-radius:20px;font-size:12px;font-weight:700;color:var(--primary-green);box-shadow:0 2px 8px rgba(0,0,0,0.1);z-index:2;display:flex;align-items:center;gap:6px;animation:badgeFloat 3s ease-in-out infinite}@keyframes badgeFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}.security-badge i{font-size:14px}
        .password-strength{margin-top:8px;height:4px;background:var(--medium-grey);border-radius:2px;overflow:hidden;opacity:0;transition:opacity 0.3s}.password-strength.active{opacity:1}.password-strength-bar{height:100%;background:linear-gradient(to right,var(--red),var(--accent-yellow),var(--light-green));width:0%;transition:width 0.3s}
        @media (max-width: 768px){.geometric-decoration{display:none}}
        @media (max-width: 480px){.login-container{padding:40px 25px}.bank-logo{flex-direction:column;text-align:center}.logo-circle{margin-right:0;margin-bottom:15px}.bank-name{font-size:24px}.flex-container{flex-direction:column;gap:20px;align-items:stretch}.primary-button{width:100%}.security-badge{position:static;margin-bottom:20px;align-self:center}}

        /* ========== ADDED: styles for password toggle button ========== */
        .toggle-password {
          position: absolute;
          /* place it left of existing .input-icon (which is right:20px) */
          right: 52px;
          top: 50%;
          transform: translateY(-50%);
          background: transparent;
          border: none;
          color: var(--primary-green);
          font-size: 18px;
          cursor: pointer;
          padding: 6px;
          border-radius: 6px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
        }
        .toggle-password[aria-pressed="true"] {
          color: var(--secondary-green);
        }
        /* small hit-area tweak for mobile */
        @media (max-width:480px){
          .toggle-password{right:60px}
          .input-icon{right:14px}
        }
    </style>
</head>
<body>
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="pattern-overlay"></div>
    <div class="geometric-decoration">
        <div class="geo-element geo-square"></div>
        <div class="geo-element geo-circle"></div>
        <div class="geo-element geo-triangle"></div>
    </div>
    
    <div class="login-container">
        <div class="security-badge"><i class="fas fa-shield-alt"></i>Secure Login</div>
        <div class="bank-logo">
            <div class="logo-circle">T8</div>
            <div class="bank-name">Bank Tsamaniyah 8</div>
        </div>
        
        <x-auth-session-status class="session-status" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <x-input-label class="input-label" for="email" :value="__('Email')" />
                <div class="input-container">
                    <x-text-input class="text-input" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan alamat email Anda" />
                    <div class="input-icon"><i class="far fa-envelope"></i></div>
                </div>
                <x-input-error class="input-error" :messages="$errors->get('email')" />
            </div>

            <div class="form-group">
                <x-input-label class="input-label" for="password" :value="__('Password')" />
                <div class="input-container" style="position:relative;">
                    <!-- password input -->
                    <x-text-input class="text-input" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda" />
                    
                    <!-- toggle button (eye) -->
                    <button type="button" id="togglePassword" class="toggle-password" aria-pressed="false" aria-label="Tampilkan kata sandi">
                      <i class="fa-solid fa-eye" id="togglePasswordIcon" aria-hidden="true"></i>
                    </button>

                    <!-- existing icon (lock) kept as-is -->
                    <div class="input-icon"><i class="fas fa-lock"></i></div>
                </div>
                <div class="password-strength" id="passwordStrength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                <x-input-error class="input-error" :messages="$errors->get('password')" />
            </div>

            <div class="remember-me-container">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex-container">
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="primary-button">
                    <span class="button-icon"><i class="fas fa-sign-in-alt"></i></span>
                    <span>{{ __('Log in') }}</span>
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded',()=>{
            // password strength logic (existing)
            const pwdInput=document.getElementById('password');
            const strengthBar=document.getElementById('passwordStrengthBar');
            const strengthContainer=document.getElementById('passwordStrength');
            
            if(pwdInput){
                pwdInput.addEventListener('input',()=>{
                    const val=pwdInput.value;
                    if(val.length>0){
                        strengthContainer.classList.add('active');
                        let strength=0;
                        if(val.length>=8)strength+=33;
                        if(/[A-Z]/.test(val)&&/[a-z]/.test(val))strength+=33;
                        if(/[0-9]/.test(val)&&/[^A-Za-z0-9]/.test(val))strength+=34;
                        strengthBar.style.width=strength+'%';
                    }else{
                        strengthContainer.classList.remove('active');
                        strengthBar.style.width = '0%';
                    }
                });
            }

            // focus visuals
            const inputs=document.querySelectorAll('.text-input');
            inputs.forEach(input=>{
                input.addEventListener('focus',()=>{
                    input.parentElement.classList.add('focused');
                });
                input.addEventListener('blur',()=>{
                    input.parentElement.classList.remove('focused');
                });
            });

            // ripple on primary-button (existing)
            const btn=document.querySelector('.primary-button');
            if(btn){
                btn.addEventListener('click',function(e){
                    const ripple=document.createElement('span');
                    const rect=this.getBoundingClientRect();
                    const size=Math.max(rect.width,rect.height);
                    ripple.style.width=ripple.style.height=size+'px';
                    ripple.style.left=(e.clientX-rect.left-size/2)+'px';
                    ripple.style.top=(e.clientY-rect.top-size/2)+'px';
                    ripple.style.position='absolute';
                    ripple.style.borderRadius='50%';
                    ripple.style.background='rgba(255,255,255,0.5)';
                    ripple.style.transform='scale(0)';
                    ripple.style.animation='rippleEffect 0.6s ease-out';
                    ripple.style.pointerEvents='none';
                    this.appendChild(ripple);
                    setTimeout(()=>ripple.remove(),600);
                });
            }

            const style=document.createElement('style');
            style.textContent='@keyframes rippleEffect{to{transform:scale(2);opacity:0}}';
            document.head.appendChild(style);

            // ========== NEW: Toggle password visibility ==========
            const toggleBtn = document.getElementById('togglePassword');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if(toggleBtn && pwdInput){
                toggleBtn.addEventListener('click', function(e){
                    e.preventDefault(); // jangan submit form
                    const isHidden = pwdInput.type === 'password';
                    if(isHidden){
                        pwdInput.type = 'text';
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                        toggleBtn.setAttribute('aria-pressed', 'true');
                        toggleBtn.setAttribute('aria-label', 'Sembunyikan kata sandi');
                    } else {
                        pwdInput.type = 'password';
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                        toggleBtn.setAttribute('aria-pressed', 'false');
                        toggleBtn.setAttribute('aria-label', 'Tampilkan kata sandi');
                    }
                    // fokus kembali ke input agar user tetap nyaman
                    pwdInput.focus();
                });

                // optional: toggle on pressing Enter while focused on button
                toggleBtn.addEventListener('keydown', function(e){
                    if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); this.click(); }
                });
            }

            // small enhancement: hide password on form submit for security
            const form = document.querySelector('form');
            if(form){
                form.addEventListener('submit', () => {
                    if(pwdInput) pwdInput.type = 'password';
                    if(toggleIcon){
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                    if(toggleBtn) toggleBtn.setAttribute('aria-pressed', 'false');
                });
            }
        });
    </script>
</body>
</html>
