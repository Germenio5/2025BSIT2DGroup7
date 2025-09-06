<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/dashboard.css"/>
    <link rel="stylesheet" href="assets/style.css"/>
</head>
<body>
    <?php require "views/header_dashboard.php"; ?>
    <div class="content-wrapper">
        <?php include "views/sidebar.php"; ?>

        <div class="main-content">
            <div id="username"> Hello, username!</div>

            <div class="activity_status">
                <div id="activity_status">Activity Status</div>
                <div class="activity_status_container">
                <div id="total_items_donated"> 
                    <p> Total Items Donated </p> 
                    <div id="total_items_donated_value"> 0 
                        <div> items </div>
                    </div>
                </div>
                <div id="total_e-waste_weight"> 
                    <p> Total E-Waste Weight </p> 
                    <div id="total_e-waste_weight_value"> 0 
                        <div> kg </div>
                    </div>
                </div>
                <div id="total_pickup"> 
                    <p> Total Pickups Completed </p> 
                    <div id="total_pickup_value"> 0 
                        <div> times </div>
                    </div>
                </div>
                <div id="total_drop-offs"> 
                    <p> Total Drop-offs Completed </p> 
                    <div id="total_drop-offs_value"> 0 
                        <div> times </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>