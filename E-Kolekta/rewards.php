<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <div class="points_display">POINTS: 
                        <div id="points">200.00</div>
                    </div>
                    <div id="point_text">RECENT OBTAINED POINTS</div>
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
                            <tr>
                                <td data-label="Date:">2025-09-01</td>
                                <td data-label="Type of E-Waste:">Laptop</td>
                                <td data-label="Condition:">Not Working</td>
                                <td data-label="Weight (kg):">1.5kg</td>
                                <td data-label="Points:">100.00</td>
                            </tr>
                            <tr>
                                <td data-label="Date:">2025-08-28</td>
                                <td data-label="Type of E-Waste:">Monitor</td>
                                <td data-label="Condition:">Partially Working</td>
                                <td data-label="Weight (kg):">1.1kg</td>
                                <td data-label="Points:">50.00</td>
                            </tr>
                            <tr>
                                <td data-label="Date:">2025-08-20</td>
                                <td data-label="Type of E-Waste:">Smartphone</td>
                                <td data-label="Condition:">Missing Parts</td>
                                <td data-label="Weight (kg):">0.5kg</td>
                                <td data-label="Points:">50.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="redeem_reward_container">
                <h3>REDEEM POINTS</h3>
                <div class="redeem-cards">
                    <div class="redeem-card">
                        <h4>Php 20.00</h4>
                        <p>200.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                    <div class="redeem-card">
                        <h4>Php 50.00</h4>
                        <p>500.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                    <div class="redeem-card">
                        <h4>Php 100.00</h4>
                        <p>1000.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                    <div class="redeem-card">
                        <h4>Php 200.00</h4>
                        <p>2000.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                    <div class="redeem-card">
                        <h4>Php 500.00</h4>
                        <p>5000.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                    <div class="redeem-card">
                        <h4>Php 1000.00</h4>
                        <p>10000.00 POINTS</p>
                        <button class="redeem-btn">REDEEM</button>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</body>
</html>