@extends('layouts.app')

@section('content')
<style>
  @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
  
  :root{--primary-green:#2C5F2D;--primary-dark-green:#1a3a1b;--primary-light-green:#97BC62;--accent-gold:#FFD93D;--accent-yellow:#ffc107;--accent-red:#dc3545;--bg-white:#ffffff;--bg-cream:#FFF8E7;--bg-light:#f8f9fa;--text-dark:#212529;--text-grey:#495057;--text-light:#6c757d;--border-light:#dee2e6;--shadow-soft:0 2px 8px rgba(0,0,0,.05);--shadow-medium:0 4px 16px rgba(0,0,0,.12);--shadow-strong:0 8px 32px rgba(0,0,0,.16);--gradient-green:linear-gradient(135deg,#2C5F2D 0%,#97BC62 100%);--gradient-gold:linear-gradient(135deg,#FFD93D 0%,#ffc107 100%);--gradient-cream:linear-gradient(135deg,#ffffff 0%,#FFF8E7 100%);}
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg-cream);min-height:100vh;position:relative;overflow-x:hidden;}
  body::before{content:'';position:fixed;top:0;left:0;width:100%;height:100%;background-image:radial-gradient(circle at 20% 30%,rgba(44,95,45,0.03) 0%,transparent 50%),radial-gradient(circle at 80% 70%,rgba(151,188,98,0.04) 0%,transparent 50%),radial-gradient(circle at 50% 50%,rgba(255,217,61,0.02) 0%,transparent 50%);pointer-events:none;z-index:0;}
  .dashboard-wrapper{display:flex;min-height:100vh;position:relative;z-index:1;}
  .user-profile-btn img,.profile-avatar-large img{width:100%;height:100%;object-fit:cover;border-radius:50%}


  /* SIDEBAR */
  .sidebar{width:290px;background:var(--bg-white);box-shadow:var(--shadow-medium);position:fixed;inset:0 auto 0 0;height:100vh;overflow-y:auto;z-index:1000;transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);}
  .sidebar-header{padding:28px 24px;background:var(--gradient-green);position:relative;overflow:hidden;}
  .sidebar-header::before{content:'';position:absolute;top:-50%;right:-20%;width:200px;height:200px;background:rgba(255,255,255,0.1);border-radius:50%;}
  .sidebar-header::after{content:'';position:absolute;bottom:-30%;left:-10%;width:150px;height:150px;background:rgba(255,255,255,0.08);border-radius:50%;}
  
  /* TEMPAT IMAGE LOGO SEKOLAH DI SIDEBAR */
  .school-logo-section{position:relative;z-index:2;text-align:center;margin-bottom:16px;}
  .school-logo-wrapper{width:80px;height:80px;margin:0 auto 12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:16px;padding:10px;border:2px solid rgba(255,255,255,0.3);box-shadow:var(--shadow-soft);}
  .school-logo-wrapper img{width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 2px 4px rgba(0,0,0,0.1));}
  .school-logo-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:40px;color:var(--bg-white);}
  
  .sidebar-brand{position:relative;z-index:2;text-align:center;color:var(--bg-white);}
  .brand-text h3{font-size:20px;font-weight:800;margin:0 0 4px 0;letter-spacing:-0.5px;}
  .brand-text p{font-size:12px;opacity:0.9;margin:0;font-weight:500;}
  .sidebar-menu{padding:24px 0;}
  .menu-section-label{padding:8px 24px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-light);margin-top:8px;}
  .menu-item{padding:14px 24px;display:flex;align-items:center;gap:14px;color:var(--text-grey);text-decoration:none;transition:all 0.3s ease;border-left:4px solid transparent;cursor:pointer;position:relative;}
  .menu-item::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:0;height:0;background:var(--primary-green);transition:all 0.3s ease;border-radius:0 4px 4px 0;}
  .menu-item:hover{background:rgba(44,95,45,0.05);color:var(--primary-green);padding-left:28px;}
  .menu-item:hover::before{width:4px;height:100%;}
  .menu-item.active{background:linear-gradient(90deg,rgba(44,95,45,0.1) 0%,transparent 100%);color:var(--primary-green);font-weight:600;border-left-color:var(--primary-green);}
  .menu-item i{font-size:22px;width:28px;display:flex;align-items:center;justify-content:center;}

  /* OVERLAY */
  .overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);display:none;z-index:900;opacity:0;transition:opacity 0.3s ease;}
  .overlay.show{display:block;opacity:1;}

  /* MAIN CONTENT */
  .main-content{margin-left:290px;flex:1;padding:32px;width:calc(100% - 290px);min-height:100vh;}
  .top-header{background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);padding:24px 32px;border-radius:20px;box-shadow:var(--shadow-soft);margin-bottom:32px;display:flex;justify-content:space-between;align-items:center;border:1px solid rgba(255,255,255,0.8);position:relative;overflow:hidden;}
  .top-header::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:var(--gradient-green);}
  .welcome-section{display:flex;align-items:center;gap:18px;}
  .welcome-icon{width:56px;height:56px;background:var(--gradient-green);border-radius:16px;display:flex;align-items:center;justify-content:center;color:var(--bg-white);font-size:28px;box-shadow:var(--shadow-medium);}
  .welcome-text h3{font-size:26px;font-weight:800;color:var(--text-dark);margin-bottom:4px;line-height:1.2;}
  .welcome-text p{color:var(--text-light);font-size:14px;font-weight:500;}
  .header-actions{display:flex;gap:16px;align-items:center;}
  .time-display{background:var(--gradient-green);color:var(--bg-white);padding:12px 20px;border-radius:14px;font-weight:700;display:flex;gap:10px;align-items:center;box-shadow:var(--shadow-soft);font-size:15px;}
  .user-profile-btn{width:48px;height:48px;border-radius:50%;background:var(--gradient-gold);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--text-dark);font-size:18px;box-shadow:var(--shadow-soft);cursor:pointer;transition:all 0.3s ease;border:3px solid var(--bg-white);}
  .user-profile-btn:hover{transform:scale(1.1);box-shadow:var(--shadow-medium);}

  /* NOTIFICATIONS */
  .notification-card{padding:18px 24px;border-radius:16px;margin-bottom:24px;display:flex;gap:14px;align-items:center;box-shadow:var(--shadow-soft);animation:slideInDown 0.5s ease;border-left:5px solid;}
  @keyframes slideInDown{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}
  .notification-card.success{background:linear-gradient(135deg,#d1fae5 0%,#a7f3d0 100%);border-left-color:var(--primary-green);color:#065f46;}
  .notification-card.error{background:linear-gradient(135deg,#fee2e2 0%,#fecaca 100%);border-left-color:var(--accent-red);color:#991b1b;}
  .notification-card.info{background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%);border-left-color:#3b82f6;color:#1e40af;}
  .notification-card i{font-size:26px;}
  .notification-card span{font-weight:600;font-size:15px;}

  /* HERO ACCOUNT CARD */
  .hero-account-card{background:var(--gradient-green);border-radius:24px;padding:0;margin-bottom:32px;position:relative;overflow:hidden;box-shadow:var(--shadow-strong);color:var(--bg-white);}
  .hero-account-card::before{content:'';position:absolute;top:-100px;right:-100px;width:300px;height:300px;background:rgba(255,255,255,0.1);border-radius:50%;}
  .hero-account-card::after{content:'';position:absolute;bottom:-50px;left:-50px;width:200px;height:200px;background:rgba(255,255,255,0.08);border-radius:50%;}
  
  /* TEMPAT IMAGE BANK/SEKOLAH DI HERO CARD (Optional Background) */
  .hero-card-bg-image{position:absolute;inset:0;opacity:0.08;z-index:1;}
  .hero-card-bg-image img{width:100%;height:100%;object-fit:cover;}
  
  .account-card-content{position:relative;z-index:2;padding:32px;}
  .account-top-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;}
  .account-chip{width:56px;height:44px;background:linear-gradient(135deg,rgba(255,217,61,0.3),rgba(255,193,7,0.2));border-radius:10px;border:2px solid rgba(255,255,255,0.4);position:relative;}
  .account-chip::before,.account-chip::after{content:'';position:absolute;background:rgba(255,255,255,0.5);border-radius:2px;}
  .account-chip::before{width:60%;height:3px;top:40%;left:20%;}
  .account-chip::after{width:40%;height:3px;bottom:35%;right:20%;}
  .card-type-badge{background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);padding:8px 16px;border-radius:20px;font-size:13px;font-weight:700;letter-spacing:1px;border:1px solid rgba(255,255,255,0.3);}
  .account-number-section{margin-bottom:32px;}
  .account-number-label{font-size:12px;opacity:0.9;margin-bottom:8px;font-weight:600;letter-spacing:0.5px;}
  .account-number-display{display:flex;align-items:center;gap:16px;}
  .account-number-value{font-family:'Courier New',monospace;font-size:28px;font-weight:800;letter-spacing:3px;}
  .copy-account-btn{background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border:2px solid rgba(255,255,255,0.4);color:var(--bg-white);padding:10px 14px;border-radius:12px;cursor:pointer;transition:all 0.3s ease;font-size:18px;}
  .copy-account-btn:hover{background:rgba(255,255,255,0.3);transform:scale(1.1);}
  .account-balance-section{display:flex;justify-content:space-between;align-items:flex-end;}
  .balance-info{flex:1;}
  .balance-label{font-size:13px;opacity:0.9;margin-bottom:8px;font-weight:600;letter-spacing:0.5px;}
  .balance-amount{font-size:44px;font-weight:900;line-height:1;margin-bottom:12px;text-shadow:0 2px 8px rgba(0,0,0,0.1);}
  .balance-toggle-btn{background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border:2px solid rgba(255,255,255,0.4);color:var(--bg-white);padding:10px 18px;border-radius:12px;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.3s ease;display:inline-flex;gap:8px;align-items:center;}
  .balance-toggle-btn:hover{background:rgba(255,255,255,0.3);}
  .account-status-badge{background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);padding:10px 18px;border-radius:30px;font-weight:700;font-size:13px;display:inline-flex;gap:8px;align-items:center;border:2px solid rgba(255,255,255,0.3);}
  .account-status-badge.active{background:rgba(151,188,98,0.3);border-color:rgba(151,188,98,0.5);}
  .account-status-badge.inactive{background:rgba(220,53,69,0.3);border-color:rgba(220,53,69,0.5);}

  /* RULES SECTION */
  .rules-section{margin-bottom:32px;}
  .rules-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;}
  .rule-card{background:var(--bg-white);padding:24px;border-radius:20px;box-shadow:var(--shadow-soft);transition:all 0.3s ease;border:2px solid transparent;position:relative;overflow:hidden;}
  .rule-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:var(--gradient-green);transform:scaleX(0);transition:transform 0.3s ease;}
  .rule-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-medium);border-color:var(--primary-light-green);}
  .rule-card:hover::before{transform:scaleX(1);}
  .rule-icon-wrapper{width:64px;height:64px;background:var(--gradient-green);border-radius:18px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:var(--shadow-soft);}
  .rule-icon-wrapper i{font-size:32px;color:var(--bg-white);}
  .rule-label{font-size:13px;color:var(--text-light);margin-bottom:8px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;}
  .rule-value{font-size:24px;font-weight:800;color:var(--primary-green);}

  /* TRANSACTION FORMS */
  .transaction-forms-section{margin-bottom:32px;}
  .forms-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(350px,1fr));gap:24px;}
  .transaction-form-card{background:var(--bg-white);border-radius:20px;padding:28px;box-shadow:var(--shadow-medium);transition:all 0.3s ease;border:2px solid transparent;}
  .transaction-form-card:hover{box-shadow:var(--shadow-strong);transform:translateY(-2px);}
  .form-card-header{display:flex;align-items:center;gap:16px;margin-bottom:24px;padding-bottom:20px;border-bottom:3px solid var(--bg-light);}
  .form-icon-wrapper{width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;color:var(--bg-white);box-shadow:var(--shadow-soft);}
  .form-icon-wrapper.deposit{background:var(--gradient-green);}
  .form-icon-wrapper.withdraw{background:var(--gradient-gold);}
  .form-card-header h4{font-size:20px;font-weight:800;color:var(--text-dark);margin:0;}
  .quick-amounts-section{margin-bottom:20px;}
  .quick-amounts-label{font-size:12px;font-weight:700;color:var(--text-grey);margin-bottom:10px;text-transform:uppercase;letter-spacing:0.5px;}
  .quick-amounts-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;}
  .quick-amount-btn{padding:12px;border:2px solid var(--border-light);background:var(--bg-light);border-radius:12px;cursor:pointer;font-weight:700;color:var(--text-grey);font-size:14px;transition:all 0.3s ease;text-align:center;}
  .quick-amount-btn:hover{border-color:var(--primary-green);background:rgba(44,95,45,0.05);color:var(--primary-green);transform:scale(1.05);}
  .form-input-wrapper{position:relative;margin-bottom:20px;}
  .form-input-label{font-size:13px;font-weight:700;color:var(--text-grey);margin-bottom:8px;display:block;text-transform:uppercase;letter-spacing:0.5px;}
  .form-input-group{position:relative;}
  .form-input{width:100%;padding:16px 16px 16px 52px;border:2px solid var(--border-light);border-radius:14px;font-size:18px;font-weight:700;background:var(--bg-light);transition:all 0.3s ease;color:var(--text-dark);}
  .form-input:focus{outline:none;border-color:var(--primary-green);background:var(--bg-white);box-shadow:0 0 0 4px rgba(44,95,45,0.1);}
  .input-prefix{position:absolute;left:18px;top:50%;transform:translateY(-50%);font-weight:800;color:var(--text-grey);font-size:16px;}
  .submit-transaction-btn{width:100%;padding:16px;border:none;border-radius:14px;font-weight:800;font-size:16px;cursor:pointer;display:flex;gap:10px;align-items:center;justify-content:center;transition:all 0.3s ease;color:var(--bg-white);box-shadow:var(--shadow-medium);letter-spacing:0.5px;}
  .submit-transaction-btn.deposit{background:var(--gradient-green);}
  .submit-transaction-btn.withdraw{background:var(--gradient-gold);color:var(--text-dark);}
  .submit-transaction-btn:hover{transform:translateY(-2px);box-shadow:var(--shadow-strong);}
  .submit-transaction-btn:active{transform:translateY(0);}

  /* WARNING ALERT */
  .warning-alert{background:linear-gradient(135deg,#fff3cd 0%,#ffe69c 100%);border-left:5px solid var(--accent-yellow);padding:24px;border-radius:16px;margin-bottom:32px;box-shadow:var(--shadow-soft);display:flex;gap:18px;align-items:center;}
  .warning-alert i{font-size:36px;color:#856404;}
  .warning-alert p{margin:0;color:#856404;font-weight:600;font-size:15px;line-height:1.6;}

  /* TRANSACTION HISTORY */
  .history-section{background:var(--bg-white);border-radius:20px;box-shadow:var(--shadow-medium);overflow:hidden;}
  .history-header{padding:24px 32px;background:var(--gradient-green);color:var(--bg-white);display:flex;align-items:center;gap:14px;}
  .history-header i{font-size:28px;}
  .history-header h4{font-size:22px;font-weight:800;margin:0;}
  .table-container{overflow-x:auto;}
  .transaction-table{width:100%;border-collapse:collapse;}
  .transaction-table thead{background:var(--bg-light);}
  .transaction-table th{padding:18px 20px;text-align:left;font-weight:800;color:var(--text-grey);font-size:12px;text-transform:uppercase;letter-spacing:1px;border-bottom:3px solid var(--border-light);white-space:nowrap;}
  .transaction-table td{padding:18px 20px;border-bottom:1px solid var(--bg-light);color:var(--text-dark);font-weight:600;}
  .transaction-table tbody tr{transition:all 0.3s ease;}
  .transaction-table tbody tr:hover{background:rgba(44,95,45,0.03);}
  .transaction-id{font-family:'Courier New',monospace;font-weight:800;color:var(--primary-green);}
  .transaction-type-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;font-weight:700;font-size:13px;}
  .transaction-type-badge.setor{background:linear-gradient(135deg,#d1fae5 0%,#a7f3d0 100%);color:#065f46;}
  .transaction-type-badge.tarik{background:linear-gradient(135deg,#fef3c7 0%,#fde68a 100%);color:#92400e;}
  .transaction-status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-weight:700;font-size:12px;}
  .transaction-status-badge.pending{background:linear-gradient(135deg,#fef3c7 0%,#fde68a 100%);color:#92400e;}
  .transaction-status-badge.approved{background:linear-gradient(135deg,#d1fae5 0%,#a7f3d0 100%);color:#065f46;}
  .transaction-status-badge.rejected{background:linear-gradient(135deg,#fee2e2 0%,#fecaca 100%);color:#991b1b;}
  .empty-state{padding:64px 32px;text-align:center;}
  .empty-icon{width:120px;height:120px;margin:0 auto 24px;background:var(--bg-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:56px;color:var(--text-light);}
  .empty-text{font-size:16px;color:var(--text-light);font-weight:600;}

  /* PROFILE SECTION */
  .profile-section{background:var(--bg-white);border-radius:20px;box-shadow:var(--shadow-medium);overflow:hidden;}
  .profile-header{padding:32px;background:var(--gradient-green);color:var(--bg-white);position:relative;overflow:hidden;}
  .profile-header::before{content:'';position:absolute;top:-50%;right:-20%;width:250px;height:250px;background:rgba(255,255,255,0.1);border-radius:50%;}
  
  /* TEMPAT IMAGE FOTO PROFIL/SEKOLAH DI PROFILE */
  .profile-banner-image{position:absolute;inset:0;opacity:0.1;z-index:1;}
  .profile-banner-image img{width:100%;height:100%;object-fit:cover;}
  
  .profile-header-content{position:relative;z-index:2;display:flex;align-items:center;gap:24px;}
  .profile-avatar-large{width:88px;height:88px;border-radius:50%;background:var(--gradient-gold);display:flex;align-items:center;justify-content:center;font-weight:900;color:var(--text-dark);font-size:36px;box-shadow:var(--shadow-medium);border:4px solid rgba(255,255,255,0.3);position:relative;overflow:hidden;}
  
  /* TEMPAT IMAGE FOTO PROFIL USER */
  .profile-avatar-large img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0;}
  
  .profile-info h3{font-size:28px;font-weight:800;margin-bottom:8px;}
  .profile-info p{font-size:15px;opacity:0.9;font-weight:500;}
  .profile-status-tag{margin-left:auto;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);padding:12px 20px;border-radius:30px;font-weight:700;font-size:14px;border:2px solid rgba(255,255,255,0.3);display:inline-flex;gap:8px;align-items:center;}
  .profile-body{padding:32px;}
  .profile-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;}
  .profile-item{background:var(--bg-light);border:2px solid var(--border-light);border-radius:16px;padding:20px;transition:all 0.3s ease;}
  .profile-item:hover{border-color:var(--primary-light-green);background:var(--bg-white);transform:translateY(-2px);box-shadow:var(--shadow-soft);}
  .profile-item-label{display:block;color:var(--text-light);margin-bottom:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;font-size:11px;}
  .profile-item-value{font-weight:800;color:var(--text-dark);font-size:16px;}

  /* SCHOOL INFO BANNER (Optional - bisa ditambahkan di bawah hero card) */
  .school-info-banner{background:var(--bg-white);border-radius:20px;padding:24px;margin-bottom:32px;box-shadow:var(--shadow-soft);display:flex;gap:20px;align-items:center;border-left:4px solid var(--accent-gold);}
  .school-info-image{width:80px;height:80px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--bg-light);}
  .school-info-image img{width:100%;height:100%;object-fit:cover;}
  .school-info-placeholder-icon{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:36px;color:var(--primary-green);}
  .school-info-content h4{font-size:18px;font-weight:800;color:var(--text-dark);margin-bottom:4px;}
  .school-info-content p{font-size:14px;color:var(--text-grey);line-height:1.5;margin:0;}

  /* SECTIONS */
  .section{display:none;}
  .section.active{display:block;animation:fadeIn 0.5s ease;}
  @keyframes fadeIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}

  /* MOBILE MENU */
  .mobile-menu-btn{display:none;position:fixed;bottom:24px;right:24px;width:64px;height:64px;border-radius:50%;background:var(--gradient-green);color:var(--bg-white);border:none;box-shadow:var(--shadow-strong);z-index:950;cursor:pointer;transition:all 0.3s ease;}
  .mobile-menu-btn:hover{transform:scale(1.1);}
  .mobile-menu-btn i{font-size:28px;}
  .hamburger-btn{display:none;background:var(--bg-white);border:2px solid var(--border-light);padding:10px 16px;border-radius:12px;box-shadow:var(--shadow-soft);cursor:pointer;transition:all 0.3s ease;}
  .hamburger-btn:hover{border-color:var(--primary-green);background:rgba(44,95,45,0.05);}
  .hamburger-btn i{font-size:24px;color:var(--text-dark);}

  /* RESPONSIVE */
  @media (max-width:1200px){.rules-grid{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.active{transform:translateX(0);}
    .main-content{margin-left:0;width:100%;padding:20px;}
    .top-header{padding:18px 20px;flex-direction:column;gap:16px;align-items:stretch;}
    .welcome-section{flex-direction:column;align-items:flex-start;}
    .header-actions{justify-content:space-between;}
    .hamburger-btn{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
    .welcome-text h3{font-size:22px;}
    .time-display{font-size:13px;padding:10px 14px;}
    .rules-grid{grid-template-columns:1fr;gap:16px;}
    .forms-grid{grid-template-colu  mns:1fr;gap:20px;}
    .balance-amount{font-size:36px;}
    .account-number-value{font-size:20px;letter-spacing:2px;}
    .transaction-table{font-size:13px;}
    .transaction-table th,.transaction-table td{padding:12px 10px;}
    .profile-header-content{flex-direction:column;align-items:flex-start;}
    .profile-status-tag{margin-left:0;align-self:flex-start;}
    .profile-grid{grid-template-columns:1fr;}
    .mobile-menu-btn{display:flex;align-items:center;justify-content:center;}
    .school-info-banner{flex-direction:column;text-align:center;}
    .school-info-image{margin:0 auto;}
  }
  @media (max-width:480px){
    .account-card-content{padding:24px 20px;}
    .balance-amount{font-size:30px;}
    .account-number-value{font-size:18px;letter-spacing:1.5px;}
    .quick-amounts-grid{grid-template-columns:1fr;}
    .form-input{font-size:16px;}
  }
</style>

<div class="dashboard-wrapper">
  {{-- SIDEBAR --}}
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      {{-- TEMPAT LOGO SEKOLAH --}}
      <div class="school-logo-section">
        <div class="school-logo-wrapper">
          <img src="{{ asset('images\logo-sekolah.png') }}" alt="Logo Sekolah">
        </div>
      </div>

      <div class="sidebar-brand">
        <div class="brand-text">
          <h3>Bank Mini Tsamaniyah</h3>
          <p>Simpan Pinjam Sekolah</p>
        </div>
      </div>
    </div>

    <nav class="sidebar-menu">
      <div class="menu-section-label">Menu Utama</div>
      <a href="#" class="menu-item active" data-section="dashboard">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="#" class="menu-item" data-section="transactions">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Transaksi</span>
      </a>
      <a href="#" class="menu-item" data-section="profile">
        <i class="bi bi-person-circle"></i>
        <span>Profil Saya</span>
      </a>

      <div class="menu-section-label">Transaksi Cepat</div>
      <a href="#" class="menu-item" data-section="dashboard" data-scroll="#setor-form">
        <i class="bi bi-arrow-down-circle"></i>
        <span>Request Setor</span>
      </a>
      <a href="#" class="menu-item" data-section="dashboard" data-scroll="#tarik-form">
        <i class="bi bi-arrow-up-circle"></i>
        <span>Request Tarik</span>
      </a>

      <div class="menu-section-label">Lainnya</div>
      <a href="{{ route('logout') }}" class="menu-item" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i>
        <span>Keluar</span>
      </a>
    </nav>
  </aside>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>

  {{-- OVERLAY --}}
  <div class="overlay" id="overlay"></div>

    @php
      $fotoUrl = null;
      if (!empty($nasabah?->foto)) {
          $p = $nasabah->foto;
          if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) {
              $fotoUrl = $p;
          } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($p)) {
              $fotoUrl = \Illuminate\Support\Facades\Storage::url($p);
          } elseif (file_exists(public_path($p))) {
              $fotoUrl = asset($p);
          } else {
              $fotoUrl = asset('storage/'.$p);
          }
      }
    @endphp

  {{-- MAIN CONTENT --}}
  <main class="main-content">
    {{-- TOP HEADER --}}
    <header class="top-header">
      <button class="hamburger-btn" id="btnOpen">
        <i class="bi bi-list"></i>
        <span style="font-weight:700;">Menu</span>
      </button>

      <div class="welcome-section">
        <div class="welcome-icon">
          <i class="bi bi-house-heart-fill"></i>
        </div>
        <div class="welcome-text">
          <h3 id="pageTitle">Dashboard Nasabah</h3>
          <p id="pageSubtitle">Halo, {{ Auth::user()->name }}! Selamat datang kembali.</p>
        </div>
      </div>

      <div class="header-actions">
        <div class="time-display">
          <i class="bi bi-clock-fill"></i>
          <span id="currentTime">--:--:--</span>
        </div>
        <div class="user-profile-btn">
        @if($fotoUrl)
          <img src="{{ $fotoUrl }}" alt="{{ $nasabah->nama ?? Auth::user()->name }}">
        @else
          {{ strtoupper(substr(Auth::user()->name,0,1)) }}
        @endif
      </div>
      </div>
    </header>

    {{-- NOTIFICATIONS --}}
    @if(session('success'))
      <div class="notification-card success">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if(session('error'))
      <div class="notification-card error">
        <i class="bi bi-x-circle-fill"></i>
        <span>{{ session('error') }}</span>
      </div>
    @endif
    @if(session('info'))
      <div class="notification-card info">
        <i class="bi bi-info-circle-fill"></i>
        <span>{{ session('info') }}</span>
      </div>
    @endif

    {{-- =================== SECTION: DASHBOARD =================== --}}
    <section id="section-dashboard" class="section active">
      @if(isset($rekening))
        {{-- OPTIONAL: INFO BANNER SEKOLAH --}}
        <div class="school-info-banner">
          <div class="school-info-image">
          <img src="{{ asset('images\logo-bank-mini.png') }}" alt="Sekolah">
          </div>
          <div class="school-info-content">
            <h4>Bank Mini Tsamaniyah</h4>
            <p>Sistem tabungan sekolah yang aman, mudah, dan terpercaya untuk seluruh siswa dan guru.</p>
          </div>
        </div>

        {{-- HERO ACCOUNT CARD --}}
        <div class="hero-account-card">
          {{-- OPTIONAL: Background Image --}}
          <div class="hero-card-bg-image">
            <img src="{{ asset('images\gapura-sekolah.png') }}" alt="Sekolah">
          </div>

          <div class="account-card-content">
            <div class="account-top-row">
              <div class="account-chip"></div>
              <div class="card-type-badge">SIMPANAN</div>
            </div>

            <div class="account-number-section">
              <div class="account-number-label">Nomor Rekening</div>
              <div class="account-number-display">
                <div class="account-number-value">{{ $rekening->no_rekening }}</div>
                <button class="copy-account-btn" onclick="copyAccountNumber('{{ $rekening->no_rekening }}')">
                  <i class="bi bi-clipboard"></i>
                </button>
              </div>
            </div>

            <div class="account-balance-section">
              <div class="balance-info">
                <div class="balance-label">Saldo Tersedia</div>
                <div class="balance-amount">Rp {{ number_format($rekening->saldo, 0, ',', '.') }}</div>
                <button class="balance-toggle-btn" onclick="toggleBalance()">
                  <i class="bi bi-eye-fill"></i>
                  <span>Sembunyikan Saldo</span>
                </button>
              </div>
              <div>
                @if($nasabah->status === 'AKTIF')
                  <div class="account-status-badge active">
                    <i class="bi bi-check-circle-fill"></i>
                    AKTIF
                  </div>
                @else
                  <div class="account-status-badge inactive">
                    <i class="bi bi-x-circle-fill"></i>
                    NONAKTIF
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        {{-- RULES SECTION --}}
        @if($setting)
          <div class="rules-section" id="pengaturan">
            <div class="rules-grid">
              <div class="rule-card">
                <div class="rule-icon-wrapper">
                  <i class="bi bi-arrow-down-circle-fill"></i>
                </div>
                <div class="rule-label">Minimal Setor</div>
                <div class="rule-value">Rp {{ number_format($setting->minimal_setor, 0, ',', '.') }}</div>
              </div>
              <div class="rule-card">
                <div class="rule-icon-wrapper">
                  <i class="bi bi-arrow-up-circle-fill"></i>
                </div>
                <div class="rule-label">Maksimal Setor</div>
                <div class="rule-value">Rp {{ number_format($setting->maksimal_setor, 0, ',', '.') }}</div>
              </div>
              <div class="rule-card">
                <div class="rule-icon-wrapper">
                  <i class="bi bi-arrow-down-square-fill"></i>
                </div>
                <div class="rule-label">Minimal Tarik</div>
                <div class="rule-value">Rp {{ number_format($setting->minimal_tarik, 0, ',', '.') }}</div>
              </div>
              <div class="rule-card">
                <div class="rule-icon-wrapper">
                  <i class="bi bi-arrow-up-square-fill"></i>
                </div>
                <div class="rule-label">Maksimal Tarik</div>
                <div class="rule-value">Rp {{ number_format($setting->maksimal_tarik, 0, ',', '.') }}</div>
              </div>
            </div>
          </div>
        @endif

        {{-- TRANSACTION FORMS --}}
        @if($nasabah->status === 'AKTIF')
          <div class="transaction-forms-section">
            <div class="forms-grid">
              {{-- DEPOSIT FORM --}}
              <div class="transaction-form-card" id="setor-form">
                <div class="form-card-header">
                  <div class="form-icon-wrapper deposit">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                  </div>
                  <h4>Request Setor</h4>
                </div>

                <div class="quick-amounts-section">
                  <div class="quick-amounts-label">Nominal Cepat</div>
                  <div class="quick-amounts-grid">
                    <button class="quick-amount-btn" onclick="setAmount('nominal_setor', 50000)">Rp 50.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_setor', 100000)">Rp 100.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_setor', 500000)">Rp 500.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_setor', 1000000)">Rp 1.000.000</button>
                  </div>
                </div>

                <form method="POST" action="{{ route('nasabah.deposit.request') }}">
                  @csrf
                  <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                  
                  <div class="form-input-wrapper">
                    <label class="form-input-label">Nominal Setor</label>
                    <div class="form-input-group">
                      <span class="input-prefix">Rp</span>
                      <input type="number" name="nominal" id="nominal_setor" 
                             placeholder="0" class="form-input" required min="1">
                    </div>
                  </div>

                  <button type="submit" class="submit-transaction-btn deposit">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                    Kirim Request Setor
                  </button>
                </form>
              </div>

              {{-- WITHDRAW FORM --}}
              <div class="transaction-form-card" id="tarik-form">
                <div class="form-card-header">
                  <div class="form-icon-wrapper withdraw">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                  </div>
                  <h4>Request Tarik</h4>
                </div>

                <div class="quick-amounts-section">
                  <div class="quick-amounts-label">Nominal Cepat</div>
                  <div class="quick-amounts-grid">
                    <button class="quick-amount-btn" onclick="setAmount('nominal_tarik', 50000)">Rp 50.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_tarik', 100000)">Rp 100.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_tarik', 500000)">Rp 500.000</button>
                    <button class="quick-amount-btn" onclick="setAmount('nominal_tarik', 1000000)">Rp 1.000.000</button>
                  </div>
                </div>

                <form method="POST" action="{{ route('nasabah.withdraw.request') }}">
                  @csrf
                  <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                  
                  <div class="form-input-wrapper">
                    <label class="form-input-label">Nominal Tarik</label>
                    <div class="form-input-group">
                      <span class="input-prefix">Rp</span>
                      <input type="number" name="nominal" id="nominal_tarik" 
                             placeholder="0" class="form-input" required min="1">
                    </div>
                  </div>

                  <button type="submit" class="submit-transaction-btn withdraw">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                    Kirim Request Tarik
                  </button>
                </form>
              </div>
            </div>
          </div>
        @else
          <div class="warning-alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <p>
              Akun Anda sedang <strong>NONAKTIF</strong>. Anda tidak dapat melakukan setor atau tarik. 
              <strong>Hubungi teller</strong> untuk mengaktifkan kembali akun Anda.
            </p>
          </div>
        @endif

      @else
        <div class="warning-alert">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <p>
            Anda belum memiliki rekening aktif. <strong>Silakan hubungi teller</strong> untuk membuat rekening baru.
          </p>
        </div>
      @endif
    </section>

    {{-- =================== SECTION: TRANSACTIONS =================== --}}
    <section id="section-transactions" class="section">
      <div class="history-section">
        <div class="history-header">
          <i class="bi bi-clock-history"></i>
          <h4>Riwayat Transaksi</h4>
        </div>

        <div class="table-container">
          <table class="transaction-table">
            <thead>
              <tr>
                <th>ID Transaksi</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @php
                $riwayat = optional($rekening)->transaksi ?? collect();
              @endphp

              @forelse($riwayat as $trx)
                <tr>
                  <td><span class="transaction-id">#{{ $trx->id }}</span></td>
                  <td>
                    <span class="transaction-type-badge {{ strtolower($trx->jenis) }}">
                      @if($trx->jenis === 'SETOR')
                        <i class="bi bi-arrow-down-circle-fill"></i>
                      @else
                        <i class="bi bi-arrow-up-circle-fill"></i>
                      @endif
                      {{ $trx->jenis }}
                    </span>
                  </td>
                  <td><strong>Rp {{ number_format($trx->nominal, 0, ',', '.') }}</strong></td>
                  <td>
                    <span class="transaction-status-badge {{ strtolower($trx->status) }}">
                      @if($trx->status === 'PENDING')
                        <i class="bi bi-clock-fill"></i>
                      @elseif($trx->status === 'APPROVED')
                        <i class="bi bi-check-circle-fill"></i>
                      @else
                        <i class="bi bi-x-circle-fill"></i>
                      @endif
                      {{ $trx->status }}
                    </span>
                  </td>
                  <td>{{ $trx->created_at->timezone(config('app.timezone','Asia/Jakarta'))->format('d M Y H:i') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">
                    <div class="empty-state">
                      <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                      </div>
                      <div class="empty-text">Belum ada transaksi</div>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </section>

    {{-- =================== SECTION: PROFILE =================== --}}
    <section id="section-profile" class="section">
      <div class="profile-section">
        <div class="profile-header">
          {{-- OPTIONAL: Background Image Banner --}}
          <div class="profile-banner-image">
            <img src="{{ asset('images\gapura-sekolah.png') }}" alt="Sekolah">
          </div>

          <div class="profile-header-content">
            <div class="profile-avatar-large">
              @if($fotoUrl)
                <img src="{{ $fotoUrl }}" alt="{{ $nasabah->nama }}">
              @else
                {{ strtoupper(substr($nasabah->nama,0,1)) }}
              @endif
            </div>
            <div class="profile-info">
              <h3>{{ $nasabah->nama }}</h3>
              <p>{{ $nasabah->email }}</p>
            </div>
            <div class="profile-status-tag">
              @if($nasabah->status === 'AKTIF')
                <i class="bi bi-check-circle-fill"></i>
                AKTIF
              @else
                <i class="bi bi-x-circle-fill"></i>
                {{ $nasabah->status }}
              @endif
            </div>
          </div>
        </div>

        <div class="profile-body">
          <div class="profile-grid">
            <div class="profile-item">
              <small class="profile-item-label">NIS/NIP</small>
              <div class="profile-item-value">{{ $nasabah->nis_nip ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small class="profile-item-label">Jenis Kelamin</small>
              <div class="profile-item-value">
                @if($nasabah->jenis_kelamin === 'L') Laki-laki
                @elseif($nasabah->jenis_kelamin === 'P') Perempuan
                @else - @endif
              </div>
            </div>
            <div class="profile-item">
              <small class="profile-item-label">No. HP</small>
              <div class="profile-item-value">{{ $nasabah->no_hp ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small class="profile-item-label">Alamat</small>
              <div class="profile-item-value">{{ $nasabah->alamat ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small class="profile-item-label">No. Rekening</small>
              <div class="profile-item-value">{{ optional($rekening)->no_rekening ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small class="profile-item-label">Saldo</small>
              <div class="profile-item-value">
                Rp {{ number_format(optional($rekening)->saldo ?? 0, 0, ',', '.') }}
              </div>
            </div>
            @if(optional($rekening)->tanggal_buka)
              <div class="profile-item">
                <small class="profile-item-label">Tanggal Buka Rekening</small>
                <div class="profile-item-value">
                  {{ \Carbon\Carbon::parse($rekening->tanggal_buka)->format('d M Y') }}
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  </main>

  {{-- MOBILE MENU BUTTON --}}
  <button class="mobile-menu-btn" id="btnFloat">
    <i class="bi bi-list"></i>
  </button>
</div>

<script>
  function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');
    const el = document.getElementById('currentTime');
    if (el) el.textContent = `${h}:${m}:${s}`;
}
updateClock();
setInterval(updateClock, 1000);

// Sidebar functionality
(function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btnOpen = document.getElementById('btnOpen');
    const btnFloat = document.getElementById('btnFloat');
    
    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('show');
    }
    
    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('show');
    }
    
    if (btnOpen) btnOpen.addEventListener('click', openSidebar);
    if (btnFloat) btnFloat.addEventListener('click', openSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 769) {
            closeSidebar();
            if (btnFloat) btnFloat.style.display = 'none';
        } else {
            if (btnFloat) btnFloat.style.display = 'flex';
        }
    });
    
    if (window.innerWidth < 769 && btnFloat) {
        btnFloat.style.display = 'flex';
    }
})();

function copyAccountNumber(accountNumber) {
    navigator.clipboard.writeText(accountNumber).then(function() {
        alert('Nomor rekening berhasil disalin!');
    }).catch(function(err) {
        console.error('Gagal menyalin:', err);
    });
}

let balanceVisible = true;
function toggleBalance() {
    const amountEl = document.querySelector('.balance-amount');
    const btnEl = document.querySelector('.balance-toggle-btn span');
    const iconEl = document.querySelector('.balance-toggle-btn i');
    if (!amountEl || !btnEl) return;
    
    if (!amountEl.dataset.original) {
        amountEl.dataset.original = amountEl.textContent.trim();
    }
    
    if (balanceVisible) {
        amountEl.textContent = 'Rp ••••••••';
        btnEl.textContent = 'Tampilkan Saldo';
        if (iconEl) iconEl.className = 'bi bi-eye-slash-fill';
    } else {
        amountEl.textContent = amountEl.dataset.original;
        btnEl.textContent = 'Sembunyikan Saldo';
        if (iconEl) iconEl.className = 'bi bi-eye-fill';
    }
    balanceVisible = !balanceVisible;
}

function setAmount(inputId, amount) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = amount;
        input.focus();
    }
}

function resetTransactionForms() {
    // Reset form inputs
    const setorInput = document.getElementById('nominal_setor');
    const tarikInput = document.getElementById('nominal_tarik');
    
    if (setorInput) setorInput.value = '';
    if (tarikInput) tarikInput.value = '';
    
    // Re-enable buttons dan reset text
    const buttons = document.querySelectorAll('.submit-transaction-btn');
    buttons.forEach(btn => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
        const originalText = btn.getAttribute('data-original-text');
        if (originalText) {
            btn.innerHTML = originalText;
        }
    });
}

document.addEventListener('input', function(e) {
    if (e.target.matches('.form-input[type="number"]')) {
        if (parseFloat(e.target.value) < 0) {
            e.target.value = 0;
        }
    }
});

// Section navigation
const menuItems = document.querySelectorAll('.menu-item[data-section]');
const sections = {
    dashboard: document.getElementById('section-dashboard'),
    transactions: document.getElementById('section-transactions'),
    profile: document.getElementById('section-profile')
};

const titleMap = {
    dashboard: { title: 'Dashboard Nasabah', sub: 'Halo, {{ addslashes(Auth::user()->name) }}! Selamat datang kembali.' },
    transactions: { title: 'Riwayat Transaksi', sub: 'Lihat semua transaksi Anda di sini.' },
    profile: { title: 'Profil Saya', sub: 'Detail data nasabah & rekening.' }
};

function switchSection(sectionName) {
    Object.values(sections).forEach(function(section) {
        if (section) section.classList.remove('active');
    });
    
    const targetSection = sections[sectionName] || sections.dashboard;
    if (targetSection) targetSection.classList.add('active');
    
    const config = titleMap[sectionName] || titleMap.dashboard;
    const titleEl = document.getElementById('pageTitle');
    const subtitleEl = document.getElementById('pageSubtitle');
    
    if (titleEl) titleEl.textContent = config.title;
    if (subtitleEl) subtitleEl.textContent = config.sub;
    
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('show');
    
    menuItems.forEach(function(item) {
        const isActive = item.dataset.section === sectionName && !item.dataset.scroll;
        if (isActive) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

menuItems.forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const targetSection = item.dataset.section || 'dashboard';
        switchSection(targetSection);
        
        const scrollTarget = item.dataset.scroll;
        if (scrollTarget && sections.dashboard && sections.dashboard.classList.contains('active')) {
            setTimeout(function() {
                const element = document.querySelector(scrollTarget);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        }
    });
});

// Form submit handlers
document.querySelectorAll('form').forEach(function(form) {
    const btn = form.querySelector('.submit-transaction-btn');
    if (btn && !btn.getAttribute('data-original-text')) {
        btn.setAttribute('data-original-text', btn.innerHTML);
    }
    
    form.addEventListener('submit', function(e) {
        if (btn) {
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
        }
    });
});

// Auto-dismiss notifications after 5 seconds
setTimeout(function() {
    const notifications = document.querySelectorAll('.notification-card');
    notifications.forEach(function(notification) {
        notification.style.transition = 'all 0.5s ease';
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(function() {
            notification.remove();
        }, 500);
    });
}, 5000);

// Reset forms dan scroll ke top untuk success/error messages
@if(session('success'))
    setTimeout(function() {
        resetTransactionForms();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 100);
@endif

@if(session('error'))
    setTimeout(function() {
        // Re-enable buttons saja untuk error
        const buttons = document.querySelectorAll('.submit-transaction-btn');
        buttons.forEach(btn => {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            const originalText = btn.getAttribute('data-original-text');
            if (originalText) {
                btn.innerHTML = originalText;
            }
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 100);
@endif

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btnOpen = document.getElementById('btnOpen');
    const btnFloat = document.getElementById('btnFloat');
    
    if (window.innerWidth <= 768) {
        const clickedInside = sidebar && sidebar.contains(e.target);
        const clickedButton = (btnOpen && btnOpen.contains(e.target)) || (btnFloat && btnFloat.contains(e.target));
        
        if (!clickedInside && !clickedButton) {
            if (overlay) overlay.classList.remove('show');
            if (sidebar) sidebar.classList.remove('active');
        }
    }
});

</script>

@endsection