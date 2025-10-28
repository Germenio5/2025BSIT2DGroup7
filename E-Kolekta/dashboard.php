<?php
session_start();
require_once "database.php";

// Check if user is logged in; if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$today = date("Y-m-d");

// Fetch all schedule records from the database that belong to the logged-in user
// The data includes schedule_date, time, e-waste type, condition, address, etc.
$stmt = $conn->prepare("SELECT * FROM schedule WHERE username = ? ORDER BY schedule_date DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Separate schedule data into upcoming (future or today) and previous (past)
$upcoming = [];
$previous = [];

while ($row = $result->fetch_assoc()) {
    if ($row['schedule_date'] >= $today) {
        $upcoming[] = $row;  // store upcoming schedules here
    } else {
        $previous[] = $row;  // store previous schedules here
    }
}

// These values are calculated from database results (not stored in DB)
// Used to show user activity stats
$total_items_donated = count($previous);
$total_pickups = count(array_filter($previous, fn($d) => $d['collection_type'] === 'Pickup'));
$total_dropoffs = count(array_filter($previous, fn($d) => $d['collection_type'] === 'Drop-off'));
$total_e_waste_weight = $total_items_donated * 5; // assume 5kg per donation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="content-wrapper">
    <?php include "views/sidebar.php"; ?>

    <div class="main-content">
        <!-- Display a notification message if the user just created a new schedule -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div id="notifBox" class="notif-box">
                Schedule successfully set!
            </div>
        <?php endif; ?>

        <div id="username">
            Hello, <?= htmlspecialchars($username); ?>!
        </div>

        <div class="activity_status">
            <div id="activity_status">Activity Status</div>
            <div class="activity_status_container">
                <div id="total_items_donated">
                    <img src="images/e-waste.png" alt="E-Waste">
                    <p>Total Items Donated</p>
                    <div id="total_items_donated_value">
                        <?= $total_items_donated ?>
                        <div>items</div>
                    </div>
                </div>
                <div id="total_e-waste_weight">
                    <img src="images/weight.png" alt="Weight">
                    <p>Total E-Waste Weight Donated</p>
                    <div id="total_e-waste_weight_value">
                        <?= $total_e_waste_weight ?>
                        <div>kg</div>
                    </div>
                </div>
                <div id="total_pickup">
                    <img src="images/pickup.png" alt="Pick-up">
                    <p>Total Pickups Completed</p>
                    <div id="total_pickup_value">
                        <?= $total_pickups ?>
                        <div>Pickups</div>
                    </div>
                </div>
                <div id="total_drop-offs">
                    <img src="images/dropoff.png" alt="Drop-off">
                    <p>Total Drop-offs Completed</p>
                    <div id="total_drop-offs_value">
                        <?= $total_dropoffs ?>
                        <div>Drop-offs</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="upcoming_schedule">
            <div id="upcoming_schedule">Upcoming Schedule</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>E-Waste Type</th>
                            <th>Condition</th>
                            <th>Collection Type</th>
                            <th>Address / Drop-off</th>
                        </tr>
                    </thead>
                    <tbody id="upcoming_schedule_body">
                        <?php if (empty($upcoming)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center; color:gray; padding:15px;">
                                    There are no upcoming schedules yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($upcoming as $row): ?>
                                <?php 
                                    // Show address if Pickup, or drop-off location otherwise
                                    // If both empty, show 'N/A'
                                    $address_display = trim($row['address']) !== '' ? $row['address'] : $row['dropoff_location'];
                                    if (trim($address_display) === '') $address_display = 'N/A';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['schedule_date']); ?></td>
                                    <td><?= htmlspecialchars($row['schedule_time']); ?></td>
                                    <td><?= htmlspecialchars($row['ewaste_type']); ?></td>
                                    <td><?= htmlspecialchars($row['e_waste_condition']); ?></td>
                                    <td><?= htmlspecialchars($row['collection_type']); ?></td>
                                    <td><?= htmlspecialchars($address_display); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="previous_donation">
            <div id="previous_donation">Previous E-Waste Donation</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>E-Waste Type</th>
                            <th>Condition</th>
                            <th>Collection Type</th>
                            <th>Address / Drop-off</th>
                        </tr>
                    </thead>
                    <tbody id="previous_donation_body">
                        <?php if (empty($previous)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center; color:gray; padding:15px;">
                                    No previous donations recorded.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($previous as $row): ?>
                                <?php 
                                    // Same logic for address or drop-off
                                    $address_display = trim($row['address']) !== '' ? $row['address'] : $row['dropoff_location'];
                                    if (trim($address_display) === '') $address_display = 'N/A';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['schedule_date']); ?></td>
                                    <td><?= htmlspecialchars($row['schedule_time']); ?></td>
                                    <td><?= htmlspecialchars($row['ewaste_type']); ?></td>
                                    <td><?= htmlspecialchars($row['e_waste_condition']); ?></td>
                                    <td><?= htmlspecialchars($row['collection_type']); ?></td>
                                    <td><?= htmlspecialchars($address_display); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
// hides the success message automatically after 8 seconds
document.addEventListener("DOMContentLoaded", () => {
    const notif = document.getElementById("notifBox");
    if (notif) {
        setTimeout(() => notif.style.display = "none", 8000);
    }
});
</script>

</body>
</html>
