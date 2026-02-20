<?php
session_start();
include "db.php";

if(!isset($_SESSION['client'])){
    header("Location: client_auth.php");
    exit;
}

$user_email = $_SESSION['client']['email'];

// Temporary services
$services = [
    [
        'name' => 'Facial',
        'price' => 500,
        'subservices' => [
            ['name'=>'Facial 1','price'=>500],
            ['name'=>'Facial 2','price'=>700],
            ['name'=>'Facial 3','price'=>300]
        ]
    ],
    [
        'name' => 'Massage',
        'price' => 700,
        'subservices' => [
            ['name'=>'Massage 1','price'=>500],
            ['name'=>'Massage 2','price'=>700],
            ['name'=>'Massage 3','price'=>300]
        ]
    ],
    [
        'name' => 'Manicure',
        'price' => 300,
        'subservices' => [
            ['name'=>'Manicure 1','price'=>500],
            ['name'=>'Manicure 2','price'=>700],
            ['name'=>'Manicure 3','price'=>300]
        ]
    ]
];


?>

<!DOCTYPE html>
<html>
<head>
<title>Book Appointment</title>
<style>
body{ font-family:Arial; background:#f4f6fb; padding:20px; }
.card{ background:white; padding:20px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.1); max-width:600px; margin:auto; }
form input, form select{ width:100%; padding:10px; margin:5px 0; border-radius:8px; border:1px solid #ccc; }
form button{ padding:12px 20px; border:none; border-radius:10px; background:#ff4da6; color:white; cursor:pointer; }
form button:hover{ background:#e60073; }
.message{ padding:10px; border-radius:8px; margin-bottom:15px; display:none; }
.message.success{ background:#d4edda; color:#155724; }
.message.error{ background:#f8d7da; color:#721c24; }
.calendar { margin-top:20px; }
table { border-collapse: collapse; width: 100%; }
th, td { border:1px solid #ccc; padding:8px; text-align:center; }
th { background:#ff4da6; color:white; }
.booked { background:#f8d7da; color:#721c24; }
</style>
</head>
<body>

<div class="card">
<h2>Book Your Appointment</h2>

<div id="message" class="message"></div>

<form id="bookingForm">
    <label>Service</label>
    <select name="service" id="service" required>
        <option value="">Select Service</option>
        <?php foreach($services as $index => $s): ?>
            <option value="<?= $index ?>">
                <?= $s['name'] ?> - ₱<?= $s['price'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- subservices. it uses javascript to automatically populate the subservice list -->
    <label>Sub-Service</label>
    <select name="subservice" id="subservice" required>
        <option value="">Select Sub-Service</option>
    </select>

    <label>Date</label>
    <input type="date" name="date" id="date" min="<?= date('Y-m-d') ?>" required>

    <label>Time</label>
    <input type="time" name="time" id="time" required>

    <button type="submit">Book Appointment</button>
</form>

<script>
    const services = <?= json_encode($services); ?>;

    const serviceSelect = document.getElementById("service");
    const subserviceSelect = document.getElementById("subservice");

    serviceSelect.addEventListener("change", function () {

    const selectedIndex = this.value;

    subserviceSelect.innerHTML = '<option value="">Select Sub-Service</option>';

    if (selectedIndex === "") return;

    const selectedService = services[selectedIndex];

    selectedService.subservices.forEach(sub => {
        const option = document.createElement("option");
        option.value = sub.name;
        option.textContent = `${sub.name} - ₱${sub.price}`;
        subserviceSelect.appendChild(option);
    });

});
</script>


<div class="calendar">
<h3>Availability Calendar (Current Month)</h3>
<table id="calendarTable">
<thead>
<tr><th>Day</th><th>Booked Times</th></tr>
</thead>
<tbody></tbody>
</table>
</div>
</div>

<script>
// ================= Check Availability =================
document.getElementById('bookingForm').addEventListener('submit', function(e){
    e.preventDefault();
    const service = document.getElementById('service').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;

    if(!service || !date || !time) return;

    fetch('check_booking.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({service,date,time})
    })
    .then(res => res.json())
    .then(data => {
        const msgDiv = document.getElementById('message');
        if(data.available){
            msgDiv.textContent = "Booking successful!";
            msgDiv.className = "message success";
            msgDiv.style.display = "block";
            loadCalendar(); // refresh calendar
        } else {
            msgDiv.textContent = "Sorry, this time is already booked by another client!";
            msgDiv.className = "message error";
            msgDiv.style.display = "block";
        }
    });
});

// ================= Load Calendar =================
function loadCalendar(){
    fetch('get_calendar.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('#calendarTable tbody');
        tbody.innerHTML = '';
        for(const day in data){
            const tr = document.createElement('tr');
            const tdDay = document.createElement('td');
            tdDay.textContent = day;
            const tdTimes = document.createElement('td');
            tdTimes.innerHTML = data[day].length ? data[day].join('<br>') : "Available";
            if(data[day].length) tdTimes.className = "booked";
            tr.appendChild(tdDay);
            tr.appendChild(tdTimes);
            tbody.appendChild(tr);
        }
    });
}

// Load calendar on page load
loadCalendar();
</script>

</body>
</html>
