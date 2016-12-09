<head>
    <?php
    //initialize path parts for use with active link styling
    $domain = "//";
    $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
    $domain .= $server;
    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
    $path_parts = pathinfo($phpSelf);
    //include libraries
    print "<!-- include libraries -->";
    require_once('lib/security.php');
    //only include form libraries if on form page
    if ($path_parts['filename'] == "request") {
        print "<!-- include form libraries -->";
        include "lib/validation-functions.php";
        include "lib/mail-message.php";
    }
    print "<!-- finished including libraries --> ";
    ?>
    <title>Silicon Surgeon - <?php print($path_parts['filename']); //show active page in title bar ?></title>
    <meta charset="utf-8">
    <meta name="author" content="Silicon Surgeon Inc.">
    <meta name="description"
          content="We provide the best treatment for your electronics!" >
    <link href="css/theme.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <header>
        <div style="width:500px; margin: 0 auto; ">
            <h1 class="title">SILICON</h1>
            <img id="logo" src="img/logo.png" alt="logo"/>
            <h1 class="title">SURGEON</h1>
        </div>
        <p style="float: right; color: #EEE; overflow: hidden;">1-802-555-5555</p>
    </header>
    <?php
    if ($debug) {//print the path if debug is on
        print('<pre>');
        print_r($path_parts);
        print('</pre>');
    }
    ?>
    <nav>
        <a href="index.php" class="nav"
        <?php
        //give the active nav link the id "activepage" for styling
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
