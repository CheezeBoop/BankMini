@extends('layouts.app')

@section('title', 'Akses Layanan Bank Mini')

@push('styles')
<style>
:root{
  --primary-green:#2C5F2D;
  --primary-dark-green:#1a3a1b;
  --primary-light-green:#97BC62;
  --accent-gold:#FFD93D;
  --accent-yellow:#ffc107;
  --accent-red:#dc3545;
  --bg-white:#ffffff;
  --bg-cream:#FFF8E7;
  --bg-light:#f8f9fa;
  --text-dark:#212529;
  --text-grey:#495057;
  --text-light:#6c757d;
  --border-light:#dee2e6;
  --shadow-soft:0 2px 8px rgba(0,0,0,.05);
  --shadow-medium:0 4px 16px rgba(0,0,0,.12);
  --shadow-strong:0 8px 32px rgba(0,0,0,.16);
  --gradient-green:linear-gradient(135deg,#2C5F2D 0%,#97BC62 100%);
  --gradient-gold:linear-gradient(135deg,#FFD93D 0%,#ffc107 100%);
  --gradient-cream:linear-gradient(135deg,#ffffff 0%,#FFF8E7 100%);
}

body {
  background: var(--gradient-cream);
  min-height: 100vh;
  position: relative;
  overflow-x: hidden;
}

/* Background Animations */
.bg-decoration {
  position: fixed;
  inset: 0;
  z-index: -1;
  overflow: hidden;
  pointer-events: none;
}

.floating-shape {
  position: absolute;
  background: rgba(151, 188, 98, 0.08);
  border-radius: 50%;
  animation: float 8s ease-in-out infinite;
}

.floating-shape:nth-child(1) {
  width: 120px;
  height: 120px;
  top: 10%;
  left: 5%;
  animation-delay: 0s;
}

.floating-shape:nth-child(2) {
  width: 180px;
  height: 180px;
  top: 60%;
  right: 8%;
  animation-delay: 2s;
}

.floating-shape:nth-child(3) {
  width: 100px;
  height: 100px;
  bottom: 15%;
  left: 15%;
  animation-delay: 4s;
}

.floating-shape:nth-child(4) {
  width: 150px;
  height: 150px;
  top: 30%;
  right: 25%;
  animation-delay: 1s;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0) rotate(0deg);
  }
  50% {
    transform: translateY(-30px) rotate(5deg);
  }
}

.pattern-overlay {
  position: fixed;
  inset: 0;
  z-index: -1;
  opacity: 0.03;
  background-image: 
    repeating-linear-gradient(45deg, var(--primary-green) 0, var(--primary-green) 1px, transparent 1px, transparent 10px),
    repeating-linear-gradient(-45deg, var(--primary-green) 0, var(--primary-green) 1px, transparent 1px, transparent 10px);
  animation: patternSlide 20s linear infinite;
}

@keyframes patternSlide {
  0% { background-position: 0 0; }
  100% { background-position: 50px 50px; }
}

/* Action Section */
.action-section {
  padding: 4rem 1rem;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  max-width: 1400px;
  margin: 0 auto;
}

.action-header {
  margin-bottom: 4rem;
  position: relative;
  animation: fadeInDown 0.8s ease-out;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.action-title {
  font-size: 3.5rem;
  font-weight: 800;
  background: var(--gradient-green);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 1rem;
  position: relative;
  display: inline-block;
  animation: titleGlow 3s ease-in-out infinite;
}

@keyframes titleGlow {
  0%, 100% {
    filter: drop-shadow(0 0 8px rgba(151, 188, 98, 0.3));
  }
  50% {
    filter: drop-shadow(0 0 16px rgba(151, 188, 98, 0.5));
  }
}

.action-title::after {
  content: '';
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 5px;
  background: var(--gradient-gold);
  border-radius: 3px;
  animation: underlineExpand 2s ease-in-out infinite;
}

@keyframes underlineExpand {
  0%, 100% {
    width: 80px;
  }
  50% {
    width: 120px;
  }
}

.action-subtitle {
  font-size: 1.4rem;
  color: var(--text-grey);
  font-weight: 500;
}

/* Action Cards Container */
.action-cards-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
  gap: 3rem;
  max-width: 1200px;
  margin: 0 auto;
  width: 100%;
  animation: fadeInUp 1s ease-out 0.3s both;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Action Card */
.action-card {
  position: relative;
  background: var(--bg-white);
  border-radius: 28px;
  overflow: hidden;
  box-shadow: var(--shadow-medium);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 2px solid transparent;
  cursor: pointer;
}

.action-card::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: conic-gradient(
    from 0deg,
    transparent,
    rgba(151, 188, 98, 0.1),
    transparent
  );
  animation: cardRotate 4s linear infinite;
  opacity: 0;
  transition: opacity 0.4s;
}

@keyframes cardRotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.action-card:hover::before {
  opacity: 1;
}

.action-card:hover {
  transform: translateY(-12px) scale(1.02);
  box-shadow: var(--shadow-strong);
  border-color: var(--primary-light-green);
}

.action-card:nth-child(1):hover {
  border-color: var(--primary-green);
}

.action-card:nth-child(2):hover {
  border-color: var(--accent-gold);
}

/* Card Image Area */
.action-card-image-wrapper {
  position: relative;
  height: 280px;
  overflow: hidden;
  background: linear-gradient(135deg, #e9ecef, #f8f9fa);
}

.action-card-image-wrapper::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    transparent 0%,
    rgba(0, 0, 0, 0.1) 100%
  );
  z-index: 1;
}

