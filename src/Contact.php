<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
    <link rel="stylesheet" href="../assets/css/Decorate.css">
    <link rel="stylesheet" href="../assets/css/Contact.css">
    <title>Fashion EC site</title>
</head>

<body>


    <?php include('./Navbar/Navabar.php'); ?>
    <section class="contactMe">
        <div class="contact-container">


            <!-- Contact Me Starts -->
            <div class="form-container">
                <h3>Contact Us</h3>
                <form action="" class="contact-form" method="post">

                    <div class="form-group">
                        <label class="label">Name</label>
                        <input type="text" class="inputs" placeholder="Your Name" required>
                    </div>

                    <div class="form-group">
                        <label class="label">Email</label>
                        <input type="email" class="inputs" placeholder="Enter Your email" required>
                    </div>

                    <div class="form-group">
                        <label class="label">Message</label>
                        <textarea name="" class="inputs" cols="30" rows="10" placeholder="Write Your Message"></textarea><br>
                    </div>

                    <button type="submit" value="Send" class="send-button">Submit</button>
                </form>
            </div>
            <!-- Contact Me Ends -->

            <!-- Map Starts -->
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m19!1m8!1m3!1d6559.900685407843!2d135.5032228!3d34.7064324!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x6000e69449e0775d%3A0x9dffc5eb4ec5cedf!2zRUND44Kz44Oz44OU44Ol44O844K_5bCC6ZaA5a2m5qChIOOAkjUzMC0wMDE1IOWkp-mYquW6nOWkp-mYquW4guWMl-WMuuS4reW0juilv--8kuS4geebru-8k-KIku-8k--8lQ!3m2!1d34.7064324!2d135.5032228!5e0!3m2!1szh-TW!2sjp!4v1670312147577!5m2!1szh-TW!2sjp" width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
            <!-- Map Ends -->



        </div>

    </section>



    <?php include('./Navbar/Footer.php'); ?>


    <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>