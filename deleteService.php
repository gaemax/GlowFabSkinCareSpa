deleteService.php
 <?php
    require "db.php";

    $service_id = $_GET["service_id"];
    $subservice_id = $_GET["subservice_id"];

    if (isset($service_id)) {
        $query = "DELETE FROM services WHERE service_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "i", $service_id
        );
        $stmt->execute();
        echo "service";
        header("Location: admin.php?page=servicemanager");
        exit();
    } else if (isset($subservice_id)) {
        $query = "DELETE FROM subservices WHERE subservice_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "i", $subservice_id
        );
        $stmt->execute();
        echo "subservice";
        header("Location: admin.php?page=servicemanager");
        exit();
    }

?> 