.action-card-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.action-card:hover .action-card-image {
  transform: scale(1.15) rotate(2deg);
}

.action-card-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: var(--gradient-gold);
  color: var(--primary-dark-green);
  padding: 0.6rem 1.2rem;
  border-radius: 20px;
  font-weight: 700;
  font-size: 0.85rem;
  box-shadow: var(--shadow-medium);
  z-index: 2;
  animation: badgePulse 2s ease-in-out infinite;
}

@keyframes badgePulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.08);
  }
}

/* Card Content */
.action-card-content {
  padding: 2.5rem;
  position: relative;
  z-index: 2;
}

.action-card-icon-wrapper {
  width: 90px;
  height: 90px;
  background: var(--gradient-green);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: -60px auto 1.5rem;
  box-shadow: 0 10px 30px rgba(44, 95, 45, 0.3);
  position: relative;
  animation: iconFloat 3s ease-in-out infinite;
}

@keyframes iconFloat {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.action-card-icon-wrapper::before {
  content: '';
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  border: 3px solid var(--primary-light-green);
  opacity: 0.3;
  animation: iconPulse 2s ease-out infinite;
}

@keyframes iconPulse {
  0% {
    transform: scale(1);
    opacity: 0.3;
  }
  100% {
    transform: scale(1.4);
    opacity: 0;
  }
}

.action-card-icon {
  font-size: 2.5rem;
  color: white;
}

.action-card:nth-child(2) .action-card-icon-wrapper {
  background: var(--gradient-gold);
}

.action-card:nth-child(2) .action-card-icon {
  color: var(--primary-dark-green);
}

.action-card-title {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--text-dark);
  margin-bottom: 1rem;
  transition: color 0.3s;
}

.action-card:hover .action-card-title {
  color: var(--primary-green);
}

.action-card-description {
  color: var(--text-grey);
  line-height: 1.8;
  margin-bottom: 2rem;
  font-size: 1.05rem;
}

.action-card-features {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: var(--bg-light);
  border-radius: 16px;
  border-left: 4px solid var(--primary-light-green);
}

.action-card:nth-child(2) .action-card-features {
  border-left-color: var(--accent-gold);
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  color: var(--text-grey);
  font-size: 0.95rem;
  transition: transform 0.3s;
}

.feature-item:hover {
  transform: translateX(5px);
}

.feature-item i {
  color: var(--primary-green);
  font-size: 1.1rem;
  min-width: 20px;
}

.action-card:nth-child(2) .feature-item i {
  color: var(--accent-gold);
}

