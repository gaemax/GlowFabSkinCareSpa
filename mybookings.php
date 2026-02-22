<?php
    require "db.php";
    session_start();

    if(!isset($_SESSION["loggedin"])){
        header("Location: login.php");
        exit;
    }

    $query = "
        SELECT 
            b.booking_id,
            b.date,
            b.start_time,
            b.end_time,
            s.name as status_name,
            sr.name as service,
            sbsr.name as subservice
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN status s ON b.status_id = s.status_id
        JOIN services sr ON b.service_id = sr.service_id
        JOIN subservices sbsr ON b.subservice_id = sbsr.subservice_id
        WHERE b.user_id = ?
    ";
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
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
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
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($myBookingList as $b): ?>
                        <tr>
                            <td><?= $b["booking_id"] ?></td>
                            <td><?= htmlspecialchars($b["service"]) ?></td>
                            <td><?= htmlspecialchars($b["subservice"]) ?></td>
                            <td><?= htmlspecialchars(date("F j, Y", strtotime($b["date"]))) ?></td>
                            <td><?= htmlspecialchars(date("g:i a", strtotime($b["start_time"]))) . " to " . date("g:i a", strtotime($b["end_time"]))?></td>
                            <td><?= htmlspecialchars($b["status_name"]) ?></td>
                            <td>
                                <?php if ($b["status_name"] === "Pending"): ?>
                                    <a href="editbooking.php?booking_id=<?= $b["booking_id"] ?>">
                                        <button class="reschedButton">Reschedule</button>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </body>
</html>
