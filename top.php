<header>
    <h1 id="title">Silicon Surgeon</h1>
</header>
<?php $path_parts = pathinfo($phpSelf);
$debug = false;
?>
<?php if ($debug) {
    print('<pre>');
    print_r($path_parts);
    print('</pre>');
} ?>
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
    <a href="contact.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'contact') {
        print 'id="activepage"';
    }
    ?>
       >Contact</a>
    <a href="info.php" class="nav"
    <?php
    if ($path_parts['filename'] == 'info') {
        print 'id="activepage"';
    }
    ?>
       >Info</a>
    <a href="about.php" class="nav"
       <?php
       if ($path_parts['filename'] == 'about') {
           print 'id="activepage"';
       }
       ?>
       >About Us</a>
    <p> Call Us! 1-802-555-5555 </p>
</nav>