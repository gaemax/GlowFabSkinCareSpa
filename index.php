<?php
    session_start();
    if(!isset($_SESSION["loggedin"])) {
        header("location: login.php");
    }
?>

<html>  
    <head>
        <title>Home - Glow Fab</title>
        <link rel="stylesheet" href="styles/global.css">
        <link rel="stylesheet" href="styles/index.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        
    <header>
        <div class="navigatorBar">
            <h1>Glow Fab</h1>
            <span>
                <ul>
                    <!-- <li><a href="#hero">Home</a></li> -->
                    <li><a href="#aboutUs">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#staff">Staff</a></li>
                    <li><a href="#reviews">Reviews</a></li>
                    <li><a href="#contactUs">Contact Us</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </span>
        </div>
    </header>

    <section id="hero" class="heroSection">
        <div>
            <h2>Glow fab Skin Care Spa</h2>
            <h3>GLOW YOU DAY WITH GLOW FAB SKIN CARE SPA</h3>
            <a href="booking.php"><button class="primaryButton">Book Now</button></a>
            <a href="mybookings.php"><button class="secondaryButton">My Bookings</button></a>
            <img src="images/logo01.png" alt="">
        </div>
    </section>

    <section id="aboutUs" class="aboutUsSection">
        <div>
            <h1>About Us!</h1>
            <p>Glow Fab Skin Care Spa is your go-to place for relaxation, beauty, and confidence. We offer quality skin care and beauty treatments designed to enhance your natural glow, using safe products and professional techniques. At Glow Fab, we believe that everyone deserves to feel beautiful, refreshed, and confident.</p>
            <img src="images/logo02.png" alt="">
        </div>
    </section>

    <?php

        $services = [
            [
                "serviceName" => "Facial",
                "serviceDescription" => "Facial Services",
                "image" => "images/"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Hydra Facial"
            ],

            [
                "serviceName" => "Black Doll Carbon Laser",
                "serviceDescription" => "Black Doll Carbon Laser"
            ],

            [
                "serviceName" => "Microblading",
                "serviceDescription" => "Massage Services"
            ],

            [
                "serviceName" => "Eyelash Extension",
                "serviceDescription" => "Eyelash Extension"
            ],

            [
                "serviceName" => "Gluta Push and Drip",
                "serviceDescription" => "Gluta Push and Drip"
            ],

            [
                "serviceName" => "IPL Hair Removal",
                "serviceDescription" => "IPL Hair Removal"
            ],

            [
                "serviceName" => "Combro Brows",
                "serviceDescription" => "Tattoo Removal"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Microblading"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Combro Brows"
            ],

            [
                "serviceName" => "Rosy Lip Tattoo",
                "serviceDescription" => "Rosy Lip Tattoo"
            ],

            [
                "serviceName" => "HIFU (Face and Body)",
                "serviceDescription" => "HIFU (Face and Body)"
            ],

            [
                "serviceName" => "HIFU V-Max V-Lift",
                "serviceDescription" => "HIFU V-Max V-Lift"
            ],

            [
                "serviceName" => "Botox",
                "serviceDescription" => "Botox"
            ],

            [
                "serviceName" => "Fillers",
                "serviceDescription" => "Fillers"
            ],

            [
                "serviceName" => "Hiko Nose Threads",
                "serviceDescription" => "Hiko Nose Threads"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Warts Removal"
            ]
        ];
    ?>

    <section id="services" class="servicesSection">
        <h1 class="header-text">Our Services</h1>
        <div class="servicesContainer">
            <?php foreach ($services as $service): ?>
                <div class="serviceCard">
                    <img src="<?= htmlspecialchars($service['imgSource']) ?>" alt="<?= htmlspecialchars($service['serviceName']) ?>" />
                    <h3><?= htmlspecialchars($service['serviceName']) ?></h3>
                    <p><?= htmlspecialchars($service['serviceDescription']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php
        $staffs = [
            [
                "name" => "Inna Jayne C. Lopez",
                "role" => "CEO  / Spa Manager ",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Rosanna Bolaño",
                "role" => "Receptionists / Front Desk Staff ",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Charles Manayon",
                "role" => "Therapists / Aestheticians",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Jowie L. Cruz",
                "role" => "Therapists / Aestheticians",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Dimple Mariel Italia",
                "role" => "Therapists / Aestheticians",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Joy Cuatrona",
                "role" => "Massage Therapist",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "James Francis Cruz",
                "role" => "Nail Technicians",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Norie Cabus",
                "role" => "Nail Technicians",
                "imgSource" => "images/staff.jpg"
            ],
        ];
    ?>

    <section id="staff" class="staffSection">
        <h1 class="header-text">Our Staff</h1>
        <div class="staffCarousel">
            <?php foreach ($staffs as $staff): ?>
                <div class="staffCard">
                    <img src="<?= htmlspecialchars($staff['imgSource']) ?>" alt="<?= htmlspecialchars($staff['name']) ?>" />
                    <h3><?= htmlspecialchars($staff['name']) ?></h3>
                    <p><?= htmlspecialchars($staff['role']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php
        $reviews = [
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!",
                "imgSource" => "images/Reviews.png"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
            [
                "name" => "John Doe",
                "reviewMessage" => "The service is very good!"
            ],
        ];
    ?>
    
    <section id="reviews" class="reviewsSection">
        <h1 class="header-text">Reviews</h1>
        <div class="reviewContainer">
            <?php foreach ($reviews as $review): ?>
                <div class="reviewCard">
                    <p class="reviewMessage"><?= htmlspecialchars($review["reviewMessage"]) ?></p>
                    <p class="reviewSender"><b><?= htmlspecialchars($review["name"]) ?></b></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>



    <section id="contactUs" class="contactSection">
        <h1 class="header-text">Contact Us</h1>
        <div class="contactContainer">
            <div class="contactInfo">
                <ul>
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
                        <p>MONDAY - SUNDAY: 11:00 AM - 9:00 PM</p>
                    </li>
                    <li class="contact-info">
                        <i class="fa-solid fa-globe"></i>
                        <p>glowfabskincarespa.com.ph</p>
                    </li>
                </ul>
            </div>
            <div class="contactForm">
                <form action="" class="contactCard">
                    <label>Send us a Message for Home Service</label>
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <textarea placeholder="Your Message" required></textarea>
                    <input type="submit">
                </form>
            </div>
        </div>
    </section>

    </body>
</html>