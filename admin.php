<?php
    require "db.php";
    session_start();

    $loggedIn = !empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

    if (isset($_GET['year'])) {
        $calendayYear = $_GET['year'];
    } else {
       $calendayYear = 0;
    }


    if (isset($_GET['year'])) {
        $calendayYear = $_GET['year'];
    } else {
       $calendayYear = 0;
    }


    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page ="dashboard";
        $page ="dashboard";
    }

    if (isset($_GET['message_id'])) {
        $messageId = $_GET['message_id'];
    } else {
        $messageId = -1;
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
        SELECT 
            b.*,
            CONCAT(u.lastname, ', ',u.firstname, ' ',u.middlename) as user_name,
            s.name as status_name,
            sr.name as service,
            sbsr.name as subservice
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN status s ON b.status_id = s.status_id
        JOIN services sr ON b.service_id = sr.service_id
        JOIN subservices sbsr ON b.subservice_id = sbsr.subservice_id
        WHERE b.date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $appointmentsToday = $result;


    // Fetch services
    $query = "
        SELECT *
        FROM services
        WHERE deleted_at IS NULL
    ";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    $serviceList = $result;

    // Fetch subservices
    $query = "
        SELECT sb.*, s.name AS service_name
        FROM subservices sb
        JOIN services s ON sb.service_id = s.service_id
        WHERE sb.deleted_at IS NULL
    ";
    $result = $conn->query($query);
    $subserviceList = $result->fetch_all(MYSQLI_ASSOC);
    $groupedSubservices = [];
    foreach ($subserviceList as $sub) {
        $groupedSubservices[$sub['service_name']][] = $sub;
    }

    $statusId = $_GET['status_id'] ?? null;
    $serviceId = $_GET['service_id'] ?? null;
    $date = $_GET['date'] ?? null;
    
    $where = [];
    $params = [];
    $types = "";
    
    if ($statusId) {
        $where[] = "b.status_id = ?";
        $params[] = $statusId;
        $types .= "i"; // integer
    }

    if ($serviceId) {
        $where[] = "b.service_id = ?";
        $params[] = $serviceId;
        $types .= "i";
    }

    if ($date) {
        $where[] = "b.date = ?";
        $params[] = $date;
        $types .= "s"; // string
    }

    $whereSQL = "";
    if (!empty($where)) {
        $whereSQL = "WHERE " . implode(" AND ", $where);
    }

    $query = "
        SELECT 
            b.*,
            CONCAT(u.lastname, ', ', u.firstname, ' ', u.middlename) AS user_name,
            s.name AS status_name,
            sr.name AS service,
            sbsr.name AS subservice
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN status s ON b.status_id = s.status_id
        JOIN services sr ON b.service_id = sr.service_id
        JOIN subservices sbsr ON b.subservice_id = sbsr.subservice_id
        $whereSQL
        ORDER BY b.date
    ";
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


    $query = "
        SELECT m.message_id,
        m.messageBody,
        m.created_at as date,
        CONCAT(u.lastname, ', ',u.firstname, ' ',u.middlename) AS user_name
        FROM messages m
        JOIN users u ON m.user_id = u.user_id";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    $messages = $result;

    $query = "
        SELECT m.message_id,
        m.messageBody,
        m.created_at as date,
        CONCAT(u.lastname, ', ',u.firstname, ' ',u.middlename) AS user_name
        FROM messages m
        JOIN users u ON m.user_id = u.user_id
        WHERE m.message_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $messageId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $messageResult = $result;
    
    
    
    if (!isset($messageResult)) {
        $messageResult["not_chosen_state"] = true;
        $messageResult["user_name"] = "No Chosen Message";
        $messageResult["messageBody"] = "Choose a message to view";
    } else {
        $messageResult["not_chosen_state"] = false;
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
            <li><a href="admin.php?page=appointments">Appointments</a></li>
            <li><a href="admin.php?page=clients">Clients</a></li>
            <li><a href="admin.php?page=calendar&year=2026">Calendar</a></li>
            <li><a href="admin.php?page=servicemanager">Service Manager</a></li>
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
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="text" name="desc" placeholder="Description" required>
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
                        <input type="text" name="name" placeholder="Name" required>
                        <select name="parentService" required>
                            <option value="">Choose parent service</option>
                            <?php foreach($serviceList as $s): ?>
                                <option value="<?= htmlspecialchars($s["name"]) ?>"><?= htmlspecialchars($s["name"]) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="desc" placeholder="Description" required>
                        <input type="number" name="price" placeholder="Price" required>
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
                            <td>P <?= htmlspecialchars($s["price"]) ?></td>
                            <td><a href="deleteService.php?subservice_id=<?= $s["subservice_id"] ?>"><button class="deleteButton">Delete</button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    
            <?php elseif ($page == "appointments"): ?>
        <h1>Appointments</h1>

        
        <div style="margin-bottom:15px;">
            <input type="text" id="searchInput" placeholder="Search appointments..."
                style="padding:8px; width:250px; border-radius:6px; border:1px solid #ccc;">
        </div>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <table id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Sub-Service</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th></th>
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
                            <td>
                                <form method="POST" action="changeStatus.php" class="editStatusForm">
                                    <input type="hidden" name="booking_id" value="<?=$a["booking_id"]?>">
                                    <select name="status_id">
                                        <option value=""></option>
                                        <option value="1">Pending</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Completed</option>
                                        <option value="4">Cancelled</option>
                                    </select>
                                    <input type="submit" value="Set">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>    
            </div>
        </div>

        
        <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#appointmentsTable tbody tr");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
        </script>

    
    <?php elseif ($page == "clients"): ?>

    <h1>Clients</h1>

        
        <div style="margin-bottom:15px;">
            <input type="text" id="clientSearch" placeholder="Search clients..."
                style="padding:8px; width:250px; border-radius:6px; border:1px solid #ccc;">
        </div>

        <div class="cardContainer">
            <div class="infoCard bookingTableCard">
                <table id="clientsTable">
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

       
        <script>
        document.getElementById("clientSearch").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#clientsTable tbody tr");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>

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
                                SELECT 
                                    b.*,
                                    CONCAT(u.lastname, ', ',u.firstname, ' ',u.middlename) as user_name,
                                    s.name as status_name,
                                    sr.name as service,
                                    sbsr.name as subservice,
                                    sbsr.price as price
                                FROM bookings b
                                JOIN users u ON b.user_id = u.user_id
                                JOIN status s ON b.status_id = s.status_id
                                JOIN services sr ON b.service_id = sr.service_id
                                JOIN subservices sbsr ON b.subservice_id = sbsr.subservice_id
                                WHERE YEAR(date) = ? AND MONTH(date) = ?";
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
                                    <th>Time</th>
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

                                        
                                        <td>
                                            <?= htmlspecialchars(date("g:i A", strtotime($mf["start_time"]))) ?>
                                            <?= htmlspecialchars(date("g:i A", strtotime($mf["end_time"]))) ?>
                                        </td>

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
        <div class="messageListContainer">
            <div class="messageList">
                <?php foreach($messages as $m): ?>
                    <a href="admin.php?page=messages&message_id=<?= $m['message_id'] ?>" ?>
                        <div class="messageItem">
                            <h3><?= htmlspecialchars($m["user_name"]) ?></h3>
                            <h5><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($m["date"]))) ?></h5>
                            <p><?= htmlspecialchars($m["messageBody"]) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="messageDetails">
                <h1><?= htmlspecialchars($messageResult["user_name"]) ?></h1>
                <?php if(!$messageResult["not_chosen_state"]): ?>
                    <p>Date Sent: <?= htmlspecialchars(date("F j, Y, g:i A", strtotime($messageResult["date"]))) ?></p>
                <?php endif; ?>
                <p><?= htmlspecialchars($messageResult["messageBody"])  ?></p>
            </div>
        </div>
    <?php endif; ?> 

</body>
</html>