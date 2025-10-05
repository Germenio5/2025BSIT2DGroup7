<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['upcoming_schedule'])) {
    $_SESSION['upcoming_schedule'] = []; 
}

if (!isset($_SESSION['previous_donations'])) {
    $_SESSION['previous_donations'] = [
        [
            "date" => "2025-09-11",          
            "time" => "11:00 AM - 12:00 PM",
            "type" => "Old Laptop",          
            "condition" => "Not Working",    
            "collection" => "Pickup",        
            "tracking" => "EK123456789"      
        ]
    ]; 
}

$total_items_donated = count($_SESSION['previous_donations']);
$total_e_waste_weight = 25; // placeholder data
$total_pickups = count(array_filter($_SESSION['previous_donations'], fn($d) => $d['collection'] === 'Pickup'));
$total_dropoffs = count(array_filter($_SESSION['previous_donations'], fn($d) => $d['collection'] === 'Drop-off'));
?>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/dashboard.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="content-wrapper">
        <?php include "views/sidebar.php"; ?>
        <div class="main-content">

            <div id="username">Hello, <?= htmlspecialchars($_SESSION['username']); ?>!</div>

            <!-- ACTIVITY STATUS -->
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

            <!-- UPCOMING SCHEDULE SECTION -->
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
                                <th>Tracking ID</th>
                            </tr>
                        </thead>
                        <tbody id="upcoming_schedule_body">
                            <?php if (empty($_SESSION['upcoming_schedule'])): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; color:gray; padding:15px;">
                                        There are no upcoming schedules yet.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($_SESSION['upcoming_schedule'] as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['date']); ?></td>
                                    <td><?= htmlspecialchars($row['time']); ?></td>
                                    <td><?= htmlspecialchars($row['type']); ?></td>
                                    <td><?= htmlspecialchars($row['condition']); ?></td>
                                    <td><?= htmlspecialchars($row['collection']); ?></td>
                                    <td><?= htmlspecialchars($row['tracking']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PREVIOUS DONATION SECTION -->
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
                                <th>Tracking ID</th>
                            </tr>
                        </thead>
                        <tbody id="previous_donation_body">
                            <?php if (empty($_SESSION['previous_donations'])): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; color:gray; padding:15px;">
                                        No previous donations recorded.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($_SESSION['previous_donations'] as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['date']); ?></td>
                                    <td><?= htmlspecialchars($row['time']); ?></td>
                                    <td><?= htmlspecialchars($row['type']); ?></td>
                                    <td><?= htmlspecialchars($row['condition']); ?></td>
                                    <td><?= htmlspecialchars($row['collection']); ?></td>
                                    <td><?= htmlspecialchars($row['tracking']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>