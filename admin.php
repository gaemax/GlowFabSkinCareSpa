<?php
    require "db.php";
    session_start();

    $loggedIn = !empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        die('Page not specified.');
    }

    if (!$loggedIn) {
        header("Location: login.php");
        exit();
    }

    $totalBookings = 0;
    $pending = 0;
    $approved = 0;
    $completed = 0;
    $cancelled = 0;

    $query = "
        SELECT s.name AS status, COUNT(b.booking_id) AS count
        FROM status s
        LEFT JOIN bookings b ON b.status_id = s.status_id
        GROUP BY s.status_id, s.name";
    $result = $conn->query($query);

    while($row = $result->fetch_assoc()) {
        $totalBookings += $row['count'];
        switch($row['status']) {
            case 'Pending': $pending = $row['count']; break;
            case 'Approved': $approved = $row['count']; break;
            case 'Completed': $completed = $row['count']; break;
            case 'Cancelled': $cancelled = $row['count']; break;
        }
    }

    $date = date("Y-m-d");
    $query = "
        SELECT b.*, CONCAT(u.lastname, ' ',u.firstname, ' ',u.middlename) as user_name, s.name as status_name
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN status s ON b.status_id = s.status_id
        WHERE date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $appointmentsToday = $result;


    // Fetch services
    $query = "SELECT * FROM services";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    $serviceList = $result;

    // Fetch subservices
    $query = "
    SELECT sb.*, s.name AS service_name
    FROM subservices sb
    JOIN services s ON sb.service_id = s.service_id";
    $result = $conn->query($query);
    $subserviceList = $result->fetch_all(MYSQLI_ASSOC);
    $groupedSubservices = [];
    foreach ($subserviceList as $sub) {
        $groupedSubservices[$sub['service_name']][] = $sub;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Glow Fab</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />
</head>
<body>

    <div class="sidebar">
        <h1>Glow Fab Admin</h1>
        <ul>
            <li><a href="admin.php?page=dashboard">Dashboard</a></li>
            <li><a href="admin.php?page=servicemanager">Service Manager</a></li>
            <li><a href="admin.php?page=appointments">Appointments</a></li>
            <li><a href="admin.php?page=clients">Clients</a></li>
            <li><a href="admin.php?page=reports">Reports</a></li>
            <li><a href="admin.php?page=calendar">Calendar</a></li>
            <li><a href="admin.php?page=messages">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <section class="mainBody">

    <?php if ($page == "dashboard"): ?>
        <h1>Dashboard Overview</h1>

        <div class="cardContainer">
            <div class="infoCard">
                <h1>Appointments</h1>
                <div class="splitter">
                    <h3>Total Bookings</h3>
                    <p><?= $totalBookings ?></p>
                </div>
                <div class="splitter">
                    <h3>Pending Bookings</h3>
                    <p><?= $pending ?></p>
                </div>
                <div class="splitter">
                    <h3>Approved Bookings</h3>
                    <p><?= $approved ?></p>
                </div>
                <div class="splitter">
                    <h3>Completed Bookings</h3>
                    <p><?= $completed ?></p>
                </div>
                <div class="splitter">
                    <h3>Cancelled Bookings</h3>
                    <p><?= $cancelled ?></p>
                </div>
            </div>
        </div>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <h1>Appointments Today</h1>
                <div class="bookingCard">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Sub-Service</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($appointmentsToday as $b): ?>
                        <tr>
                            <td><?= $b["booking_id"] ?></td>
                            <td><?= htmlspecialchars($b["user_name"]) ?></td>
                            <td><?= htmlspecialchars($b["service"]) ?></td>
                            <td><?= htmlspecialchars($b["subservice"]) ?></td>
                            <td><?= htmlspecialchars(date("F j, Y", strtotime($b["date"]))) ?></td>
                            <td><?= htmlspecialchars(date("g:i a", strtotime($b["start_time"]))) . " to " . date("g:i a", strtotime($b["end_time"]))?></td>
                            <td><?= htmlspecialchars($b["status_name"]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif ($page == "servicemanager"): ?>
        <h1>Service Manager</h1>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <h1>Services</h1>
                <div class="bookingCard">
                    <form method="POST" action="addService.php">
                        <label>Add New Service</label>
                        <input type="text" name="name" placeholder="Name">
                        <input type="text" name="desc" placeholder="Description">
                        <input type="submit" value="Add Service">
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($serviceList as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s["name"]) ?></td>
                            <td><?= htmlspecialchars($s["description"]) ?></td>
                            <td><a href="deleteService.php?id=<?= $s["service_id"] ?>"><button class="deleteButton">Delete</button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <h1>Sub-Services</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Parent Service</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($subserviceList as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s["name"]) ?></td>
                            <td><?= htmlspecialchars($s["service_name"]) ?></td>
                            <td><?= htmlspecialchars($s["description"]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>