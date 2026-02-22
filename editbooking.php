<?php
    require "db.php";
    session_start();

    if(!isset($_SESSION["loggedin"])){
        header("Location: login.php");
        exit;
    }

    if (isset($_GET['booking_id'])) {
        $bookingId = $_GET['booking_id'];
        $bookingId = (int)$bookingId;
    } else {
        die('Booking ID not specified.');
    }


    $errorMessage = "";

    // Fetch services
    $query = "SELECT service_id, name, description FROM services";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    $serviceList = $result;

    // Fetch subservices
    $query = "
    SELECT sb.subservice_id, sb.service_id, sb.name, sb.description, sb.price, s.name AS service_name
    FROM subservices sb
    JOIN services s ON sb.service_id = s.service_id";
    $result = $conn->query($query);
    $subserviceList = $result->fetch_all(MYSQLI_ASSOC);
    $groupedSubservices = [];
    foreach ($subserviceList as $sub) {
        $groupedSubservices[$sub['service_name']][] = $sub;
    }

    // Submit booking
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $service = trim($_POST["service"]);
        $subservice = trim($_POST["subservice"]);
        $time = trim($_POST["time"]);
        $date = trim($_POST["date"]);

        $time1 = explode(" - ", $time)[0];
        $time2 = explode(" - ", $time)[1];

        $timeStart = date("H:i:s", strtotime($time1));
        $timeEnd = date("H:i:s", strtotime($time2));
        // echo "<script>alert('$time1 $time2');</script>";

        $defaultStatus = 1;

        $query = "
        UPDATE bookings 
        SET service = ?, 
            subservice = ?, 
            date = ?, 
            start_time = ?, 
            end_time = ?
        WHERE booking_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sssssi",
            $service,
            $subservice,
            $date,
            $timeStart,
            $timeEnd,
            $bookingId
        );
        $stmt->execute();

        header("Location: mybookings.php");
        exit;
    }
    
?>

<html>
    <head>
        <title>Edit Booking - Glow Fab</title>
        <link rel="stylesheet" href="styles/global.css">
        <link rel="stylesheet" href="styles/booking.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>

    <header>
        <div class="navigatorBar">
            <h1>Glow Fab</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </div>
    </header>

        <section class="bookingSection">
            <div class="bookingCard">
                <h1>Edit your Appointment</h1>
                <p>Booking ID: <?= $bookingId ?></p>
                <form method="POST">

                    <div class="hContainer">
                        <select name="service" id="service" required>
                            <option value="">Choose a service</option>
                            <?php foreach($serviceList as $s): ?>
                                <option value="<?= htmlspecialchars($s["name"]) ?>">
                                    <?= htmlspecialchars($s["name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="subservice" id="subservice" required>
                        </select>
                    </div>

                    <input type="date" name="date" required>

                    <select name="time" id="time">
                        <option>11am - 12am</option>
                        <option>12am - 1pm</option>
                        <option>1pm - 2pm</option>
                        <option>2pm - 3pm</option>
                        <option>3pm - 4pm</option>
                        <option>4pm - 5pm</option>
                        <option>5pm - 6pm</option>
                        <option>6pm - 7pm</option>
                        <option>7pm - 8pm</option>
                        <option>8pm - 9pm</option>
                    </select>

                    <input type="submit" value="Confirm Booking">
                </form>
            </div>
        </section>
        
        <script>
            const subservices = <?= json_encode($subserviceList) ?>;
            const serviceSelect = document.getElementById('service');
            const subserviceSelect = document.getElementById('subservice');
                                
            console.log(subservices);
            serviceSelect.addEventListener('change', function() {
                const selectedServiceName = this.value;

                console.log(selectedServiceName);
                subserviceSelect.innerHTML = '';
                subserviceSelect.innerHTML = '<option value="">Choose a sub-service</option>';

                subservices.forEach(sub => {
                    if (sub["service_name"] === selectedServiceName) {
                        const option = document.createElement('option');
                        option.value = sub.name;
                        option.textContent = sub.name;
                        subserviceSelect.appendChild(option);
                    }
                });
            });
        </script>

    </body>
</html>
