<?php
session_start();
require_once "database.php";

// Check if user is logged in; if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Fetch total accumulated points for the logged-in user
$stmt = $conn->prepare("SELECT SUM(points) AS total_points FROM donations WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userPoints = $row['total_points'] ?? 0; // Default to 0 if no points
$stmt->close();

// Fetch the 5 most recent donations of the user to display in the table
$stmt = $conn->prepare("
    SELECT donation_date, ewaste_type, e_waste_condition, weight, points
    FROM donations
    WHERE username = ?
    ORDER BY donation_date DESC
    LIMIT 5
");
$stmt->bind_param("s", $username);
$stmt->execute();
$donations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Reward list (static) — defines what users can redeem and the required points for each
$rewards = [
    ["amount" => "PHP 20.00", "cost" => 200.00],
    ["amount" => "PHP 50.00", "cost" => 500.00],
    ["amount" => "PHP 100.00", "cost" => 1000.00],
    ["amount" => "PHP 200.00", "cost" => 2000.00],
    ["amount" => "PHP 500.00", "cost" => 5000.00],
    ["amount" => "PHP 1000.00", "cost" => 10000.00],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>
    <link rel="stylesheet" href="assets/css/dashboard.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="content-wrapper">
        <?php include "views/sidebar.php"; ?>

        <div class="main-content">
            <div class="reward_container">
                <div class="redeem-section">
                    <div id="reward_text">REWARD</div>

                    <!-- Displays user's current total points -->
                    <div class="points_display">
                        POINTS: <div id="points"><?= number_format($userPoints, 2) ?></div>
                    </div>

                    <div id="point_text">RECENT OBTAINED POINTS</div>

                    <!-- Shows last 5 donations and their earned points -->
                    <div class="points-table-container">
                        <table class="points-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type of E-Waste</th>
                                    <th>Condition</th>
                                    <th>Weight (kg)</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($donations)): ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:gray; font-style:italic; padding:15px;">
                                            No donations recorded yet.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($donations as $donation): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($donation['donation_date']); ?></td>
                                            <td><?= htmlspecialchars($donation['ewaste_type']); ?></td>
                                            <td><?= htmlspecialchars($donation['e_waste_condition']); ?></td>
                                            <td><?= htmlspecialchars($donation['weight']); ?></td>
                                            <td><?= htmlspecialchars($donation['points']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Reward redemption section -->
            <div class="redeem_reward_container">
                <h3>REDEEM POINTS</h3>
                <div class="redeem-cards">
                    <?php foreach ($rewards as $reward): ?>
                        <div class="redeem-card">
                            <h4><?= $reward['amount'] ?></h4>
                            <p><?= number_format($reward['cost'], 2) ?> POINTS</p>
                            <!-- Disable the redeem button if user doesn't have enough points -->
                            <button class="redeem-btn" 
                                <?= ($userPoints < $reward['cost']) ? 'disabled style="background:#ccc;cursor:not-allowed;"' : '' ?>>
                                <?= ($userPoints < $reward['cost']) ? 'Not Enough Points' : 'REDEEM' ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>    
        </div>
    </div>
</body>
</html>
