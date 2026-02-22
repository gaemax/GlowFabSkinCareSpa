<?php
    $chosenYear = $_GET["chosenYear"];
    header("Location: admin.php?page=calendar&year=" . $chosenYear);
    exit();
?>