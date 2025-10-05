<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $option = $_POST['option'] ?? '';
    $ewaste = $_POST['ewaste-type'] ?? '';
    $condition = $_POST['condition'] ?? '';
    $address = $_POST['address'] ?? '';
    $dropoff = $_POST['dropoff'] ?? '';

    if (!empty($date) && !empty($time) && !empty($ewaste) && !empty($condition)) {
        $collectionType = ($option === "PICK-UP") ? "Pickup" : "Drop-off";
        $trackingID = "EK" . rand(100000000, 999999999);

        $newSchedule = [
            "date" => $date,
            "time" => $time,
            "type" => $ewaste,
            "condition" => $condition,
            "collection" => $collectionType,
            "tracking" => $trackingID
        ];

        $scheduleDateTime = strtotime("$date " . explode("-", $time)[0]);
        $now = time();

        if ($scheduleDateTime > $now) {
            $_SESSION['upcoming_schedule'][] = $newSchedule;
        } else {
            $_SESSION['previous_donations'][] = $newSchedule;
        }

        header("Location: dashboard.php");
        exit;
    }
}
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Schedule</title>
    <link rel="stylesheet" href="assets/css/dashboard.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="content-wrapper">
    <?php include "views/sidebar.php"; ?>
    <div class="main-content">
        <div class="schedule">
        <div id="schedule_text">SET A SCHEDULE</div>
            <form id="optionForm" method="POST" action="schedule.php">
                <label class="option" for="option">CHOOSE COLLECTION:</label>
                <select id="option" name="option" required>
                    <option value="">--Select--</option>
                    <option value="PICK-UP">PICK-UP</option>
                    <option value="DROP-OFF">DROP-OFF</option>
                </select>
                <div class="dateForm">
                    <label for="date">DATE:</label>
                    <input type="date" id="date" name="date" required>
                    <div class="error-message" id="dateError"></div>
                    <label for="time">TIME:</label>
                    <select id="time" name="time" required>
                        <option value="">--Select Time--</option>
                        <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                        <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                        <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                        <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                        <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                        <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                        <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                        <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                        <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                        <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                        <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
                        <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                    </select>
                </div>
                <div class="form-group" id="pickupAddress">
                    <label for="address">ADDRESS:</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address">
                </div>
                <div class="dropoffForm" id="dropoffLocations" style="display: none;">
                    <label for="dropoff">DROP-OFF LOCATION:</label>
                    <select id="dropoff" name="dropoff">
                        <option value="">--Select Drop-off Location--</option>
                        <option value="Central Hub">Central Hub</option>
                        <option value="City Hall">City Hall</option>
                        <option value="Public Plaza">Public Plaza</option>
                    </select>
                </div>
                <div class="typeForm">
                    <label for="ewaste-type">TYPE OF E-WASTE:</label>
                    <select id="ewaste-type" name="ewaste-type" required>
                        <option value="">--Select Type--</option>
                        <option value="Cellphone">Cellphone</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Television">Television</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Game Console">Game Console</option>
                        <option value="Digital Camera">Digital Camera</option>
                        <option value="DVD Player">DVD Player</option>
                        <option value="Refrigerator">Refrigerator</option>
                        <option value="Keyboard">Keyboard</option>
                        <option value="Mouse">Mouse</option>
                        <option value="Printer">Printer</option>
                        <option value="Hard Disk Drive">Hard Disk Drive</option>
                        <option value="System Unit">System Unit</option>
                        <option value="Speaker">Speaker</option>
                    </select>
                </div>
                <div class="conditionForm">
                    <label for="condition">CONDITION:</label>
                    <select id="condition" name="condition" required>
                        <option value="">--Select Condition--</option>
                        <option value="Working">Working</option>
                        <option value="Partially Working">Partially Working</option>
                        <option value="Not Working">Not Working</option>
                        <option value="Damaged">Damaged</option>
                        <option value="Missing Parts">Missing Parts</option>
                        <option value="Outdated">Outdated</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">ENTER</button>
            </form>
        </div>    
    </div>
</div>
</body>
<script src="assets/js/schedule.js"></script>
</html>
