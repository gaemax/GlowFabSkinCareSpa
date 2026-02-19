<?php
session_start();

if(!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = htmlspecialchars($_POST["name"]);
    $service = htmlspecialchars($_POST["service"]);
    $date = htmlspecialchars($_POST["date"]);
    $time = htmlspecialchars($_POST["time"]);

    // sample confirmation message
    $message = "Booking successful for <b>$service</b> on $date at $time.";
}
$services = [
    [
        'name' => 'Facial',
        'subservices' => [
            ['name'=>'Facial 1','price'=>500],
            ['name'=>'Facial 2','price'=>700],
            ['name'=>'Facial 3','price'=>300]
        ]
    ],
    [
        'name' => 'Massage',
        'subservices' => [
            ['name'=>'Massage 1','price'=>500],
            ['name'=>'Massage 2','price'=>700],
            ['name'=>'Massage 3','price'=>300]
        ]
    ],
    [
        'name' => 'Manicure',
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
    <title>Book Appointment - Glow Fab</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>
<body>

<header>
    <div class="navigatorBar">
        <h1>Glow Fab</h1>
        <ul>
            <li onclick="window.location.href='index.php'">Home</li>
            <li onclick="window.location.href='logout.php'">Logout</li>
        </ul>
    </div>
</header>

<section style="
    min-height:80vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background-color: var(--light-pink-color);
">

<form method="POST" style="
    background:white;
    padding:3rem;
    border-radius:1rem;
    width:400px;
">

<h2 style="text-align:center; margin-bottom:1rem;">Book Appointment</h2>

<?php if($message): ?>
<p style="color:green; text-align:center;"><?= $message ?></p>
<?php endif; ?>

<input type="text" name="name" placeholder="Full Name" required
style="width:100%; padding:12px; margin:10px 0;">

<input type="text" name="email" placeholder="Email" required
style="width:100%; padding:12px; margin:10px 0;">

<input type="text" name="phone" placeholder="Phone No." required
style="width:100%; padding:12px; margin:10px 0;">


    <label>Service</label>
    <select name="service" id="service" required style="width:100%; padding:12px; margin:10px 0;">
        <option value="">Service</option>
        <?php foreach($services as $index => $s): ?>
            <option value="<?= $index ?>">
                <?= $s['name'] ?> 
            </option>
        <?php endforeach; ?>
        
    </select>

    <!-- subservices. it uses javascript to automatically populate the subservice list -->
    <label>Sub-Service</label>
    <select name="subservice" id="subservice" required style="width:100%; padding:12px; margin:10px 0;">
        <option value="">Sub-Service</option>
    </select>

<input type="date" name="date" required
style="width:100%; padding:12px; margin:10px 0;">

<select name="time" id="time">
<option>11am - 12am</option>
<option >12am - 1pm</option>
<option>1pm - 2pm</option>
<option >2pm - 3pm</option>
<option>3pm - 4pm</option>
<option >4pm - 5pm</option>
<option>5pm - 6pm</option>
<option >6pm - 7pm</option>
<option>7pm - 8pm</option>
<option >8pm - 9pm</option>
</select>

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

<button class="primaryButton" style="width:100%; margin-top:15px;">
    Confirm Booking
</button>

</form>

</section>

</body>
</html>
