<?php
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : "dashboard";


?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{ margin:0; font-family:Arial; display:flex; background:#f4f6fb; }
/* Sidebar */
.sidebar{ width:230px; background:#ff4da6; height:100vh; color:white; padding-top:20px; position:fixed; }
.sidebar h2{ text-align:center; margin-bottom:30px; }
.sidebar a{ display:block; color:white; padding:15px; text-decoration:none; transition:.3s; }
.sidebar a:hover{ background:#e60073; }
/* Main */
.main{ margin-left:230px; padding:30px; width:100%; }
/* Card / Dashboard stats */
.card{ background:white; padding:20px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.1); margin-bottom:20px; }
/* Table */
table{ width:100%; border-collapse:collapse; }
th,td{ padding:12px; border-bottom:1px solid #eee; text-align:center; }
th{ background:#ff4da6; color:white; }
/* Search */
.search{ margin-bottom:15px; }
.search input{ padding:10px; width:250px; border-radius:8px; border:1px solid #ccc; }
.search button{ padding:10px 15px; background:#ff4da6; border:none; color:white; border-radius:8px; cursor:pointer; }
/* Form */
form input, form select{ width:100%; padding:10px; margin:5px 0; border-radius:8px; border:1px solid #ccc; }
form button{ padding:12px 20px; border:none; border-radius:10px; background:#ff4da6; color:white; cursor:pointer; }
form button:hover{ background:#e60073; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>GlowFab Admin</h2>
  <a href="?page=dashboard">Dashboard</a>
  <a href="?page=appointments">Appointments</a>
  <a href="?page=clients">Clients</a>
  <a href="?page=reports">Reports</a>
  <a href="?page=calendar">Calendar</a>
  <div style="position:absolute; bottom:20px; width:100%;">
      <a href="admin_logout.php" style="background:#e60073; text-align:center;">Logout</a>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<?php
/* ================= DASHBOARD ================= */
if($page=="dashboard"){

$totalClients = $conn->query("SELECT id FROM clients")->num_rows;
$totalServices = $conn->query("SELECT id FROM services")->num_rows;
$totalAppointments = $conn->query("SELECT id FROM bookings")->num_rows;
$totalAccepted = $conn->query("SELECT id FROM bookings WHERE status='Accepted'")->num_rows;
$totalRejected = $conn->query("SELECT id FROM bookings WHERE status='Rejected'")->num_rows;

echo "<div class='card'><h2>Dashboard Overview</h2>
<p>Total Clients: <b>$totalClients</b></p>
<p>Total Services: <b>$totalServices</b></p>
<p>Total Appointments: <b>$totalAppointments</b></p>
<p>Total Accepted Appointments: <b>$totalAccepted</b></p>
<p>Total Rejected Appointments: <b>$totalRejected</b></p>
</div>";
}

/* ================= APPOINTMENTS ================= */
elseif($page=="appointments"){

$search = isset($_GET['search']) ? $_GET['search'] : "";

// Handle approve/reject action
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    $action = $_GET['action'] === "accept" ? "Accepted" : "Rejected";
    $conn->query("UPDATE bookings SET status='$action' WHERE id=$id");
    header("Location: ?page=appointments&search=$search");
    exit;
}

$q = $conn->query("
SELECT bookings.*, clients.name
FROM bookings
JOIN clients ON bookings.user_email = clients.email
ORDER BY date DESC
");
?>

<div class="card">
<h2>Appointments</h2>
<div class="search">
<form method="GET">
<input type="hidden" name="page" value="appointments">
<input type="text" name="search" placeholder="Search client name..." value="<?= htmlspecialchars($search) ?>">
<button>Search</button>
</form>
</div>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=$q->fetch_assoc()){ ?>

<?php
$myDate = new DateTime($row['date']);
$myDate = $myDate->format('M d, Y');
?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td> <!--$row['name'] -->
<td><?= htmlspecialchars($row['service']) ?></td>
<td><?= $myDate ?></td>
<td><?= $row['time'] ?></td>
<td><?= isset($row['status']) ? $row['status'] : 'Pending' ?></td>
<td>
<?php if($row['status']=="Pending"){ ?>
<a href="?page=appointments&id=<?= $row['id'] ?>&action=accept" style="color:green;">Accept</a> |
<a href="?page=appointments&id=<?= $row['id'] ?>&action=reject" style="color:red;">Reject</a>
<?php } else { echo "-"; } ?>
</td>
</tr>
<?php } ?>
</table>
</div>
<?php
}

/* ================= CLIENTS ================= */
elseif($page=="clients"){
$q = $conn->query("
SELECT bookings.*, clients.name
FROM bookings
JOIN clients ON bookings.user_email = clients.email
ORDER BY date DESC
");
?>
<div class="card">
<h2>Clients List</h2>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
</tr>

<?php while($u=$users->fetch_assoc()){ ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= htmlspecialchars($u['phone']) ?></td>
</tr>
<?php } ?>
</table>
</div>
<?php
}

/* ================= ADD SERVICE ================= */
elseif($page=="add_service"){
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO services (name,price) VALUES ('$name','$price')");
    echo "<p style='color:green;'>Service Added!</p>";
}
?>
<div class="card">
<h2>Add Service</h2>
<form method="POST">
<input type="text" name="name" placeholder="Service Name" required>
<input type="number" name="price" placeholder="Price" required>
<button name="add">Add Service</button>
</form>
</div>
<?php
}

/* ================= REPORTS ================= */
elseif($page=="reports"){
$bookings = $conn->query("
SELECT bookings.*, clients.name, clients.email
FROM bookings
JOIN clients ON bookings.client_email = clients.email
ORDER BY date DESC
");
?>
<div class="card">
<h2>Reports</h2>
<table>
<tr>
<th>ID</th>
<th>Client</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>
<?php while($b=$bookings->fetch_assoc()){ ?>
<tr>
<td><?= $b['id'] ?></td>
<td><?= htmlspecialchars($b['name']) ?></td>
<td><?= htmlspecialchars($b['service']) ?></td>
<td><?= $b['date'] ?></td>
<td><?= $b['time'] ?></td>
<td><?= isset($b['status']) ? $b['status'] : 'Pending' ?></td>
</tr>
<?php } ?>
</table>
</div>
<?php
}

/* ================= CALENDAR ================= */
elseif($page=="calendar"){
$month = date('m');
$year = date('Y');

$appointments = $conn->query("
SELECT bookings.*, clients.name
FROM bookings
JOIN clients ON bookings.client_email = clients.email
WHERE MONTH(date) = $month AND YEAR(date) = $year
ORDER BY date ASC, time ASC
");
$calendar = [];
while($a=$appointments->fetch_assoc()){
    $day = date('d', strtotime($a['date']));
    $calendar[$day][] = $a;
}
?>
<div class="card">
<h2>Booking Calendar - <?= date('F Y') ?></h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
<tr>
<th>Day</th>
<th>Client Bookings</th>
</tr>
<?php
for($d=1;$d<=31;$d++){
    echo "<tr><td>$d</td><td>";
    if(isset($calendar[$d])){
        foreach($calendar[$d] as $c){
            echo htmlspecialchars($c['name'])." - ".htmlspecialchars($c['service'])." @ ".$c['time']."<br>";
        }
    } else {
        echo "Available";
    }
    echo "</td></tr>";
}
?>
</table>
</div>
<?php
}
?>

</div> <!-- end main -->
</body>
</html>
