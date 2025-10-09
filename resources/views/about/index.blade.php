@extends('app')

@section('hero_content')
<div class="hero-content">
    <h1>About Us</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
@endsection

@section('content')
<div class="about-page">
    <!-- Pengantar Section -->
    <section class="about-section pengantar-section">
        <div class="container">
            <div class="about-content-wrapper">
                <div class="about-text">
                    <h2>Pengantar</h2>
                    <p>Yayasan Rumah Literasi Hijau merupakan sebuah yayasan yang bergerak pada kegiatan budaya konservasi dan edukasi lingkungan, yang mana adaptasi dengan perubahan iklim, serta pengelolaan sampah berbasis pemberdayaan masyarakat.</p>
                    <p>Dalam upaya merealisasi Gerakan Puluhan Nol Sampah, kami berusaha mewadahi komunitas yang terdiri dari anak-anak, Rumah Tangga, Anak-anak, Kepala Rumah Tangga, Komunitas, Akademisi, Swasta, hingga Pemerintah</p>
                </div>
                <div class="about-logo">
                    <img src="{{ asset('storage/logo.png') }}" alt="Rumah Literasi Hijau Logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="about-section vision-mission-section">
        <div class="container">
            <div class="vision-mission-wrapper">
                <div class="vision-mission-text">
                    <div class="visi-content">
                        <h2>Visi</h2>
                        <p>Membangun Gerakan Hijau Berbasis Rumah Tangga</p>
                    </div>
                    
                    <div class="misi-content">
                        <h2>Misi</h2>
                        <ul class="mission-list">
                            <li>Mendorong Gerakan Pembanguran Berkelotan dengan Menyediakan Edukasi</li>
                            <li>Menyelesaikan Permasalahan Sampah di Sumbernya yaitu dari Rumah Tangga</li>
                            <li>Menjalan Kolaborasi dengan berbagai pihak untuk mengembailikan budaya Bersih</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mission-images">
                    <div class="images-grid">
                        <div class="mission-image">
                            <img src="{{ asset('images/about-1.png') }}" alt="Rumah Literasi Hijau Activity 1" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="image-placeholder" style="display: none;">
                                <i class="fas fa-image"></i>
                                <span>Image 1</span>
                            </div>
                        </div>
                        <div class="mission-image">
                            <img src="{{ asset('images/about-2.png') }}" alt="Rumah Literasi Hijau Activity 2" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="image-placeholder" style="display: none;">
                                <i class="fas fa-image"></i>
                                <span>Image 2</span>
                            </div>
                        </div>
                        <div class="mission-image">
                            <img src="{{ asset('images/about-3.png') }}" alt="Rumah Literasi Hijau Activity 3" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="image-placeholder" style="display: none;">
                                <i class="fas fa-image"></i>
                                <span>Image 3</span>
                            </div>
                        </div>
                        <div class="mission-image">
                            <img src="{{ asset('images/about-4.png') }}" alt="Rumah Literasi Hijau Activity 4" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div class="image-placeholder" style="display: none;">
                                <i class="fas fa-image"></i>
                                <span>Image 4</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* About Page Specific Styles */
.about-page {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.about-section {
    padding: 60px 0;
}

.about-section:nth-child(even) {
    background-color: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Pengantar Section */
.pengantar-section {
    background-color: white;
}

.about-content-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 60px;
    align-items: center;
}

.about-text h2 {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
}

.about-text p {
    font-size: 16px;
    line-height: 1.7;
    color: #666;
    margin-bottom: 20px;
    text-align: justify;
}

.about-logo {
    display: flex;
    justify-content: center;
    align-items: center;
}

.about-logo img {
    max-width: 300px;
    height: auto;
    object-fit: contain;
}

/* Vision & Mission Combined Section */
.vision-mission-section {
    background-color: #f8f9fa;
}

.vision-mission-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}

.vision-mission-text {
    padding-right: 20px;
}

.visi-content {
    margin-bottom: 40px;
}

.visi-content h2 {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.visi-content p {
    font-size: 18px;
    color: #666;
    line-height: 1.6;
}

.misi-content h2 {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
}

.mission-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mission-list li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 20px;
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    text-align: justify;
}

.mission-list li:before {
    content: "•";
    color: #28a745;
    font-weight: bold;
    font-size: 20px;
    position: absolute;
    left: 0;
    top: -2px;
}

.mission-images {
    display: flex;
    justify-content: center;
    align-items: center;
}

.images-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    max-width: 600px;
    width: 100%;
}

.mission-image {
    position: relative;
    aspect-ratio: 4/3;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mission-image:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.mission-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.image-placeholder {
    width: 100%;
    min-height: 300px;
    background-color: #f0f0f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 14px;
    border-radius: 12px;
}

.image-placeholder i {
    font-size: 48px;
    margin-bottom: 10px;
    color: #ccc;
}

/* Responsive Design */
@media (max-width: 768px) {
    .about-section {
        padding: 40px 0;
    }

    .about-content-wrapper,
    .vision-mission-wrapper {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .vision-mission-text {
        padding-right: 0;
    }

    .visi-content {
        margin-bottom: 30px;
    }

    .about-text h2,
    .visi-content h2,
    .misi-content h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .about-text p,
    .mission-list li {
        font-size: 14px;
    }

    .visi-content p {
        font-size: 16px;
    }

    .about-logo img {
        max-width: 200px;
    }

    .images-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        max-width: 400px;
    }

    .mission-image {
        aspect-ratio: 16/9;
    }

    .container {
        padding: 0 15px;
    }
}

@media (max-width: 480px) {
    .single-image {
        border-radius: 8px;
    }
}
</style>
@endsection
