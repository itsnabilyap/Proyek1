<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C2VIN Catering</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">

</head>

<body>

    <?php include 'partials/navbar.php'; ?> 
    
    <section class="hero" id="home">
        <div class="content">
            <h2>Pilihan Menu Terbaik Untuk Setiap Acara</h2>
            <button class="cta">Lihat Menu</button>
        </div>
    </section>

    <section class="about-selection" id="about">
        <div class="container flex">
            <div class="about-text">
                <div class="info-box">
                    <h3>C2VIN Catering – Mitra Sajian untuk Berbagai Acara</h3>
                    <p>UMKM catering yang menghadirkan sajian lezat dengan pelayanan ramah dan terpercaya.</p>
                </div>
                <div class="info-box">
                    <h3>Melayani berbagai jenis acara</h3>
                    <p>Lomba tumpeng, hajatan & pernikahan, tahlilan, ulang tahun, hingga berbagai event lainnya.</p>
                </div>
                <div class="info-box">
                    <h3>Dimasak dengan sepenuh hati, disajikan dengan kualitas</h3>
                    <p>Setiap hidangan diolah dengan bahan pilihan, higienis, dan cita rasa yang memuaskan.</p>
                </div>
                    <button class="tombol">Pesan Sekarang</button>
                </div>
                <div class="about-logo">
                <img src="logo-brand.jpeg" alt="C2vin Logo">
            </div>
        </div>
    </section>

    <section class="feature-section">
        <div class="flex-container">
            <div class="feature-img">
                <img src="img/Tumpeng.jpeg" alt="Tumpeng Besar">
            </div>
            <div class="feature-text">
                <h2>C2VIN Catering yang cocok untuk segala acara</h2>
                <p>Dipercaya oleh berbagai lembaga terkemuka dan perorangan.<br>                   <br></p>
                <button class="tekan">Lihat Menu</button>
            </div>
        </div>
    </section>

    <section class="gallery-section" id="gallery">
        <div class="container">
            <div class="gallery-grid">
                <div class="card">
                    <img src="img/Tumpeng.jpeg" alt="Tumpeng">
                    <p>Tumpeng</p>
                </div>
                <div class="card">
                    <img src="img/AmericanBreakfast.jpeg" alt="American Breakfast">
                    <p>American Breakfast</p>
                </div>
                <div class="card">
                    <img src="img/ricebowl.jpeg" alt="Ricebowl">
                    <p>Ricebowl</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
      feather.replace();
    </script>

    <script src="cart.js"></script>

</body>

</html>