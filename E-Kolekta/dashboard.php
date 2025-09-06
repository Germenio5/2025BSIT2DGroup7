<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/dashboard.css"/>
    <link rel="stylesheet" href="assets/style.css"/>
</head>
<body>
    <div class="content-wrapper">
        <?php include "views/sidebar.php"; ?>
        <div class="main-content">

            <div id="username">Hello, username!</div>

            <!-- Activity Status -->
            <div class="activity_status">
                <div id="activity_status">Activity Status</div>
                <div class="activity_status_container">
                    <div id="total_items_donated"> 
                        <p>Total Items Donated</p> 
                        <div id="total_items_donated_value">2 
                            <div>items</div>
                        </div>
                    </div>
                    <div id="total_e-waste_weight"> 
                        <p>Total E-Waste Weight</p> 
                        <div id="total_e-waste_weight_value">16 
                            <div>kg</div>
                        </div>
                    </div>
                    <div id="total_pickup"> 
                        <p>Total Pickups Completed</p> 
                        <div id="total_pickup_value">2 
                            <div>Pickups</div>
                        </div>
                    </div>
                    <div id="total_drop-offs"> 
                        <p>Total Drop-offs Completed</p> 
                        <div id="total_drop-offs_value">3 
                            <div>Drop-offs</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Schedule -->
            <div class="upcoming_schedule">
                <div id="upcoming_schedule">Upcoming Schedule</div>
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
                        <tr>
                            <td data-label="Date">2025-07-20</td>
                            <td data-label="Time">11:00 AM</td>
                            <td data-label="E-Waste Type">Old Laptop</td>
                            <td data-label="Condition">Not Working</td>
                            <td data-label="Collection Type">Pickup</td>
                            <td data-label="Tracking ID">EK123456789</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="previous_donation">
                <div id="previous_donation">Previous E-Waste Donation</div>
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
                        <tr>
                            <td data-label="Date">2025-07-20</td>
                            <td data-label="Time">11:00 AM</td>
                            <td data-label="E-Waste Type">Old Laptop</td>
                            <td data-label="Condition">Not Working</td>
                            <td data-label="Collection Type">Pickup</td>
                            <td data-label="Tracking ID">EK123456789</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>