<?php
    require "db.php";
    session_start();

    if(!isset($_SESSION["loggedin"])){
        header("Location: login.php");
        exit;
    }

    $query = "SELECT * FROM bookings WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $myBookingList = $result->fetch_all(MYSQLI_ASSOC);
?>

<html>
    <head>
        <title>My Bookings - Glow Fab</title>
        <link rel="stylesheet" href="styles/global.css">
        <link rel="stylesheet" href="styles/booking.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>

        <header>
            <div class="navigatorBar">
                <h1>Glow Fab</h1>
            </div>
        </header>
        
        <section class="bookingTableSection">
            <div class="bookingTableCard">
                <h1>My Bookings</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Service</th>
                            <th>Sub-Service</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status ID</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach($myBookingList as $b): ?>
                        <tr>
                                <td><?= $b["user_id"] ?> ></td>
                                <td><?= htmlspecialchars(intval($b["service"])) ?></td>
                                <td><?= htmlspecialchars($b["subservice"]) ?></td>
                                <td><?= htmlspecialchars($b["date"]) ?></td>
                                <td><?= htmlspecialchars($b["start_time"]) ?></td>
                                <td><?= htmlspecialchars($b["end_time"]) ?></td>
                                <td><?= htmlspecialchars($b["status_id"]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- <td>1</td>
                            <td>Facial Treatment</td>
                            <td>Deep Cleansing</td>
                            <td>2026-03-15</td>
                            <td>14:00:00</td>
                            <td>15:00:00</td>
                            <td>1</td>
                            <td>2026-02-22 10:30:00</td> -->
                    </tbody>
                </table>
            </div>
        </section>

    </body>
</html>
