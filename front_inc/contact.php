<?php 
    $select = "SELECT * FROM contact";
    $query = mysqli_query($db, $select);
    $assoc = mysqli_fetch_assoc($query);
?>
<section id="contact" class="contact-section">
    <div class="contact-bg">
        <div class="bg-orb orb-1"></div>
        <div class="bg-orb orb-2"></div>
    </div>

    <div class="container position-relative">
        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <span class="badge-tag">
                        <i class="fas fa-paper-plane"></i>
                        Hubungi Kami
                    </span>
                    <h2 class="main-title">Mari <span class="gradient-text">Terhubung</span></h2>
                    <p class="subtitle">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami kapan saja.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Info Card -->
            <div class="col-lg-5">
                <div class="info-card">
                    <div class="info-header">
                        <div class="brand-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h4><?= htmlspecialchars($assoc['description'] ?? 'Kantor Pusat') ?></h4>
                            <span class="location-badge">
                                <i class="fas fa-map-pin"></i> Maumere
                            </span>
                        </div>
                    </div>

                    <div class="info-divider"></div>

                    <div class="info-list">
                        <a href="https://maps.google.com/?q=<?= urlencode($assoc['address'] ?? '') ?>" target="_blank" class="info-item">
                            <div class="info-icon" style="--icon-color: #FF6B6B">
                                <i class="fas fa-location-dot"></i>
                            </div>
                            <div class="info-detail">
                                <span class="label">Alamat</span>
                                <span class="value"><?= htmlspecialchars($assoc['address'] ?? '-') ?></span>
                            </div>
                            <i class="fas fa-external-link-alt link-icon"></i>
                        </a>

                        <a href="tel:<?= preg_replace('/[^0-9]/', '', $assoc['phone'] ?? '') ?>" class="info-item">
                            <div class="info-icon" style="--icon-color: #4ECDC4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-detail">
                                <span class="label">Telepon</span>
                                <span class="value"><?= htmlspecialchars($assoc['phone'] ?? '-') ?></span>
                            </div>
                            <i class="fas fa-external-link-alt link-icon"></i>
                        </a>

                        <a href="mailto:<?= htmlspecialchars($assoc['email'] ?? '') ?>" class="info-item">
                            <div class="info-icon" style="--icon-color: #A78BFA">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-detail">
                                <span class="label">Email</span>
                                <span class="value"><?= htmlspecialchars($assoc['email'] ?? '-') ?></span>
                            </div>
                            <i class="fas fa-external-link-alt link-icon"></i>
                        </a>
                    </div>

                    <div class="social-block">
                        <span>Ikuti Kami</span>
                        <div class="social-links">
                            <a href="#" class="social-btn" style="--social-color: #1877F2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-btn" style="--social-color: #E4405F"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-btn" style="--social-color: #25D366"><i class="fab fa-whatsapp"></i></a>
                            <a href="#" class="social-btn" style="--social-color: #0A66C2"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="col-lg-7">
                <div class="form-card">
                    <div class="form-header">
                        <h4>Kirim Pesan</h4>
                        <p>Isi form di bawah ini dan kami akan segera merespons</p>
                    </div>

                    <form action="backend/msg-us.php" method="post" class="contact-form">
                        <?php if (isset($_SESSION['msg'])): ?>
                            <div class="alert-box">
                                <?= $_SESSION['msg'] ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" placeholder="Masukkan nama Anda" required 
                                       style="text-transform: capitalize" class="form-input">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-at"></i>
                                    Alamat Email
                                </label>
                                <input type="email" name="email" placeholder="nama@email.com" required 
                                       style="text-transform: lowercase" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-comment-dots"></i>
                                Pesan Anda
                            </label>
                            <textarea name="msg" rows="5" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required class="form-input"></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span class="btn-text">Kirim Pesan</span>
                            <span class="btn-icon">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <div class="btn-shine"></div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ CONTACT SECTION - PREMIUM DARK ============ */
.contact-section {
    padding: 120px 0;
    background: #131f33;
    position: relative;
    overflow: hidden;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Background Orbs */
.contact-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.bg-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.12;
}

.orb-1 {
    width: 500px;
    height: 500px;
    background: #6366f1;
    top: -150px;
    left: -100px;
    animation: orbFloat 15s ease-in-out infinite;
}

.orb-2 {
    width: 400px;
    height: 400px;
    background: #ec4899;
    bottom: -100px;
    right: -50px;
    animation: orbFloat 15s ease-in-out infinite reverse;
}

