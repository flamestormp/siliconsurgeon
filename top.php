<head>
    <?php
    $domain = "//";
    $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
    $domain .= $server;
    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
    $path_parts = pathinfo($phpSelf);
    print "<!-- include libraries -->";
    require_once('lib/security.php');
    if ($path_parts['filename'] == "request") {
        print "<!-- include form libraries -->";
        include "lib/validation-functions.php";
        include "lib/mail-message.php";
    }
    print "<!-- finished including libraries --> ";
    ?>
    <title>Silicon Surgeon - <?php print($path_parts['filename']);?></title>
    <meta charset="utf-8">
    <meta name="author" content="Silicon Surgeon Inc.">
    <meta name="description"
          content="We provide the best treatement for your electronics!" >
    <link href="css/theme.css" type="text/css" rel="stylesheet" />
</head>
<body>
<header>
    <div style="width:500px; margin: 0 auto; ">
    <h1 id="title">Silicon </h1>
    <img id="logo" src="img/logo.png" alt="logo"/>
    <h1 id="title">Surgeon</h1>
    </div>
    <p style="float: right; color: #EEE;">1-802-555-5555</p>
</header>
<?php
if ($debug) {
    print('<pre>');
    print_r($path_parts);
    print('</pre>');
}
?>
<nav>
    <a href="index.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'index') {
        print 'id="activepage"';
    }
    ?>
       >Home</a>
    <a href="services.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'services') {
        print 'id="activepage"';
    }
    ?>
       >Services</a>
    <a href="request.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'request') {
        print 'id="activepage"';
    }
    ?>
       >Request</a>
    <a href="contact.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'contact') {
        print 'id="activepage"';
    }
    ?>
       >Contact</a>
    <a href="about.php" class="nav"
       <?php
       if ($path_parts['filename'] == 'about') {
           print 'id="activepage"';
       }
       ?>
       >About</a>
    <a href="testimonials.php" class="nav"
        <?php
        if ($path_parts['filename'] == 'testimonials') {
            print 'id="activepage"';
        }
        ?>
    >Testimonials</a>
</nav>
