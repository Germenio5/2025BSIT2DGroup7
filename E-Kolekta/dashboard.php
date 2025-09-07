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

            <div id="username">Hello, username!</div>

            <div class="activity_status">
                <div id="activity_status">Activity Status</div>
                <div class="activity_status_container">
                    <div id="total_items_donated"> 
                        <img src="images/e-waste.png" alt="E-Waste">
                        <p>Total Items Donated</p> 
                        <div id="total_items_donated_value">2 
                            <div>items</div>
                        </div>
                    </div>
                    <div id="total_e-waste_weight">
                        <img src="images/weight.png" alt="Weight">
                        <p>Total E-Waste Weight Donated</p> 
                        <div id="total_e-waste_weight_value">16 
                            <div>kg</div>
                        </div>
                    </div>
                    <div id="total_pickup"> 
                        <img src="images/pickup.png" alt="Pick-up">
                        <p>Total Pickups Completed</p> 
                        <div id="total_pickup_value">2 
                            <div>Pickups</div>
                        </div>
                    </div>
                    <div id="total_drop-offs">
                        <img src="images/dropoff.png" alt="Drop-off">
                        <p>Total Drop-offs Completed</p> 
                        <div id="total_drop-offs_value">3 
                            <div>Drop-offs</div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <td data-label="Date:">2025-07-20</td>
                            <td data-label="Time:">11:00 AM - 12:00 PM</td>
                            <td data-label="E-Waste Type:">Old Laptop</td>
                            <td data-label="Condition:">Not Working</td>
                            <td data-label="Collection Type:">Pickup</td>
                            <td data-label="Tracking ID:">EK123456789</td>
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
                            <td data-label="Date:">2025-07-20</td>
                            <td data-label="Time:">2:00 PM - 3:00PM</td>
                            <td data-label="E-Waste Type:">Smartphone</td>
                            <td data-label="Condition:">Not Working</td>
                            <td data-label="Collection Type:">Drop-off</td>
                            <td data-label="Tracking ID:">EK987654321</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>