<?php
    session_start();
    if(isset($_SESSION["loggedin"])) {
        header("location: login");
    }
?>

<html>
    <head>
        <title>Glow Fab</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    </head>
    <body>
        
    <header>
        <div class="navigatorBar" width="">
            <h1>Glow Fab</h1>
            <ul>
                <li>Home</li>
                <li>About</li>
                <li>Services</li>
                <li>Staff</li>
                <li>Reviews</li>
                <li>Contact Us</li>
            </ul>
        </div>
    </header>

    <section class="heroSection">
        <div>
            <h2>Glow fab Skin Care Spa</h2>
            <h3>GLOW YOU DAY WITH GLOW FAB SKIN CARE SPA</h3>
            <button class="primaryButton">Book Now</button>
        </div>
    </section>

    <section class="aboutUsSection">
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

    <section class="servicesSection">
        <h1>Our Services</h1>
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

    <section class="staffSection">
        <h1>Our Staff</h1>
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
            "images/review1.jpg",
            "images/review2.jpg",
            "images/review3.jpg",
            "images/review4.jpg",
            "images/review5.jpg"
        ];
    ?>

    <section class="reviewsSection">
        <h1>Reviews</h1>
        <div class="reviewContainer">
            <?php foreach ($reviews as $review): ?>
                <img src="<?= htmlspecialchars($review) ?>" alt="<?= htmlspecialchars($review) ?>">
            <?php endforeach; ?>
        </div>
    </section>

    </body>
</html>