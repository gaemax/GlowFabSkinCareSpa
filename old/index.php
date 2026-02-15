<html lang="en">

<?php
session_start();

$conn = new mysqli("localhost","root","","gfspa_db");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GlowFab</title>
        <!--font awsome for icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
        <!--swiper css-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <!--HEADER / NAVBAR-->

        <header>

            <nav class="navbar section-content">
                <a href="#" class="nav-logo">
                    <h2 class="logo-text"> GLOW FAB</h2>
                </a>
                <ul class="nav-menu">
                    <button id="menu-close-button" class="fas fa-times"></button>
                    <li class="nav-item">
                        <a href="#" class="nav-link">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a href="#services" class="nav-link">SERVICES</a>
                    </li>
                    <li class="nav-item">
                        <a href="#staff" class="nav-link">STAFF'S</a>
                    </li>
                    <li class="nav-item">
                        <a href="#reviews" class="nav-link">REVIEWS</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">CONTACT US</a>
                    </li>
                </ul>

                <button id="menu-open-button" class="fas fa-bars"></button>
            </nav>

        </header>

        <main>

         <!--HERO / NAVBAR-->

        <section class="hero-section">
            <div class="section-content">

                <div class="hero-details">
                    <h2 class="title">Glow fab Skin Care Spa</h2>
                    <h3 class="subtitle">
                        GLOW YOU DAY WITH GLOW FAB SKIN CARE SPA
                    </h3>
                    

                    <div class="buttons">
    <a href="client_auth.php" class="button book-now">Book Now</a>