/* Buttons */
.action-btn {
  width: 100%;
  padding: 1.3rem 2rem;
  border: none;
  border-radius: 14px;
  font-size: 1.15rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.8rem;
  position: relative;
  overflow: hidden;
  text-decoration: none;
}

.action-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.action-btn:hover::before {
  width: 400px;
  height: 400px;
}

.btn-primary-custom {
  background: var(--gradient-green);
  color: white;
  box-shadow: 0 8px 20px rgba(44, 95, 45, 0.3);
}

.btn-primary-custom:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(44, 95, 45, 0.4);
  color: white;
}

.btn-outline-custom {
  background: transparent;
  border: 2px solid var(--accent-gold);
  color: var(--primary-dark-green);
  box-shadow: 0 4px 15px rgba(255, 217, 61, 0.2);
}

.btn-outline-custom:hover {
  background: var(--gradient-gold);
  color: var(--primary-dark-green);
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(255, 217, 61, 0.4);
}

.action-btn i {
  font-size: 1.2rem;
  transition: transform 0.3s;
}

.action-btn:hover i {
  transform: translateX(5px);
}

.btn-outline-custom:hover i {
  animation: bounce 0.6s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

/* Location Modal */
.location-modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(5px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 1rem;
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.location-modal.show {
  display: flex;
}

.location-modal-content {
  background: var(--bg-white);
  border-radius: 28px;
  max-width: 900px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: var(--shadow-strong);
  animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(50px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.location-modal-header {
  background: var(--gradient-green);
  color: white;
  padding: 2.5rem;
  position: relative;
  overflow: hidden;
}

.location-modal-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(
    circle,
    rgba(255, 217, 61, 0.15) 0%,
    transparent 70%
  );
  animation: glow 4s ease-in-out infinite;
}

@keyframes glow {
  0%, 100% {
    transform: translate(0, 0) scale(1);
  }
  50% {
    transform: translate(-20px, -20px) scale(1.1);
  }
}

.modal-close-btn {
  position: absolute;
  top: 1.5rem;
  right: 1.5rem;
  width: 45px;
  height: 45px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
  z-index: 10;
}

.modal-close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: rotate(90deg);
}

.modal-close-btn i {
  font-size: 1.5rem;
  color: white;
}

.location-modal-title {
  font-size: 2.2rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
  position: relative;
  z-index: 1;
}

.location-modal-subtitle {
  font-size: 1.1rem;
  opacity: 0.9;
  position: relative;
  z-index: 1;
}

.location-modal-body {
  padding: 2.5rem;
}

.location-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.location-info-card {
  background: var(--bg-light);
  padding: 2rem;
  border-radius: 20px;
  border-left: 5px solid var(--primary-light-green);
  transition: all 0.3s;
  position: relative;
  overflow: hidden;
}

.location-info-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 5px;
  height: 0;
  background: var(--gradient-gold);
  transition: height 0.3s;
}

.location-info-card:hover {
  transform: translateX(8px);
  box-shadow: var(--shadow-soft);
}

.location-info-card:hover::before {
  height: 100%;
}

.location-info-icon {
  width: 55px;
  height: 55px;
  background: var(--gradient-green);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.2rem;
  box-shadow: var(--shadow-soft);
}

.location-info-icon i {
  font-size: 1.5rem;
  color: white;
}

.location-info-card:nth-child(2) .location-info-icon,
.location-info-card:nth-child(4) .location-info-icon {
  background: var(--gradient-gold);
}

.location-info-card:nth-child(2) .location-info-icon i,
.location-info-card:nth-child(4) .location-info-icon i {
  color: var(--primary-dark-green);
}

.location-info-title {
  font-weight: 700;
  color: var(--text-dark);
  font-size: 1.15rem;
  margin-bottom: 0.8rem;
}

.location-info-text {
  color: var(--text-grey);
  line-height: 1.7;
  font-size: 0.95rem;
}

.location-requirements {
  background: linear-gradient(135deg, var(--bg-cream), white);
  padding: 2rem;
  border-radius: 20px;
  border: 2px solid var(--accent-gold);
  margin-bottom: 2rem;
}

.requirements-title {
  font-weight: 700;
  color: var(--primary-green);
  font-size: 1.3rem;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.requirements-title i {
  color: var(--accent-gold);
  font-size: 1.5rem;
}

.requirements-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.requirement-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: white;
  border-radius: 12px;
  box-shadow: var(--shadow-soft);
  transition: all 0.3s;
}

.requirement-item:hover {
  transform: translateX(8px);
  box-shadow: var(--shadow-medium);
}

.requirement-icon {
  width: 40px;
  height: 40px;
  background: var(--gradient-green);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.requirement-icon i {
  color: white;
  font-size: 1rem;
}

.requirement-text {
  color: var(--text-grey);
  font-size: 0.95rem;
}

.location-warning {
  background: linear-gradient(135deg, #fff5f5, #ffe6e6);
  padding: 1.8rem;
  border-radius: 16px;
  border-left: 5px solid var(--accent-red);
  display: flex;
  align-items: center;
  gap: 1.2rem;
  animation: warningPulse 2s ease-in-out infinite;
}

@keyframes warningPulse {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
  }
  50% {
    box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
  }
}

.warning-icon {
  width: 50px;
  height: 50px;
  background: var(--accent-red);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  animation: warningBounce 2s ease-in-out infinite;
}

@keyframes warningBounce {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}

.warning-icon i {
  color: white;
  font-size: 1.5rem;
}

.warning-text {
  color: var(--accent-red);
  font-weight: 700;
  font-size: 1.1rem;
  line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 1200px) {
  .action-cards-wrapper {
    grid-template-columns: 1fr;
    max-width: 600px;
  }
}

@media (max-width: 768px) {
  .action-section {
    padding: 3rem 1rem;
  }
  
  .action-title {
    font-size: 2.5rem;
  }
  
  .action-subtitle {
    font-size: 1.1rem;
  }
  
  .action-card-image-wrapper {
    height: 220px;
  }
  
  .action-card-content {
    padding: 2rem;
  }
  
  .action-card-icon-wrapper {
    width: 75px;
    height: 75px;
  }
  
  .action-card-icon {
    font-size: 2rem;
  }
  
  .action-card-title {
    font-size: 1.5rem;
  }
  
  .location-info-grid {
    grid-template-columns: 1fr;
  }
  
  .location-modal-body {
    padding: 1.5rem;
  }
}

@media (max-width: 480px) {
  .action-title {
    font-size: 2rem;
  }
  
  .action-card-image-wrapper {
    height: 180px;
  }
  
  .action-card-content {
    padding: 1.5rem;
  }
  
  .action-btn {
    padding: 1.1rem 1.5rem;
    font-size: 1rem;
  }
  
  .location-modal-header {
    padding: 2rem 1.5rem;
  }
  
  .location-modal-title {
    font-size: 1.8rem;
  }
}

/* Scroll Animation */
.scroll-animate {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.scroll-animate.active {
  opacity: 1;
  transform: translateY(0);
}

/* Custom Scrollbar */
.location-modal-content::-webkit-scrollbar {
  width: 8px;
}

.location-modal-content::-webkit-scrollbar-track {
  background: var(--bg-light);
  border-radius: 10px;
}

.location-modal-content::-webkit-scrollbar-thumb {
  background: var(--primary-light-green);
  border-radius: 10px;
}

.location-modal-content::-webkit-scrollbar-thumb:hover {
  background: var(--primary-green);
}
</style>
@endpush

@section('content')
<!-- Background Decoration -->
<div class="bg-decoration">
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
</div>
<div class="pattern-overlay"></div>

<section class="action-section">
  <div class="action-header text-center">
    <h2 class="action-title">Akses Layanan Bank Mini</h2>
    <p class="action-subtitle">Pilih opsi yang sesuai dengan kebutuhan Anda</p>
  </div>
  
  <div class="action-cards-wrapper">
    <!-- Card Login -->
    <div class="action-card scroll-animate">
      <div class="action-card-image-wrapper">
        <img src="{{ asset('images/bank-salam.png') }}" alt="Login Bank Mini" class="action-card-image">
        <div class="action-card-badge">
          <i class="fas fa-shield-alt"></i> Akun Terdaftar
        </div>
      </div>
      <div class="action-card-content">
        <div class="action-card-icon-wrapper">
          <i class="fas fa-user-check action-card-icon"></i>
        </div>
        <h3 class="action-card-title">Sudah Punya Akun</h3>
        <p class="action-card-description">
          Masuk ke akun banking Anda untuk mengakses layanan perbankan online, melihat saldo, melakukan transaksi, dan mengelola keuangan dengan mudah dan aman.
        </p>
        
        <div class="action-card-features">
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Akses saldo real-time</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Transaksi aman & cepat</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Riwayat transaksi lengkap</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Notifikasi otomatis</span>
          </div>
        </div>
        
        <a href="{{ route('login') }}" class="action-btn btn-primary-custom">
          <i class="fas fa-sign-in-alt"></i>
          <span>Masuk ke Akun</span>
        </a>
      </div>
    </div>

    <!-- Card Daftar -->
    <div class="action-card scroll-animate">
      <div class="action-card-image-wrapper">
        <img src="{{ asset('images/bank-salam-2.png') }}" alt="Daftar Bank Mini" class="action-card-image">
        <div class="action-card-badge">
          <i class="fas fa-star"></i> Gratis
        </div>
      </div>
      <div class="action-card-content">
        <div class="action-card-icon-wrapper">
          <i class="fas fa-user-plus action-card-icon"></i>
        </div>
        <h3 class="action-card-title">Belum Punya Akun</h3>
        <p class="action-card-description">
          Daftarkan diri Anda secara langsung di lokasi Bank Mini Tsamaniyah untuk mendapatkan akses layanan perbankan. Bawa ID Card/Kartu Pelajar Anda.
        </p>
        
        <div class="action-card-features">
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Pendaftaran mudah & cepat</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Gratis tanpa biaya admin</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Langsung aktif hari itu</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle"></i>
            <span>Bimbingan dari staf</span>
          </div>
        </div>
        
        <button class="action-btn btn-outline-custom" onclick="showLocationModal()">
          <i class="fas fa-map-marker-alt"></i>
          <span>Lihat Lokasi</span>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Location Modal -->
<div class="location-modal" id="locationModal">
  <div class="location-modal-content">
    <div class="location-modal-header">
      <button class="modal-close-btn" onclick="closeLocationModal()">
        <i class="fas fa-times"></i>
      </button>
      <h3 class="location-modal-title">
        <i class="fas fa-map-marked-alt"></i>
        Lokasi Bank Mini Tsamaniyah
      </h3>
      <p class="location-modal-subtitle">
        Kunjungi kami untuk pendaftaran akun baru dan layanan perbankan
      </p>
    </div>
    
    <div class="location-modal-body">
      <div class="location-info-grid">
        <div class="location-info-card">
          <div class="location-info-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h4 class="location-info-title">Alamat Lengkap</h4>
          <div class="location-info-text">
            <strong>Bank Mini Tsamaniyah</strong><br>
            SMK Negeri 8 Jakarta<br>
            Samping Business Centre, Lantai 1<br>
            Jl. Raya Pejaten, Pasar Minggu<br>
            Jakarta Selatan 12510
          </div>
        </div>
        
        <div class="location-info-card">
          <div class="location-info-icon">
            <i class="fas fa-clock"></i>
          </div>
          <h4 class="location-info-title">Jam Operasional</h4>
          <div class="location-info-text">
            <strong>Senin - Jumat</strong><br>
            08:00 - 14:00 WIB<br>
            <strong>Istirahat:</strong> 12:00 - 12:30 WIB<br>
            <strong>Sabtu & Minggu:</strong> Tutup
          </div>
        </div>
        
        <div class="location-info-card">
          <div class="location-info-icon">
            <i class="fas fa-phone"></i>
          </div>
          <h4 class="location-info-title">Kontak</h4>
          <div class="location-info-text">
            <strong>Telepon:</strong><br>
            (021) 7972362<br>
            <strong>Email:</strong><br>
            bankmini@smkn8jkt.sch.id
          </div>
        </div>
        
        <div class="location-info-card">
          <div class="location-info-icon">
            <i class="fas fa-route"></i>
          </div>
          <h4 class="location-info-title">Akses Transportasi</h4>
          <div class="location-info-text">
            <strong>TransJakarta:</strong> Koridor 6<br>
            <strong>Halte:</strong> Pejaten<br>
            <strong>Angkutan:</strong> M18, T70<br>
            <strong>Parkir:</strong> Tersedia
          </div>
        </div>
      </div>
      
      <div class="location-requirements">
        <h4 class="requirements-title">
          <i class="fas fa-clipboard-list"></i>
          Persyaratan Pendaftaran
        </h4>
        <div class="requirements-list">
          <div class="requirement-item">
            <div class="requirement-icon">
              <i class="fas fa-id-card"></i>
            </div>
            <div class="requirement-text">
              <strong>Kartu Identitas:</strong> KTM atau Kartu Pelajar SMKN 8 Jakarta yang masih aktif
            </div>
          </div>
          <div class="requirement-item">
            <div class="requirement-icon">
              <i class="fas fa-copy"></i>
            </div>
            <div class="requirement-text">
              <strong>Fotocopy:</strong> KTP/Kartu Pelajar (1 lembar) untuk arsip bank
            </div>
          </div>
          <div class="requirement-item">
            <div class="requirement-icon">
              <i class="fas fa-portrait"></i>
            </div>
            <div class="requirement-text">
              <strong>Pas Foto:</strong> Ukuran 3x4 berwarna (1 lembar) dengan background merah
            </div>
          </div>
          <div class="requirement-item">
            <div class="requirement-icon">
              <i class="fas fa-file-signature"></i>
            </div>
            <div class="requirement-text">
              <strong>Formulir:</strong> Akan diberikan dan diisi di tempat saat pendaftaran
            </div>
          </div>
        </div>
      </div>
      
      <div class="location-warning">
        <div class="warning-icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="warning-text">
          <strong>Penting!</strong> Pendaftaran akun Bank Mini Tsamaniyah hanya dapat dilakukan secara langsung di lokasi. Pendaftaran online tidak tersedia saat ini.
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Show Location Modal
function showLocationModal() {
  const modal = document.getElementById('locationModal');
  modal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

// Close Location Modal
function closeLocationModal() {
  const modal = document.getElementById('locationModal');
  modal.classList.remove('show');
  document.body.style.overflow = 'auto';
}

// Close modal on background click
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('locationModal');
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeLocationModal();
    }
  });
  
  // Close on ESC key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeLocationModal();
    }
  });
  
  // Scroll Animation
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
      }
    });
  }, observerOptions);
  
  document.querySelectorAll('.scroll-animate').forEach(el => {
    observer.observe(el);
  });
  
  // Button Ripple Effect
  document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const ripple = document.createElement('span');
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      ripple.style.position = 'absolute';
      ripple.style.borderRadius = '50%';
      ripple.style.background = 'rgba(255, 255, 255, 0.6)';
      ripple.style.pointerEvents = 'none';
      ripple.style.transform = 'scale(0)';
      ripple.style.transition = 'transform 0.6s, opacity 0.6s';
      ripple.style.zIndex = '1';
      
      this.appendChild(ripple);
      
      requestAnimationFrame(() => {
        ripple.style.transform = 'scale(2)';
        ripple.style.opacity = '0';
      });
      
      setTimeout(() => ripple.remove(), 600);
    });
  });
  
  // Card hover parallax effect
  document.querySelectorAll('.action-card').forEach(card => {
    card.addEventListener('mousemove', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      
      const rotateX = (y - centerY) / 20;
      const rotateY = (centerX - x) / 20;
      
      this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px) scale(1.02)`;
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0) scale(1)';
    });
  });
});
</script>
@endpush