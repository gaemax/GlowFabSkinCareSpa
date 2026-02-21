<?php
    session_start();
    if(isset($_SESSION["loggedin"])) {
        header("location: login");
    }
?>

<html>
    <head>
        <title>Home - Glow Fab</title>
        <link rel="stylesheet" href="styles/index.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        
    <header>
        <div class="navigatorBar" width="">
            <h1>Glow Fab</h1>
            <ul>
                <li><a href="#hero">Home</a></li>
                <li><a href="#aboutUs">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#staff">Staff</a></li>
                <li><a href="#reviews">Reviews</a></li>
                <li><a href="#contactUs">Contact Us</a></li>
            </ul>
        </div>
    </header>

    <section id="hero" class="heroSection">
        <div>
            <h2>Glow fab Skin Care Spa</h2>
            <h3>GLOW YOU DAY WITH GLOW FAB SKIN CARE SPA</h3>
            <button class="primaryButton">Book Now</button>
        </div>
    </section>

    <section id="aboutUs" class="aboutUsSection">
        <div>
            <h1>About Us!</h1>
            <p>Glow Fab Skin Care Spa is your go-to place for relaxation, beauty, and confidence. We offer quality skin care and beauty treatments designed to enhance your natural glow, using safe products and professional techniques. At Glow Fab, we believe that everyone deserves to feel beautiful, refreshed, and confident.</p>
        </div>
    </section>

    <?php

        $services = [
            [
                "serviceName" => "Facial",
                "serviceDescription" => "Facial Services",
                "imgSource" => "images/facial.jpg"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Hydra Facial",
                "imgSource" => "images/hydra.jpg"
            ],

            [
                "serviceName" => "Black Doll Carbon Laser",
                "serviceDescription" => "Black Doll Carbon Laser",
                "imgSource" => "images/black-doll.jpg"
            ],

            [
                "serviceName" => "Microblading",
                "serviceDescription" => "Massage Services",
                "imgSource" => "images/microblading.jpg"
            ],

            [
                "serviceName" => "Eyelash Extension",
                "serviceDescription" => "Eyelash Extension",
                "imgSource" => "images/eyelashes.jpg"
            ],

            [
                "serviceName" => "Gluta Push and Drip",
                "serviceDescription" => "Gluta Push and Drip",
                "imgSource" => "images/gluta.jpg"
            ],

            [
                "serviceName" => "IPL Hair Removal",
                "serviceDescription" => "IPL Hair Removal",
                "imgSource" => "images/ipl.jpg"
            ],

            [
                "serviceName" => "Combro Brows",
                "serviceDescription" => "Tattoo Removal",
                "imgSource" => "images/combro.jpg"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Microblading",
                "imgSource" => "images/hydra2.jpg"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Combro Brows",
                "imgSource" => "images/hydra3.jpg"
            ],

            [
                "serviceName" => "Rosy Lip Tattoo",
                "serviceDescription" => "Rosy Lip Tattoo",
                "imgSource" => "images/rosy-lip.jpg"
            ],

            [
                "serviceName" => "HIFU (Face and Body)",
                "serviceDescription" => "HIFU (Face and Body)",
                "imgSource" => "images/hifu-face-body.jpg"
            ],

            [
                "serviceName" => "HIFU V-Max V-Lift",
                "serviceDescription" => "HIFU V-Max V-Lift",
                "imgSource" => "images/hifu-vmax.jpg"
            ],

            [
                "serviceName" => "Botox",
                "serviceDescription" => "Botox",
                "imgSource" => "images/botox.jpg"
            ],

            [
                "serviceName" => "Fillers",
                "serviceDescription" => "Fillers",
                "imgSource" => "images/fillers.jpg"
            ],

            [
                "serviceName" => "Hiko Nose Threads",
                "serviceDescription" => "Hiko Nose Threads",
                "imgSource" => "images/hiko.jpg"
            ],

            [
                "serviceName" => "Hydra",
                "serviceDescription" => "Warts Removal",
                "imgSource" => "images/hydra4.jpg"
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
                "name" => "Staff Name1",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name2",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name3",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name4",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name5",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name6",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name7",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name8",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name9",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ],
            [
                "name" => "Staff Name10",
                "role" => "Staff Role",
                "imgSource" => "images/staff.jpg"
            ]
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
            ]
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
                        <p>MONDAY - SUNDAY: 10:00 AM - 8:00 PM</p>
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