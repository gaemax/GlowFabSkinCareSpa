<?php
    require "db.php";
    session_start();

    $loggedIn = !empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

    if (isset($_GET['year'])) {
        $calendayYear = $_GET['year'];
    } else {
       $calendayYear = 0;
    }


    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page ="dashboard";
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


    $query = "
        SELECT b.*, CONCAT(u.lastname, ' ',u.firstname, ' ',u.middlename) as user_name, s.name as status_name
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN status s ON b.status_id = s.status_id";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);

    $allAppointments = $result;

    $query = "
        SELECT *
        FROM users
        WHERE role = \"client\"";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);

    $allClients = $result;


    $months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
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
            <li><a href="admin.php?page=calendar&year=2026">Calendar</a></li>
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
                        <input type="text" name="name" placeholder="Name">
                        <input type="text" name="desc" placeholder="Description">
                        <input type="submit" value="Add/Edit Service">
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
                            <td><a href="deleteService.php?service_id=<?= $s["service_id"] ?>"><button class="deleteButton">Delete</button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <h1>Sub-Services</h1>
                <div class="bookingCard">
                    <form method="POST" action="addSubService.php">
                        <input type="text" name="name" placeholder="Name">
                        <select name="parentService">
                            <option value="">Choose parent service</option>
                            <?php foreach($serviceList as $s): ?>
                                <option value="<?= htmlspecialchars($s["name"]) ?>"><?= htmlspecialchars($s["name"]) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="desc" placeholder="Description">
                        <input type="number" name="price" placeholder="Price">
                        <input type="submit" value="Add/Edit Service">
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Parent Service</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($subserviceList as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s["name"]) ?></td>
                            <td><?= htmlspecialchars($s["service_name"]) ?></td>
                            <td><?= htmlspecialchars($s["description"]) ?></td>
                            <td><?= htmlspecialchars($s["price"]) ?></td>
                            <td><a href="deleteService.php?subservice_id=<?= $s["subservice_id"] ?>"><button class="deleteButton">Delete</button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif ($page == "appointments"): ?>
        <h1>Appointments</h1>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                // search control here
                <table>
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Sub-Service</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allAppointments as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a["user_name"]) ?></td>
                            <td><?= htmlspecialchars($a["service"]) ?></td>
                            <td><?= htmlspecialchars($a["subservice"]) ?></td>
                            <td><?= htmlspecialchars(date("F j, Y", strtotime($a["date"]))) ?></td>
                            <td><?= htmlspecialchars(date("g:i a", strtotime($a["start_time"]))) . " to " . date("g:i a", strtotime($a["end_time"])) ?></td>
                            <td><?= htmlspecialchars($a["status_name"]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif ($page == "clients"): ?>
        <h1>Clients</h1>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                // search control here
                <table>
                    <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allClients as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c["lastname"]) ?></td>
                            <td><?= htmlspecialchars($c["firstname"]) ?></td>
                            <td><?= htmlspecialchars($c["middlename"]) ?></td>
                            <td><?= htmlspecialchars($c["email"]) ?></td>
                            <td><?= htmlspecialchars($c["contact_number"]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif ($page == "reports"): ?>
        <h1>Reports</h1>
    <?php elseif ($page == "calendar"): ?>
        <h1>Calendar</h1>
        <div class="cardContainer">
            <div class="infoCard">
                <div class="bookingCard">
                    <h2><?= htmlspecialchars($calendayYear) ?></h2>
                    <form action="chooseYear.php">
                        <select name="chosenYear" id="">
                            <option value="2026">2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                        <input type="submit">
                    </form>
                </div>
                <div>
                </div>
                <?php foreach (range(1, 12) as $m): ?>
                    <div>
                        <h3><?= htmlspecialchars($months[$m-1]) ?></h3>
                        <?php
                            $date = date("Y-m-d");
                            $query = "
                                SELECT b.*, CONCAT(u.lastname, ' ',u.firstname, ' ',u.middlename) as user_name, s.name as status_name, sb.price as price
                                FROM bookings b
                                JOIN users u ON b.user_id = u.user_id
                                JOIN status s ON b.status_id = s.status_id
                                JOIN subservices sb ON b.subservice = sb.name
                                WHERE YEAR(b.date) = ? AND MONTH(b.date) = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param(
                                "ss", 
                                $calendayYear,
                                $m
                                );
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                            $monthlyFilter = $result;
                        ?>
                        <table class="calendarTable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Client Name</th>
                                    <th>Service</th>
                                    <th>Subservice</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($monthlyFilter as $mf): ?>
                                    <tr>
                                        <td><?= htmlspecialchars(date("j", strtotime($mf["date"]))) ?></td>
                                        <td><?= htmlspecialchars($mf["user_name"]) ?></td>
                                        <td><?= htmlspecialchars($mf["service"]) ?></td>
                                        <td><?= htmlspecialchars($mf["subservice"]) ?></td>
                                        <td><?= htmlspecialchars($mf["status_name"]) ?></td>
                                        <td>P <?= htmlspecialchars($mf["price"]) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php elseif ($page == "messages"): ?>
        <h1>Messages</h1>
    <?php endif; ?>

</body>
</html>