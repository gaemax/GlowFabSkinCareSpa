deleteService.php
 <?php
    require "db.php";

    $service_id = $_GET["service_id"];
    $subservice_id = $_GET["subservice_id"];

    if (isset($service_id)) {
        $conn->begin_transaction();
        try {

            $stmt1 = $conn->prepare("
                UPDATE services
                SET deleted_at = NOW()
                WHERE service_id = ?
            ");
            $stmt1->bind_param("i", $service_id);
            $stmt1->execute();

            $stmt2 = $conn->prepare("
                UPDATE subservices
                SET deleted_at = NOW()
                WHERE service_id = ?
                AND deleted_at IS NULL
            ");
            $stmt2->bind_param("i", $service_id);
            $stmt2->execute();

            $conn->commit();
            echo "deleted service";
        } catch (Exception $e) {
            $conn->rollback();
            echo $e;
        }

        header("Location: admin.php?page=servicemanager");
        exit();
    } else if (isset($subservice_id)) {
        $query = "
            UPDATE subservices
            SET deleted_at = NOW()
            WHERE subservice_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "i", $subservice_id
        );
        $stmt->execute();

        echo "deleted subservice";
        header("Location: admin.php?page=servicemanager");
        exit();
    }

?> 