</div>

                <div class="hero-image-wrapper">
                    <img src="LOGO.png" alt="Hero" class="hero-image">
                </div>

            </div>
        </section>

        <section id="authSection" style="display:none; padding:40px; text-align:center;">

        <h2 id="formTitle">Login</h2>

        <!-- LOGIN FORM -->
        <form id="loginForm" action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
        <p>Don't have account? 
        <a href="#" onclick="showRegister()">Register</a></p>
        </form>


        <!-- REGISTER FORM -->
        <form id="registerForm" action="register.php" method="POST" style="display:none;">
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
        <p>Already have account? 
        <a href="#" onclick="showLogin()">Login</a></p>
        </form>

        </section>


        <!--ABOUT SECTION-->
        
        <section class="about-section" id="about">
            <div class="section-content">
                <div class="about-image-wrapper">
                    <img src="LOGO01.png" alt="About" class="about-image">
                </div>
                <div class="about-datails">
                    <h2 class="section-title">ABOUT US!</h2>
                    <p>Glow Fab Skin Care Spa is your go-to place for relaxation, beauty, and confidence. We offer quality skin care and beauty treatments designed to enhance your natural glow, using safe products and professional techniques. At Glow Fab, we believe that everyone deserves to feel beautiful, refreshed, and confident.</p>
                    <div class="social-link-list">
                        <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                    </div>
                </div>
            </div>
        </section>    

        <!--SERVICES SECTION-->

        <section class="service-section" id="services">
            <h2 class="section-title">OUR SERVICES</h2>
            <div class="section-contetnt">
                <ul class="service-list">

                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">facial</h3>
                        <p class="text"> FACIAL SERVICES </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HYRDA</h3>
                        <p class="text"> HYDRA FACIAL </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">BLACK DOLL CARBON LASER</h3>
                        <p class="text"> BLACK DOLL CARBON LASER </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">MICROBLADING</h3>
                        <p class="text"> MASSAGE SERVICES </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">EYELASHES EXTENSION</h3>
                        <p class="text"> EYELASHES EXTENSION </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">GLUTA PUSH AND DRIP</h3>
                        <p class="text"> GLUTA PUSH AND DRIP </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">IPL HAIR REMOVAL</h3>
                        <p class="text"> IPL HAIR REMOVAL </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">COMBRO BROWS</h3>
                        <p class="text"> TATTO REMOVAL </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HYRDA</h3>
                        <p class="text"> MICROBLADING </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HYRDA</h3>
                        <p class="text"> COMBRO BROWS </p>
                    </li><li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">ROSY LIP TATTO</h3>
                        <p class="text"> ROSY LIP TATTO </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HIFU (FACE AND BODY)</h3>
                        <p class="text"> HIFU (FACE AND BODY) </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HIFU V-MAX V-LIFT</h3>
                        <p class="text"> HIFU V-MAX V-LIFT </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">BOTOX</h3>
                        <p class="text"> BOTOX </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">FILLERS</h3>
                        <p class="text"> FILLERS </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HIKO NOSE THREADS</h3>
                        <p class="text">  HIKO NOSE THREADS </p>
                    </li>
                    <li class="service-item">
                        <img src="service.jpg" alt="Services" class="service-image">
                        <h3 class="name">HYRDA</h3>
                        <p class="text">  WARTS REMOVAL </p>
                    </li>
               
                </ul>
            </div>
        </section>

        <!--STAFF'S SECTION-->

        <section class="staff-section" id="staff">
            <h2 class="section-title">OUR STAFF</h2>
                <div class="section-content">
                     <div class="slider-container swiper">
                        <div class="slider-wrapper">
                            <ul class="staff-list swiper-wrapper">

                                <li class="staff swiper-slide">
                                    <img src="staff01.png" alt="Staff" class="staff-image">
                                    <h3 class="name">INNA JAYNE C. LOPEZ</h3>
                                    <p class="position">CEO / NURSE</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff02.png" alt="Staff" class="staff-image">
                                    <h3 class="name">CHARLES MANAYON</h3>
                                    <p class="position">RECEPTIONIST / AESTHETICIAN</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff03.png" alt="Staff" class="staff-image">
                                    <h3 class="name">ROSANNA BOLAÑA</h3>
                                    <p class="position">RECEPTIONIST</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff04.png" alt="Staff" class="staff-image">
                                    <h3 class="name">JOWIE MAE L CRUZ</h3>
                                    <p class="position">AESTHETICIAN</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff05.png" alt="Staff" class="staff-image">
                                    <h3 class="name">DIMPLE MARRIEL ITALIA</h3>
                                    <p class="position">AESTHETICIAN</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff06.png" alt="Staff" class="staff-image">
                                    <h3 class="name">JOY CUANTRONA</h3>
                                    <p class="position">MASSAGE THERAPIST</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff07.png" alt="Staff" class="staff-image">
                                    <h3 class="name">NORIE CABUS</h3>
                                    <p class="position">NAIL TECH</p>
                                </li>
                                <li class="staff swiper-slide">
                                    <img src="staff08.png" alt="Staff" class="staff-image">
                                    <h3 class="name">JAMES FRANCIS CRUZ</h3>
                                    <p class="position">NAIL TECH</p>
                                </li>

                            </ul>

                             <div class="swiper-pagination"></div>
                             <div class="swiper-slide-button swiper-button-prev"></div>
                             <div class="swiper-slide-button swiper-button-next"></div>

                        </div>
                    </div>
                </div>
        </section>

        <!--REVIEWS SECTION-->

        <section class="reviews-section" id="reviews">
            <h2 class="section-title">REVIEWS</h2>
            <div class="section-content">
                <ul class="reviews-list">
                    <li class="reviews-item">
                        <img src="review01.jpg" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review02.jpg" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review03.jpg" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review04.jpg" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review05.png" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review06.png" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review07.png" alt="Reviews" class="reviews-image">
                    </li>
                    <li class="reviews-item">
                        <img src="review08.png" alt="Reviews" class="reviews-image">
                    </li>
                </ul>
            </div>
        </section>

        <!--CONTACT US SECTION-->

        <section class="contact-section" id="contact">
            <h2 class="section-title">CONTACT US</h2>
                <div class="section-content">
                    <ul class="contact-info-list">
                        <li class="contact-info">
                            <i class="fa-solid fa-location-crosshairs"></i>
                            <p>#137 SAN VICENTE STREET BARANGAY NUEVA SAN PEDRO LAGUNA</p>
                        </li>
                        <li class="contact-info">
                            <i class="fa-regular fa-envelope"></i>
                            <p>inna_jayne@yahhoo.com</p>
                        </li>
                        <li class="contact-info">
                            <i class="fa-solid fa-phone"></i>
                            <p>0995-382-6157 / 0928-604-3023</p>
                        </li>
                        <li class="contact-info">
                            <i class="fa-regular fa-clock"></i>
                            <p>MONDAY - SUNDAY: 10:00 AM - 8:00 PM</p>
                        </li>
                        <li class="contact-info">
                            <i class="fa-solid fa-globe"></i>
                            <p>glowfabskincarespa.com.ph</p>
                        </li>
                    </ul>
                    
                    

                    <form id="contactForm" class="contact-form">
                        <h3>SEND US A MESSAGE FOR HOME SERVICE</h3>
                        <input type="text" name="name" placeholder="Your Name" class="form-input" required>
                        <input type="email" name="email" placeholder="Your Email" class="form-input" required>
                        <textarea name="message" placeholder="Your Message" class="form-input" required></textarea>
                        <button type="submit" class="button submit-button">Submit</button>
                        <p id="formResponse" style="color:green;"></p>
                    </form>
                    
                    <?php
                    // 1. Handle form submission via POST
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                        if (!$conn) {
                            echo "Connection failed: " . mysqli_connect_error();
                            exit;
                        }

                        // Get POST data safely
                        $name = mysqli_real_escape_string($conn, $_POST['name']);
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                        $message = mysqli_real_escape_string($conn, $_POST['message']);

                        $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

                        if (mysqli_query($conn, $sql)) {
                            echo "Message sent successfully!";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }

                        mysqli_close($conn);
                        exit; // Important: stop further HTML output for AJAX
                    }
                    ?>

                    <script>
                    // 2. AJAX submission
                    const form = document.getElementById('contactForm');
                    const responseEl = document.getElementById('formResponse');

                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Prevent page reload

                        const formData = new FormData(form);

                        fetch('', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.text())
                        .then(data => {
                            // responseEl.textContent = data;
                            // form.reset();
                        })
                        .catch(err => {
                            // responseEl.textContent = 'Error sending message.';
                            // console.error(err);
                        });
                    });
                    
                    </script>

                </div>
        </section>

        <!--FOOTER SECTION-->

        <footer class="footer-section" >
            <div class="section-content">
                <p>© 2024 GlowFab Spa. All rights reserved.</p>



            </div>
        </footer>


        </main>
        <!--swiper script-->
        <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
        <!--custom script-->
        <script src="script.js"></script>

        <script>
function showAuth(){
document.getElementById("authSection").style.display="block";
window.scrollTo({ top: document.getElementById("authSection").offsetTop, behavior: 'smooth'});
}

function showRegister(){
document.getElementById("loginForm").style.display="none";
document.getElementById("registerForm").style.display="block";
document.getElementById("formTitle").innerText="Register";
}

function showLogin(){
document.getElementById("loginForm").style.display="block";
document.getElementById("registerForm").style.display="none";
document.getElementById("formTitle").innerText="Login";
}
</script>


    </body>
</html>
