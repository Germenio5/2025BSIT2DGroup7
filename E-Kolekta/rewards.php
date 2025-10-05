<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$userPoints = 200.00;

$rewards = [
    ["amount" => "PHP 20.00", "cost" => 200.00],
    ["amount" => "PHP 50.00", "cost" => 500.00],
    ["amount" => "PHP 100.00", "cost" => 1000.00],
    ["amount" => "PHP 200.00", "cost" => 2000.00],
    ["amount" => "PHP 500.00", "cost" => 5000.00],
    ["amount" => "PHP 1000.00", "cost" => 10000.00],
];

if (!isset($_SESSION['previous_donations'])) {
    $_SESSION['previous_donations'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'], $_POST['condition'])) {
    $_SESSION['previous_donations'][] = [
        "date" => date("Y-m-d"),
        "time" => date("h:i A"),
        "type" => $_POST['type'],
        "condition" => $_POST['condition'],
        "collection" => "Pickup",
        "tracking" => "EK" . rand(100000000, 999999999)
    ];
    header("Location: reward.php?added=success");
    exit;
}
?>
<html lang="en">
<head>
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
                    <div class="points_display">
                        POINTS: <div id="points"><?= number_format($userPoints, 2) ?></div>
                    </div>
                    <div id="point_text">RECENT OBTAINED POINTS</div>

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
                                <?php if (empty($_SESSION['previous_donations'])): ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:gray; font-style:italic; padding:15px;">
                                            No previous donations yet.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach (array_slice($_SESSION['previous_donations'], -5) as $donation): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($donation['date']); ?></td>
                                            <td><?= htmlspecialchars($donation['type']); ?></td>
                                            <td><?= htmlspecialchars($donation['condition']); ?></td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="redeem_reward_container">
                <h3>REDEEM POINTS</h3>
                <div class="redeem-cards">
                    <?php foreach ($rewards as $reward): ?>
                        <div class="redeem-card">
                            <h4><?= $reward['amount'] ?></h4>
                            <p><?= number_format($reward['cost'], 2) ?> POINTS</p>
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
