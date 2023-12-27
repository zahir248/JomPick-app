<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "updated_jompick";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$userID = isset($_GET['user_id']) ? $_GET['user_id'] : null;


if($userID !== null) {
    // Fetch overdue item
    $sql = "SELECT item_management.user_id, item_management.item_id, item_management.dueDate_id, item_management.registerDate,
    item.itemType_id, item.name, item.image, item.location, item.trackingNumber, item_type.name AS itemTypeName,
    due_date.dueDate, due_date.status, due_date.payment_id, due_date_status.type,
    payment.paymentAmount, payment.paymentStatus_id, payment_status.status AS paymentStatus, item_management.confirmation_id, confirmation.confirmationDate
    FROM item_management
    INNER JOIN item ON item_management.item_id = item.item_id
    INNER JOIN item_type ON item.itemType_id = item_type.itemType_id
    INNER JOIN due_date ON item_management.dueDate_id = due_date.dueDate_id
    INNER JOIN due_date_status ON due_date.status = due_date_status.status_id
    INNER JOIN payment ON due_date.payment_id = payment.payment_id
    INNER JOIN payment_status ON payment.paymentStatus_id = payment_status.paymentStatus_id
    INNER JOIN confirmation ON item_management.confirmation_id = confirmation.confirmation_id
    WHERE item_management.user_id = $userID AND payment_status.status IN ('Paid', 'Unpaid', 'Pass', 'Ongoing')";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Convert the result set to an associative array
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $row['image'] = base64_encode($row['image']);
                //unset($row['image']);
                $rows[] = $row;
            }

            // Return the data as JSON
            echo json_encode($rows);
        } else {
            echo "0 results";
        }

        // Close the result set
        $result->close();
    } else {
        // Handle query execution error
        die("Error executing the query: " . $conn->error);
    }
}

    $conn->close();

?>