@keyframes orbFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(50px, -30px) scale(1.1); }
}

/* Section Header */
.section-header {
    margin-bottom: 70px;
    position: relative;
    z-index: 1;
}

.badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(99, 102, 241, 0.12);
    border: 1px solid rgba(99, 102, 241, 0.25);
    color: #818cf8;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 24px;
}

.main-title {
    font-size: 3rem;
    font-weight: 800;
    color: #f8fafc;
    margin-bottom: 16px;
    line-height: 1.2;
}

.gradient-text {
    background: linear-gradient(135deg, #6366f1, #ec4899, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.subtitle {
    font-size: 1.1rem;
    color: #94a3b8;
    max-width: 500px;
    margin: 0 auto;
}

/* Info Card */
.info-card {
    background: rgba(15, 23, 42, 0.8);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 24px;
    padding: 40px;
    height: 100%;
    backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
}

.info-card:hover {
    border-color: rgba(99, 102, 241, 0.2);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 30px;
}

.brand-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
}

.info-header h4 {
    color: #f8fafc;
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.location-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(34, 197, 94, 0.15);
    color: #4ade80;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.info-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.2), transparent);
    margin-bottom: 25px;
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: rgba(30, 41, 59, 0.5);
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.info-item:hover {
    background: rgba(30, 41, 59, 0.8);
    border-color: var(--icon-color);
    transform: translateX(5px);
    text-decoration: none;
}

.info-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--icon-color);
    font-size: 18px;
    flex-shrink: 0;
    transition: all 0.3s;
}

.info-item:hover .info-icon {
    background: var(--icon-color);
    color: #fff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.info-detail {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.info-detail .label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-detail .value {
    font-size: 15px;
    color: #e2e8f0;
    font-weight: 600;
}

.link-icon {
    color: #475569;
    font-size: 12px;
    opacity: 0;
    transition: all 0.3s;
}

.info-item:hover .link-icon {
    opacity: 1;
    color: var(--icon-color);
}

/* Social Block */
.social-block {
    padding-top: 25px;
    border-top: 1px solid rgba(148, 163, 184, 0.1);
}

.social-block span {
    display: block;
    font-size: 13px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
    font-weight: 600;
}

.social-links {
    display: flex;
    gap: 12px;
}

.social-btn {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: var(--social-color);
    border-color: var(--social-color);
    color: #fff;
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    text-decoration: none;
}

/* Form Card */
.form-card {
    background: rgba(15, 23, 42, 0.8);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 24px;
    padding: 40px;
    height: 100%;
    backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
}

.form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #ec4899, #8b5cf6);
}

.form-header {
    margin-bottom: 30px;
}

.form-header h4 {
    color: #f8fafc;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.form-header p {
    color: #94a3b8;
    font-size: 15px;
    margin: 0;
}

/* Alert */
.alert-box {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #4ade80;
    padding: 14px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 500;
}

/* Form */
.contact-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #94a3b8;
    font-weight: 600;
}

.form-group label i {
    color: #6366f1;
    font-size: 13px;
}

.form-input {
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 14px;
    padding: 14px 18px;
    color: #f1f5f9;
    font-size: 15px;
    transition: all 0.3s ease;
    outline: none;
    width: 100%;
}

.form-input::placeholder {
    color: #475569;
}

.form-input:focus {
    border-color: #6366f1;
    background: rgba(30, 41, 59, 0.8);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

textarea.form-input {
    resize: vertical;
    min-height: 140px;
}

/* Submit Button */
.submit-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    padding: 16px 32px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 15px;
    border: none;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.4s ease;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    margin-top: 10px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.4);
}

.btn-text {
    position: relative;
    z-index: 2;
}

.btn-icon {
    position: relative;
    z-index: 2;
    transition: transform 0.3s;
}

.submit-btn:hover .btn-icon {
    transform: translateX(4px) translateY(-2px);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
    z-index: 1;
}

.submit-btn:hover .btn-shine {
    left: 100%;
}

/* Responsive */
@media (max-width: 991px) {
    .main-title {
        font-size: 2.4rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .contact-section {
        padding: 80px 0;
    }
    
    .main-title {
        font-size: 1.9rem;
    }
    
    .info-card,
    .form-card {
        padding: 28px 22px;
    }
    
    .info-item {
        padding: 14px;
    }
}
</style>