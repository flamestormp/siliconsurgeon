<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Silicon Surgeon - Contact Us</title>
        <meta charset="utf-8">
        <meta name="author" content="Silicon Surgeon Inc.">
        <meta name="description"
            content="We provide the best treatement for your electronics!" >
        <link href="css/theme.css" type="text/css" rel="stylesheet" />
<?php
$domain = "//";
$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
$domain .= $server;
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
$path_parts = pathinfo($phpSelf);
print "<!-- include libraries -->";
require_once('lib/security.php');
if($path_parts['filename'] == "contact") {
    print "<!-- include form libraries -->";
    include "lib/validation-functions.php";
    include "lib/mail-message.php";
}
print "<!-- finished including libraries -->";
?>

    </head>
    <body>

<?php
include "top.php";
print "<pre>";
print_r($_POST);
print "</pre>";
$thisURL = $domain . $phpSelf;

/** Form Variables **/
$name = "";
$email = "";
$txtMessage = "";

/** Error Variables **/
$nameERROR = false;
$emailERROR = false;
$txtMessageERROR = false;

$errorMsg = array();
$dataRecord = array();

$mailed = false;
/** Form Processing **/
if (isset($_POST["Send"])) {
    if (!securityCheck($thisURL)) {
        $msg = "<p> Sorry you cannot view this page.";
        $msg .= "This incident will be reported.</p>";
        die($msg);
    }
    /** Sanitation **/
    $name = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $name;
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    $txtMessage = htmlentities($_POST["message"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $txtMessage;

    /** Validation **/
    if ($name == "") {
        $errorMsg[] = "Please enter your name.";
        $nameERROR = true;
    } elseif (!verifyAlphaNum($name)) {
        $errorMsg[] = "Your name cannot have special characters.";
        $nameERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address.";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address seems to be incorrect";
        $emailERROR = true;
    }

    /** Process Form **/
    if (!$errorMsg) {
        $filename = "data/submissions.csv";
        $file = fopen($filename, 'a');
        fputcsv($file, $dataRecord);
        fclose($file);
        //* COME UP WITH A MESSAGE TO DISPLAY AND EMAIL LATER *//
        $message = "testmessage: this needs to be longer than 40 characters
            for some god damn reason. This fact costed phillip lots of time
                debugging and inflicted major psychological damage. ";

        /*******************************************************/
        $to = $email;
        $cc = "";
        $bcc = "";
        $from = "Silicon Surgeon Support
            <noreply@pnguyen4.w3.uvm.edu>"; // for testing

$subject = "Thank you, " . $name . ". We will follow up
with you shortly!";
$mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }
}
?>
        <!-- DISPLAY ERRORS HERE OR SUCESS MESSAGE IF NOT FIRST VISIT -->
        <form action="<?php print $phpSelf; ?>" id="contactUs" method="post">
            <fieldset class="contactform">
                <div id="contactform">
                <label for="txtName">Name: </label><br>
                <input <?php if($nameERROR) print 'class="mistake"'; ?>
                    type="text"
                    id="txtName"
                    maxlength="30"
                    tabindex="100"
                    name="txtName"
                    onfocus="this.select()"
                    placeholder="Enter your name"
                    value="<?php print $name; ?>"
                    ><br>
                <label for="email">Email: </label><br>
                <input <?php if($emailERROR) print 'class="mistake"'; ?>
                    type="email"
                    maxlength="50"
                    id="email"
                    tabindex="200"
                    name="email"
                    onfocus="this.select()"
                    placeholder="Enter your email address"
                    value="<?php print $email; ?>"
                    ><br>
                <!--
                <label for="txtSubject">Subject: </label><br>
                <input
                    type="text"
                    tabindex="300"
                    maxlength="500"
                    id="txtSubject"
                    name="txtSubject"
                    onfocus="this.select()"
                    placeholder="Anything else you would like to tell us?"
                    ><br>
                ***** This would better be off as a listbox -->
                <label>Message: </label><br>
                <textarea name="message" id="message" cols="50" rows="20">
                <?php print $txtMessage; ?></textarea><br>
                <input
                    type="submit"
                    tabindex="1000"
                    class="button"
                    name="Send"
                    id="Send"
                    value="Send">
                </div>
                <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2847.4351803440086!2d-73.11537868455066!3d44.46525180755847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cca79b35d290fdd%3A0x1c3cf1c6a6fc0c13!2s1015+Industrial+Ave%2C+Williston%2C+VT+05495!5e0!3m2!1sen!2sus!4v1478630386301" width="500" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
            </fieldset>
        </form>
        <?php include "footer.php" ?>
    </body>
</html>

