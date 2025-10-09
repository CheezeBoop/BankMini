<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bank Mini Tsamaniyah - SMKN 8 Jakarta</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{--primary-green:#2C5F2D;--primary-dark-green:#1a3a1b;--primary-light-green:#97BC62;--accent-gold:#FFD93D;--accent-yellow:#ffc107;--accent-red:#dc3545;--bg-white:#ffffff;--bg-cream:#FFF8E7;--bg-light:#f8f9fa;--text-dark:#212529;--text-grey:#495057;--text-light:#6c757d;--border-light:#dee2e6;--shadow-soft:0 2px 8px rgba(0,0,0,.05);--shadow-medium:0 4px 16px rgba(0,0,0,.12);--shadow-strong:0 8px 32px rgba(0,0,0,.16);--gradient-green:linear-gradient(135deg,#2C5F2D 0%,#97BC62 100%);--gradient-gold:linear-gradient(135deg,#FFD93D 0%,#ffc107 100%);--gradient-cream:linear-gradient(135deg,#ffffff 0%,#FFF8E7 100%);}
    *{margin:0;padding:0;box-sizing:border-box}html,body{height:auto;scroll-behavior:smooth}body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background:var(--gradient-cream);color:var(--text-dark);overflow-x:hidden;overflow-y:auto;position:relative}
    
    .bg-animation{position:fixed;inset:0;z-index:-1;overflow:hidden}.floating-shapes{position:absolute;inset:0}.shape{position:absolute;background:rgba(32,201,151,.08);border-radius:50%;animation:float 8s ease-in-out infinite}.shape:nth-child(1){width:100px;height:100px;top:10%;left:10%;animation-delay:0s}.shape:nth-child(2){width:150px;height:150px;top:60%;left:80%;animation-delay:2s}.shape:nth-child(3){width:80px;height:80px;top:80%;left:20%;animation-delay:4s}.shape:nth-child(4){width:120px;height:120px;top:30%;left:70%;animation-delay:1s}@keyframes float{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-25px) rotate(5deg)}}
    .pattern-overlay{position:fixed;inset:0;z-index:-1;opacity:.03;background-image:repeating-linear-gradient(45deg,var(--primary-green) 0,var(--primary-green) 1px,transparent 1px,transparent 10px),repeating-linear-gradient(-45deg,var(--primary-green) 0,var(--primary-green) 1px,transparent 1px,transparent 10px);animation:patternSlide 20s linear infinite}@keyframes patternSlide{0%{background-position:0 0}100%{background-position:50px 50px}}

    /* Hero Section */
    .hero-section{position:relative;width:100%;max-width:1400px;margin:0 auto;padding:2rem 1rem;overflow:hidden}.hero-container{background:var(--bg-white);border-radius:32px;box-shadow:var(--shadow-strong);overflow:hidden;position:relative}.hero-content{display:grid;grid-template-columns:1fr 1fr;min-height:600px}
    
    .hero-left{background:var(--gradient-green);padding:4rem;display:flex;flex-direction:column;justify-content:center;position:relative;overflow:hidden;color:#fff}.hero-left::before{content:'';position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff10"><circle cx="50" cy="50" r="2"/></svg>');animation:sparkle 25s linear infinite;opacity:.4}@keyframes sparkle{0%{transform:translate(0,0)}100%{transform:translate(-100px,-100px)}}
    
    .hero-logo-container{display:flex;align-items:center;gap:1.5rem;margin-bottom:2.5rem;position:relative;z-index:2}.hero-logo-wrapper{position:relative;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.1);backdrop-filter:blur(10px);border:3px solid rgba(255,217,61,.3);padding:8px;box-shadow:0 8px 32px rgba(0,0,0,.2)}.hero-logo-img{width:100%;height:100%;object-fit:cover;border-radius:50%;background:var(--gradient-gold);display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--primary-green);animation:logoPulse 3s infinite}@keyframes logoPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}.hero-logo-placeholder{width:100%;height:100%;border-radius:50%;background:var(--gradient-gold);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:.5rem;font-size:2.5rem;color:var(--primary-green)}.hero-logo-placeholder i{font-size:3rem}.hero-logo-placeholder small{font-size:.7rem;font-weight:600}
    .hero-logo-text{flex:1}.hero-logo-title{font-size:2.5rem;font-weight:800;color:#fff;text-shadow:2px 2px 4px rgba(0,0,0,.2);margin-bottom:.5rem}.hero-logo-subtitle{font-size:1.1rem;opacity:.9;font-weight:500}
    
    .hero-tagline{font-size:2rem;margin-bottom:1.5rem;font-weight:700;line-height:1.3;position:relative;z-index:2;text-shadow:2px 2px 4px rgba(0,0,0,.1)}.hero-description{font-size:1.1rem;line-height:1.7;margin-bottom:2rem;opacity:.95;position:relative;z-index:2}
    
    .hero-cta-btn{display:inline-flex;align-items:center;gap:.8rem;padding:1.2rem 2.5rem;background:var(--gradient-gold);color:var(--primary-dark-green);border:none;border-radius:14px;font-size:1.15rem;font-weight:700;text-decoration:none;cursor:pointer;transition:all .3s;box-shadow:0 8px 20px rgba(255,217,61,.3);position:relative;z-index:2;overflow:hidden}.hero-cta-btn::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;background:rgba(255,255,255,.3);border-radius:50%;transform:translate(-50%,-50%);transition:width .6s,height .6s}.hero-cta-btn:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(255,217,61,.4)}.hero-cta-btn:hover::before{width:400px;height:400px}.hero-cta-btn i{font-size:1.3rem;transition:transform .3s}.hero-cta-btn:hover i{transform:translateX(5px)}
    
    .hero-features{display:grid;grid-template-columns:1fr 1fr;gap:1rem;position:relative;z-index:2;margin-top:2rem}.hero-feature{display:flex;align-items:center;gap:1rem;padding:1rem;background:rgba(255,255,255,.12);border-radius:12px;backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.15);transition:.3s}.hero-feature:hover{background:rgba(255,255,255,.18);transform:translateX(5px)}.hero-feature i{font-size:1.8rem;color:var(--accent-yellow);min-width:32px}.hero-feature-text{font-size:.95rem;font-weight:600;line-height:1.3}
    
    .hero-right{background:linear-gradient(135deg,#f8f9fa 0%,#ffffff 100%);padding:0;position:relative}.hero-image-grid{display:grid;grid-template-columns:repeat(2,1fr);grid-template-rows:repeat(2,1fr);height:100%;gap:0}.hero-image-item{position:relative;overflow:hidden;background:linear-gradient(135deg,#e9ecef,#f8f9fa)}.hero-image-item:nth-child(1){border-bottom:2px solid var(--bg-white);border-right:2px solid var(--bg-white)}.hero-image-item:nth-child(2){border-bottom:2px solid var(--bg-white)}.hero-image-item:nth-child(3){border-right:2px solid var(--bg-white)}.hero-image-item img{width:100%;height:100%;object-fit:cover;transition:.5s}.hero-image-item:hover img{transform:scale(1.1)}.hero-image-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(44,95,45,.9),transparent 60%);opacity:0;transition:.3s;display:flex;align-items:flex-end;padding:1.5rem}.hero-image-item:hover .hero-image-overlay{opacity:1}.hero-image-caption{color:#fff;font-weight:700;font-size:1.1rem;text-shadow:2px 2px 4px rgba(0,0,0,.3)}.hero-image-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:.8rem;color:var(--text-grey);padding:1.5rem;text-align:center;transition:.3s}.hero-image-placeholder i{font-size:2.5rem;color:var(--primary-light-green);opacity:.5}.hero-image-placeholder p{font-weight:600;font-size:.9rem}.hero-image-placeholder small{font-size:.75rem;color:var(--text-light)}.hero-image-item:hover .hero-image-placeholder{background:rgba(151,188,98,.05)}

    /* School Info Section */
    .school-section{max-width:1400px;margin:2rem auto;padding:0 1rem}.school-container{background:var(--bg-white);border-radius:24px;box-shadow:var(--shadow-medium);overflow:hidden;display:grid;grid-template-columns:400px 1fr}.school-image-area{position:relative;overflow:hidden;background:linear-gradient(135deg,var(--primary-green),var(--primary-light-green))}.school-main-image{width:100%;height:100%;object-fit:cover}.school-image-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1.5rem;color:#fff;padding:3rem}.school-image-placeholder i{font-size:5rem;opacity:.3}.school-image-placeholder p{font-size:1.3rem;font-weight:700;text-align:center}.school-image-placeholder small{font-size:.9rem;opacity:.8;text-align:center}
    
    .school-content{padding:3rem;display:flex;flex-direction:column;justify-content:center}.school-header{display:flex;align-items:center;gap:1rem;margin-bottom:2rem}.school-header i{font-size:2rem;color:var(--primary-green)}.school-title{font-size:2.2rem;font-weight:800;background:var(--gradient-green);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}.school-description{font-size:1.1rem;line-height:1.8;color:var(--text-grey);margin-bottom:2rem}.school-details{display:grid;grid-template-columns:1fr;gap:1.5rem;margin-bottom:2rem}.school-detail-item{background:var(--bg-light);padding:1.8rem;border-radius:16px;border-left:4px solid var(--primary-light-green);transition:.3s}.school-detail-item:hover{transform:translateX(8px);box-shadow:var(--shadow-soft)}.school-detail-label{font-weight:700;color:var(--primary-green);margin-bottom:.8rem;display:flex;align-items:center;gap:.5rem;font-size:1.1rem}.school-detail-label i{color:var(--accent-gold);font-size:1.2rem}.school-detail-text{color:var(--text-grey);line-height:1.7;font-size:.98rem}.school-motto{background:var(--gradient-gold);padding:1.5rem;border-radius:12px;text-align:center;margin-top:1rem}.school-motto-text{color:var(--primary-dark-green);font-weight:800;font-size:1.3rem;font-style:italic}.school-contact{display:flex;gap:2rem;flex-wrap:wrap;margin-top:2rem;padding-top:2rem;border-top:2px solid var(--border-light)}.school-contact-item{display:flex;align-items:center;gap:.8rem;color:var(--text-grey);font-size:.95rem;transition:.3s}.school-contact-item:hover{color:var(--primary-green);transform:translateX(5px)}.school-contact-item i{color:var(--primary-green);font-size:1.1rem}

    /* Kompetensi Section */
    .kompetensi-section{max-width:1400px;margin:2rem auto;padding:0 1rem}.kompetensi-header{text-align:center;margin-bottom:3rem}.kompetensi-title{font-size:2.8rem;font-weight:800;background:var(--gradient-green);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:1rem}.kompetensi-subtitle{font-size:1.3rem;color:var(--text-grey)}.kompetensi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2rem}.kompetensi-card{background:var(--bg-white);border-radius:20px;padding:2.5rem;box-shadow:var(--shadow-soft);transition:.4s;position:relative;overflow:hidden;border:2px solid transparent}.kompetensi-card::before{content:'';position:absolute;top:-50%;right:-50%;width:100%;height:100%;background:conic-gradient(from 0deg,transparent,rgba(151,188,98,.08),transparent);animation:cardRotate 4s linear infinite;opacity:0;transition:opacity .4s}@keyframes cardRotate{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}.kompetensi-card:hover{transform:translateY(-10px);box-shadow:var(--shadow-strong);border-color:var(--primary-light-green)}.kompetensi-card:hover::before{opacity:1}.kompetensi-icon{width:80px;height:80px;background:var(--gradient-green);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;margin:0 auto 1.5rem;box-shadow:var(--shadow-medium);animation:iconFloat 3s ease-in-out infinite;position:relative}@keyframes iconFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}.kompetensi-icon::after{content:'';position:absolute;inset:-8px;border-radius:50%;border:3px solid var(--primary-light-green);opacity:.3;animation:iconPulse 2s ease-out infinite}@keyframes iconPulse{0%{transform:scale(1);opacity:.3}100%{transform:scale(1.4);opacity:0}}.kompetensi-name{font-size:1.3rem;font-weight:700;color:var(--text-dark);text-align:center;margin-bottom:1rem}.kompetensi-desc{color:var(--text-grey);line-height:1.7;text-align:center;font-size:.95rem}

    /* Action Cards Section */
    .action-section{max-width:1400px;margin:2rem auto;padding:0 1rem}.action-header{text-align:center;margin-bottom:3rem}.action-title{font-size:2.8rem;font-weight:800;background:var(--gradient-green);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:1rem}.action-subtitle{font-size:1.3rem;color:var(--text-grey)}
    
    .action-cards{display:grid;grid-template-columns:repeat(2,1fr);gap:2rem}.action-card{background:var(--bg-white);border-radius:24px;overflow:hidden;box-shadow:var(--shadow-medium);transition:.3s;position:relative;display:grid;grid-template-columns:300px 1fr}.action-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-strong)}
    
    .action-card-image{position:relative;background:linear-gradient(135deg,#e9ecef,#f8f9fa);overflow:hidden}.action-card-img{width:100%;height:100%;object-fit:cover}.action-card-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;color:var(--text-grey);padding:2rem}.action-card-placeholder i{font-size:4rem;color:var(--primary-light-green);opacity:.4}.action-card-placeholder p{font-weight:700;font-size:1.1rem;text-align:center}.action-card-placeholder small{font-size:.85rem;color:var(--text-light);text-align:center}
    
    .action-card-content{padding:3rem;display:flex;flex-direction:column;justify-content:center}.action-card-icon{width:70px;height:70px;background:var(--gradient-green);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;margin-bottom:1.5rem;box-shadow:var(--shadow-medium);animation:iconFloat 3s ease-in-out infinite}.action-card-title{font-size:1.8rem;font-weight:700;color:var(--text-dark);margin-bottom:1rem}.action-card-description{color:var(--text-grey);line-height:1.7;margin-bottom:2rem;font-size:1.05rem}.action-card-btn{padding:1.2rem 2.5rem;border:none;border-radius:12px;font-size:1.1rem;font-weight:600;cursor:pointer;transition:.3s;display:inline-flex;align-items:center;justify-content:center;gap:.8rem;text-decoration:none;position:relative;overflow:hidden}.action-card-btn::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;background:rgba(255,255,255,.3);border-radius:50%;transform:translate(-50%,-50%);transition:width .6s,height .6s}.action-card-btn:hover::before{width:300px;height:300px}.btn-primary{background:var(--gradient-green);color:#fff;box-shadow:var(--shadow-soft)}.btn-primary:hover{transform:translateY(-2px);box-shadow:var(--shadow-medium)}.btn-outline{background:transparent;border:2px solid var(--primary-green);color:var(--primary-green)}.btn-outline:hover{background:var(--primary-green);color:#fff;transform:translateY(-2px)}

    /* Location Info */
    .location-info{max-width:1400px;margin:2rem auto;padding:0 1rem;display:none}.location-container{background:var(--bg-white);border-radius:24px;box-shadow:var(--shadow-medium);overflow:hidden;display:grid;grid-template-columns:1fr 1fr}.location-map{background:linear-gradient(135deg,var(--primary-light-green),var(--primary-green));position:relative;padding:3rem;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff}.location-map i{font-size:5rem;margin-bottom:2rem;opacity:.8}.location-map-title{font-size:2rem;font-weight:700;margin-bottom:1rem;text-align:center}.location-map-text{font-size:1.1rem;opacity:.9;text-align:center}
    
    .location-details{padding:3rem}.location-header{display:flex;align-items:center;gap:1rem;margin-bottom:2rem}.location-header i{font-size:2rem;color:var(--accent-gold)}.location-header h3{font-size:2rem;font-weight:700;color:var(--primary-green)}.location-info-grid{display:flex;flex-direction:column;gap:1.5rem}.location-info-item{display:flex;gap:1.5rem;padding:1.5rem;background:var(--bg-light);border-radius:16px;border-left:4px solid var(--accent-gold);transition:.3s}.location-info-item:hover{transform:translateX(8px);box-shadow:var(--shadow-soft)}.location-info-item i{font-size:1.5rem;color:var(--primary-green);min-width:30px}.location-info-content strong{display:block;color:var(--text-dark);font-size:1.1rem;margin-bottom:.5rem}.location-info-content span{color:var(--text-grey);line-height:1.6}.location-warning{background:linear-gradient(135deg,#fff5f5,#ffe6e6);padding:1.5rem;border-radius:12px;border-left:4px solid var(--accent-red);display:flex;align-items:center;gap:1rem;margin-top:2rem}.location-warning i{font-size:1.5rem;color:var(--accent-red);animation:warningBlink 2s ease-in-out infinite}@keyframes warningBlink{0%,100%{opacity:1}50%{opacity:.6}}.location-warning-text{color:var(--accent-red);font-weight:700;font-size:1.05rem}

    .notification{position:fixed;top:1rem;right:1rem;padding:1rem 1.5rem;border-radius:12px;background:var(--gradient-green);color:#fff;box-shadow:var(--shadow-strong);display:flex;align-items:center;gap:.8rem;transform:translateX(400px);transition:transform .3s ease;z-index:1000}.notification.show{transform:translateX(0)}.notification i{font-size:1.2rem}
    
    @media (max-width: 1200px){.hero-content{grid-template-columns:1fr}.hero-right{min-height:400px}.hero-image-grid{grid-template-columns:repeat(4,1fr);grid-template-rows:200px}.hero-image-item:nth-child(1),.hero-image-item:nth-child(2),.hero-image-item:nth-child(3){border-right:2px solid var(--bg-white);border-bottom:0}.school-container{grid-template-columns:1fr}.school-image-area{height:350px}.kompetensi-grid{grid-template-columns:repeat(2,1fr)}.action-cards{grid-template-columns:1fr}.action-card{grid-template-columns:1fr}.action-card-image{height:280px}.location-container{grid-template-columns:1fr}}
    
    @media (max-width: 768px){.hero-section{padding:1rem}.hero-left{padding:2rem}.hero-logo-container{gap:1rem}.hero-logo-wrapper{width:90px;height:90px}.hero-logo-title{font-size:1.8rem}.hero-logo-subtitle{font-size:1rem}.hero-tagline{font-size:1.6rem;margin-bottom:1rem}.hero-description{font-size:1rem;margin-bottom:1.5rem}.hero-cta-btn{padding:1rem 2rem;font-size:1rem;width:100%}.hero-features{grid-template-columns:1fr;gap:.8rem}.hero-feature{padding:.8rem}.hero-feature i{font-size:1.5rem}.hero-feature-text{font-size:.9rem}.hero-image-grid{grid-template-columns:repeat(2,1fr);grid-template-rows:repeat(2,180px)}.hero-image-item:nth-child(1){border-bottom:2px solid var(--bg-white);border-right:2px solid var(--bg-white)}.hero-image-item:nth-child(2){border-bottom:2px solid var(--bg-white);border-right:0}.hero-image-item:nth-child(3){border-right:2px solid var(--bg-white);border-bottom:0}.hero-image-item:nth-child(4){border-right:0;border-bottom:0}.hero-image-placeholder i{font-size:2rem}.hero-image-placeholder p{font-size:.85rem}.hero-image-placeholder small{font-size:.7rem}.school-section{margin:1.5rem auto}.school-content{padding:2rem}.school-header i{font-size:1.5rem}.school-title{font-size:1.8rem}.school-description{font-size:1rem}.school-detail-item{padding:1.3rem}.school-detail-label{font-size:1rem}.school-detail-text{font-size:.9rem}.school-motto{padding:1.2rem}.school-motto-text{font-size:1.1rem}.school-contact{flex-direction:column;gap:1rem}.kompetensi-section,.action-section{margin:1.5rem auto}.kompetensi-title,.action-title{font-size:2rem}.kompetensi-subtitle,.action-subtitle{font-size:1.1rem}.kompetensi-grid{grid-template-columns:1fr;gap:1.5rem}.kompetensi-card{padding:2rem}.kompetensi-icon{width:70px;height:70px;font-size:1.8rem}.kompetensi-name{font-size:1.2rem}.action-card-content{padding:2rem}.action-card-icon{width:60px;height:60px;font-size:1.8rem}.action-card-title{font-size:1.5rem}.action-card-description{font-size:1rem}.action-card-btn{padding:1rem 2rem;font-size:1rem;width:100%}.location-details{padding:2rem}.location-map{padding:2rem}.location-map i{font-size:3.5rem}.location-map-title{font-size:1.6rem}.location-map-text{font-size:1rem}}
    
    @media (max-width: 480px){.hero-section{padding:.5rem}.hero-container{border-radius:20px}.hero-left{padding:1.5rem}.hero-logo-wrapper{width:75px;height:75px}.hero-logo-img,.hero-logo-placeholder i{font-size:1.8rem}.hero-logo-placeholder small{font-size:.6rem}.hero-logo-title{font-size:1.5rem;line-height:1.2}.hero-logo-subtitle{font-size:.9rem}.hero-tagline{font-size:1.3rem;line-height:1.2}.hero-description{font-size:.95rem;line-height:1.6}.hero-cta-btn{padding:.9rem 1.5rem;font-size:.95rem}.hero-cta-btn i{font-size:1.1rem}.hero-features{gap:.7rem}.hero-feature{padding:.7rem}.hero-feature i{font-size:1.3rem}.hero-feature-text{font-size:.85rem}.hero-image-grid{grid-template-rows:repeat(2,140px)}.hero-image-placeholder i{font-size:1.8rem}.hero-image-placeholder p{font-size:.8rem}.hero-image-placeholder small{font-size:.65rem;display:none}.school-container,.kompetensi-card,.action-card,.location-container{border-radius:16px}.school-content{padding:1.5rem}.school-header{gap:.8rem}.school-header i{font-size:1.3rem}.school-title{font-size:1.5rem}.school-description{font-size:.95rem;line-height:1.6}.school-detail-item{padding:1.2rem}.school-detail-label{font-size:.95rem}.school-detail-label i{font-size:1rem}.school-detail-text{font-size:.85rem;line-height:1.6}.school-motto{padding:1rem}.school-motto-text{font-size:1rem}.school-contact-item{font-size:.85rem}.school-contact-item i{font-size:1rem}.kompetensi-title,.action-title{font-size:1.7rem}.kompetensi-subtitle,.action-subtitle{font-size:1rem}.kompetensi-card{padding:1.8rem}.kompetensi-icon{width:65px;height:65px;font-size:1.6rem}.kompetensi-name{font-size:1.1rem}.kompetensi-desc{font-size:.9rem}.action-card-image{height:220px}.action-card-placeholder i{font-size:3rem}.action-card-placeholder p{font-size:1rem}.action-card-content{padding:1.8rem}.action-card-icon{width:55px;height:55px;font-size:1.6rem;margin-bottom:1rem}.action-card-title{font-size:1.3rem}.action-card-description{font-size:.95rem;margin-bottom:1.5rem}.action-card-btn{padding:.9rem 1.8rem;font-size:.95rem}.location-details{padding:1.5rem}.location-map{padding:1.5rem}.location-map i{font-size:3rem;margin-bottom:1.5rem}.location-map-title{font-size:1.4rem}.location-map-text{font-size:.95rem}.location-info-item{padding:1.2rem;gap:1rem}.location-info-item i{font-size:1.3rem}.location-info-content strong{font-size:1rem}.location-info-content span{font-size:.9rem}.location-warning{padding:1.2rem}.location-warning i{font-size:1.3rem}.location-warning-text{font-size:.95rem}.notification{top:.5rem;right:.5rem;left:.5rem;padding:.9rem 1.2rem;font-size:.9rem}.notification i{font-size:1rem}}
  </style>
</head>
<body>
  <div class="bg-animation"><div class="floating-shapes"><div class="shape"></div><div class="shape"></div><div class="shape"></div><div class="shape"></div></div></div>
  <div class="pattern-overlay"></div>
  <div class="notification" id="notification"><i class="fas fa-info-circle"></i><span id="notification-message">Selamat datang di Bank Mini Tsamaniyah</span></div>
  
  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-container">
      <div class="hero-content">
        <div class="hero-left">
          <div class="hero-logo-container">
            <div class="hero-logo-wrapper">
              <img src="images\logo-bank-mini.png" alt="Logo Bank Mini" class="hero-logo-img">
            </div>
            <div class="hero-logo-text">
              <h1 class="hero-logo-title">Bank Mini Tsamaniyah</h1>
              <p class="hero-logo-subtitle">SMK Negeri 8 Jakarta</p>
            </div>
          </div>
          
          <h2 class="hero-tagline">Solusi Perbankan Praktis untuk Komunitas Sekolah</h2>
          <p class="hero-description">Layanan perbankan mini dengan prinsip syariah yang memberikan pengalaman belajar langsung tentang manajemen keuangan, operasional perbankan, dan pelayanan nasabah secara profesional.</p>
          
          <a href="{{ route('layanan') }}" class="hero-cta-btn">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Lihat Layanan Kami</span>
          </a>
          
          <div class="hero-features">
            <div class="hero-feature">
              <i class="fas fa-shield-alt"></i>
              <span class="hero-feature-text">Sistem Terpercaya & Aman</span>
            </div>
            <div class="hero-feature">
              <i class="fas fa-hand-holding-heart"></i>
              <span class="hero-feature-text">Prinsip Syariah</span>
            </div>
            <div class="hero-feature">
              <i class="fas fa-users"></i>
              <span class="hero-feature-text">Untuk Civitas Akademika</span>
            </div>
            <div class="hero-feature">
              <i class="fas fa-chart-line"></i>
              <span class="hero-feature-text">Edukasi Finansial</span>
            </div>
          </div>
        </div>
        
        <div class="hero-right">
          <div class="hero-image-grid">
            <div class="hero-image-item">
              <img src="\images\teller.png" alt="Aktivitas Bank"> 
              <div class="hero-image-placeholder">
                <i class="fas fa-users"></i>
                <p>Aktivitas Siswa</p>
                <small>/public/images/aktivitas-1.jpg</small>
              </div>
              <div class="hero-image-overlay">
                <p class="hero-image-caption">Melayani Nasabah</p>
              </div>
            </div>
            <div class="hero-image-item">
              <img src="images/transaksi.png" alt="Ruang Bank"> 
              <div class="hero-image-placeholder">
                <i class="fas fa-building"></i>
                <p>Interior Bank</p>
                <small>/public/images/ruangan.jpg</small>
              </div>
              <div class="hero-image-overlay">
                <p class="hero-image-caption">Ruang Bank Mini</p>
              </div>
            </div>
            <div class="hero-image-item">
              <img src="images/ngasal1.png" alt="Transaksi"> 
              <div class="hero-image-placeholder">
                <i class="fas fa-money-bill-wave"></i>
                <p>Transaksi</p>
                <small>/public/images/transaksi.jpg</small>
              </div>
              <div class="hero-image-overlay">
                <p class="hero-image-caption">Proses Transaksi</p>
              </div>
            </div>
            <div class="hero-image-item">
              <img src="/images/ngasal2.png" alt="Tim Bank">
              <div class="hero-image-placeholder">
                <i class="fas fa-user-friends"></i>
                <p>Tim Kami</p>
                <small>/public/images/team.jpg</small>
              </div>
              <div class="hero-image-overlay">
                <p class="hero-image-caption">Tim Bank Mini</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- School Info Section -->
  <section class="school-section">
    <div class="school-container">
      <div class="school-image-area">
        <img src="images\lingkungan-sekolah.png" alt="SMKN 8 Jakarta" class="school-main-image">
        <div class="school-image-placeholder">
          <i class="fas fa-school"></i>
          <p>Gedung SMK Negeri 8 Jakarta</p>
          <small>Upload foto sekolah di /public/images/sekolah.jpg</small>
        </div>
      </div>
      <div class="school-content">
        <div class="school-header">
          <i class="fas fa-graduation-cap"></i>
          <h2 class="school-title">SMK Negeri 8 Jakarta</h2>
        </div>
        <p class="school-description">Sekolah menengah kejuruan yang fokus pada pendidikan vokasi berkualitas dengan berbagai program keahlian, mempersiapkan siswa menjadi tenaga profesional yang kompeten dan siap kerja.</p>
        
        <div class="school-details">
          <div class="school-detail-item">
            <div class="school-detail-label"><i class="fas fa-eye"></i>Visi</div>
            <div class="school-detail-text">Menghasilkan lulusan pendidikan vokasional yang religius, kreatif, dan berwawasan lingkungan.</div>
          </div>
          
          <div class="school-detail-item">
            <div class="school-detail-label"><i class="fas fa-bullseye"></i>Misi</div>
            <div class="school-detail-text">
              • Menyelenggarakan Kegiatan Peningkatan Iman dan Taqwa<br>
              • Melaksanakan pembelajaran yang menarik dengan mengintegrasikan kompetensi keterampilan, komunikasi, kreativitas, kolaborasi, berfikir kritis, kemampuan memecahkan masalah dan empati<br>
              • Mewujudkan Lingkungan Sekolah yang Hijau, Bersih, Indah dan Sehat
            </div>
          </div>
        </div>
        
        <div class="school-motto">
          <p class="school-motto-text">"Kami berkualitas dan dipercaya"</p>
        </div>
        
        <div class="school-contact">
          <div class="school-contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Jl. Raya Pejaten, Pasar Minggu, Jakarta Selatan 12510</span>
          </div>
          <div class="school-contact-item">
            <i class="fas fa-phone"></i>
            <span>(021) 7972362</span>
          </div>
          <div class="school-contact-item">
            <i class="fas fa-envelope"></i>
            <span>info@smkn8jkt.sch.id</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Kompetensi Keahlian Section -->
  <section class="kompetensi-section">
  <div class="kompetensi-header">
    <h2 class="kompetensi-title">Kompetensi Keahlian</h2>
    <p class="kompetensi-subtitle">Program unggulan yang menghasilkan lulusan kompeten dan siap kerja</p>
  </div>
  
  <div class="kompetensi-grid">
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-university"></i></div>
      <h3 class="kompetensi-name">Akuntansi & Keuangan Lembaga</h3>
      <p class="kompetensi-desc">Menghasilkan tenaga ahli di bidang akuntansi, pembukuan, dan manajemen keuangan lembaga</p>
    </div>
    
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-calculator"></i></div>
      <h3 class="kompetensi-name">Manajemen Perkantoran</h3>
      <p class="kompetensi-desc">Menghasilkan tenaga ahli di bidang akuntansi, pembukuan, dan manajemen keuangan lembaga</p>
    </div>
    
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-briefcase"></i></div>
      <h3 class="kompetensi-name">Manajemen Logistik</h3>
      <p class="kompetensi-desc">Membekali siswa dengan keterampilan administrasi perkantoran modern dan otomatisasi</p>
    </div>
    
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-laptop-code"></i></div>
      <h3 class="kompetensi-name">Rekayasa Perangkat Lunak</h3>
      <p class="kompetensi-desc">Mencetak programmer dan developer yang handal dalam pengembangan software dan game</p>
    </div>
    
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-paint-brush"></i></div>
      <h3 class="kompetensi-name">Bisnis Digital</h3>
      <p class="kompetensi-desc">Menghasilkan desainer kreatif yang mahir dalam desain grafis dan komunikasi visual</p>
    </div>
    
    <div class="kompetensi-card">
      <div class="kompetensi-icon"><i class="fas fa-bullhorn"></i></div>
      <h3 class="kompetensi-name">Bisnis Retail</h3>
      <p class="kompetensi-desc">Mempersiapkan profesional di bidang broadcasting, perfilman, dan produksi multimedia</p>
    </div>

    <!-- 🔽 Jurusan baru -->
    <div class="kompetensi-card" style="grid-column: 2 / span 1;">
      <div class="kompetensi-icon">
        <i class="fas fa-route"></i>
      </div>
      <h3 class="kompetensi-name">Usaha Layanan Wisata</h3>
      <p class="kompetensi-desc">
        Membekali siswa dengan kemampuan melayani pelanggan di bidang wisata, perhotelan, dll.
      </p>
    </div>
</section>

  <script>
    function showNotification(msg,duration=4000){const el=document.getElementById('notification');document.getElementById('notification-message').textContent=msg||'';el.classList.add('show');setTimeout(()=>el.classList.remove('show'),duration);}
    
    function showLocationInfo(){const section=document.getElementById('locationInfo');section.style.display='block';showNotification('Silakan kunjungi lokasi kami untuk pendaftaran akun',5000);setTimeout(()=>{section.scrollIntoView({behavior:'smooth',block:'center'});},100);}
    
    document.addEventListener('DOMContentLoaded',()=>{
      showNotification('Selamat datang di Bank Mini Tsamaniyah - SMKN 8 Jakarta',5000);
      
      document.querySelectorAll('.action-card').forEach(card=>{
        card.addEventListener('mouseenter',()=>{
          card.style.transform='translateY(-12px)';
        });
        card.addEventListener('mouseleave',()=>{
          card.style.transform='translateY(0)';
        });
      });
      
      document.querySelectorAll('.kompetensi-card').forEach(card=>{
        card.addEventListener('mouseenter',()=>{
          card.style.transform='translateY(-12px)';
        });
        card.addEventListener('mouseleave',()=>{
          card.style.transform='translateY(0)';
        });
      });
      
      document.querySelectorAll('.action-card-btn, .hero-cta-btn').forEach(btn=>{
        btn.addEventListener('click',e=>{
          const ripple=document.createElement('span');
          const rect=btn.getBoundingClientRect();
          const size=Math.max(rect.width,rect.height);
          ripple.style.width=ripple.style.height=size+'px';
          ripple.style.left=(e.clientX-rect.left-size/2)+'px';
          ripple.style.top=(e.clientY-rect.top-size/2)+'px';
          ripple.style.position='absolute';
          ripple.style.borderRadius='50%';
          ripple.style.background='rgba(255,255,255,.4)';
          ripple.style.pointerEvents='none';
          ripple.style.transform='scale(0)';
          ripple.style.transition='transform .6s, opacity .6s';
          btn.appendChild(ripple);
          requestAnimationFrame(()=>{
            ripple.style.transform='scale(2)';
            ripple.style.opacity='0';
          });
          setTimeout(()=>ripple.remove(),600);
        });
      });
      
      document.querySelectorAll('.hero-feature').forEach(feature=>{
        feature.addEventListener('mouseenter',()=>{
          feature.style.transform='translateX(8px)';
        });
        feature.addEventListener('mouseleave',()=>{
          feature.style.transform='translateX(0)';
        });
      });
      
      const observerOptions={threshold:0.1,rootMargin:'0px 0px -100px 0px'};
      const observer=new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
          if(entry.isIntersecting){
            entry.target.style.opacity='1';
            entry.target.style.transform='translateY(0)';
          }
        });
      },observerOptions);
      
      document.querySelectorAll('.school-section, .kompetensi-section, .action-section').forEach(section=>{
        section.style.opacity='0';
        section.style.transform='translateY(30px)';
        section.style.transition='opacity .8s ease, transform .8s ease';
        observer.observe(section);
      });
    });
  </script>
</body>
</html>