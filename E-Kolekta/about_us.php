<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <link rel="stylesheet" href="assets/style.css"/>
</head>
<body>
    <div class="bg-wrapper"></div>
    
    <?php include "views/header.php"; ?>

    <div class="about_us">
        <h2>Who We Are</h2>
        <p>E-Kolekta is a smart recycling platform created to make e-waste disposal accessible, rewarding, and environmentally responsible. We’re a community-driven initiative based in Bacolod City, Philippines, designed to support individuals in handling electronic waste safely and efficiently.</p>

        <h2>Our Mission</h2>
        <p>Our goal is to encourage responsible e-waste disposal through accessible digital tools, empowering communities to recycle electronics safely and sustainably.</p>

        <h2>Our Vision</h2>
        <p>To help individuals and communities manage electronic waste responsibly by offering convenient services and building a cleaner, tech-aware environment.</p>

        <h2>What is E-Waste?</h2>
        <p>E-waste, or electronic waste, refers to discarded electronic devices or components that are no longer useful, working, or wanted. This includes mobile phones, televisions, laptops, cables, batteries, chargers, and more.
        Improper disposal leads to pollution of soil and water, affects the health of nearby communities, and wastes valuable materials that can still be recycled or reused. E-waste is one of the fastest-growing waste streams globally, making responsible recycling more urgent than ever.</p>

        <!-- FAQ Section -->
        <div class="faq">
            <h3>Frequently Asked Questions</h3>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What items are accepted as e-waste?</span>
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    We accept mobile phones, televisions, laptops, chargers, batteries, and more.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Is there a limit to how much e-waste I can submit?</span>
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    There is no strict limit, but we encourage proper sorting before submission.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What happens to my e-waste after collection?</span>
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    Your e-waste will be processed safely, with recyclable parts reused and hazardous materials properly disposed of.
                </div>
            </div>
        </div>
    </div>
    <?php require "views/footer.php"; ?>
</body>
<script src="assets/about_us.js"></script>
</html>