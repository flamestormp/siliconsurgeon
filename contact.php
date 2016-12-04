<!DOCTYPE html>
<html lang="en">
    <?php include 'top.php'?>
        <div id="wrap">
        <div id="main">
<?php
/*print "<pre>";
print_r($_POST);
print "</pre>";*/
$thisURL = $domain . $phpSelf;

/** Form Variables **/
$first = "";
$name = "";
$title = "";
$email = "";
$phone = "";
$emailPref = false;
$txtPhonePref = false;
$txtsubject = "";
$txtMessage = "";

/** Error Variables **/
$nameERROR = false;
$titleERROR = false;
$emailERROR = false;
$phoneERROR = false;
$prefERROR = false;
$totalChecked = 0;
$txtsubjectERROR = false;
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
    if ($_POST["first"] == "first") {
        $first = true;
        $dataRecord[] = htmlentities($_POST["emailPref"], ENT_QUOTES, "UTF-8");
    } else {
        $dataRecord[] = "";
    }

    $name = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $name;
    $title = htmlentities($_POST["radTitle"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $title;
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    $phone = htmlentities($_POST["txtPhone"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $phone;

    if ($_POST["emailPref"] == "emailPref") {
        $emailPref = true;
        $dataRecord[] = htmlentities($_POST["emailPref"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $dataRecord[] = "";
    }

    if  ($_POST["txtPhonePref"] == "txtPhonePref") {
        $txtPhonePref = true;
        $dataRecord[] = htmlentities($_POST["txtPhonePref"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $dataRecord[] = "";
    }

    $txtsubject = htmlentities($_POST["txtsubject"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $txtsubject;
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
    if ($title != "Mr." AND $title != "Mrs." AND $title != "Not Applicable") {
        $errorMsg[] = "Please choose a title.";
        $titleERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address.";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address seems to be incorrect";
        $emailERROR = true;
    }
    if ($phone == "") {
        $errorMsg[] = "Please enter a phone number.";
        $phoneERROR = true;
    } elseif (verifyPhone($phone) == 0) {
        $errorMsg[] = "Your phone number seems to be incorrect";
        $phoneERROR = true;
    }
    if (!($totalChecked > 0)) {
        $errorMsg[] = "Please select at least one preferred contact method.";
        $prefERROR = true;
    }
    if ($txtsubject == "") {
    	$errorMsg[] = "Please select a subject!";
    	$txtsubjectERROR = true;
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

if (isset($_POST["Send"]) AND empty($errorMsg)) {
    print"<h2>Thank you!</h2>";
    print "<p>A copy of your ticket has ";
    if (!$mailed) {
        print "not ";
    }
    print "been sent to: ".$email. "</p>";
} else {
    print "<h2>Contact Us Online!</h2>";

    /** 3b: error messages **/

    if ($errorMsg) {
        print '<div id="errors">' . "\n";
        print "<h2>Your Form has the following mistakes that need to be fixed.</h2>\n";
        print "<ol>\n";

        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }
        print "</ol>\n";
        print "</div>\n";
    }
?>
        <!-- DISPLAY ERRORS HERE OR SUCESS MESSAGE IF NOT FIRST VISIT -->
        <form action="<?php print $phpSelf; ?>" id="contactUs" method="post">
            <fieldset class="contactform">

                <input type="hidden" value="notfirst" name="first"/>
                <input <?php if ($first=="first") print ' checked="checked" '; ?>
                    id="first"
                    name="first"
                    tabindex="50"
                    type="checkbox"
                    value="first"/> Is this your first time with the surgeon?<br>

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
                <p>Preferred Title:</p>
                <input type="hidden" value="novalue" name="radTitle"/>
                <input <?php if ($title == "Mr.") print ' checked="checked" ';?>
                    id="radTitleMr"
                    name="radTitle"
                    tabindex="220"
                    type="radio"
                    value="Mr."/>Mr.
                <input <?php if ($title == "Mrs.") print ' checked="checked" ';?>
                    id="radTitleMrs"
                    name="radTitle"
                    tabindex="230"
                    type="radio"
                    value="Mrs."/>Mrs.
                <input <?php if ($title == "Not Applicable") print ' checked="checked" ';?>
                    id="radTitleNone"
                    name="radTitle"
                    tabindex="240"
                    type="radio"
                    value="Not Applicable"/>Not Applicable<br>

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

                <label for="txtPhone">Phone:</label><br>
                <input <?php if($phoneERROR) print 'class="mistake"' ?>
                    type="text"
                    maxlength="20"
                    id="txtPhone"
                    tabindex="210"
                    name="txtPhone"
                    onfocus="this.select()"
                    placeholder="Enter your phone number"
                    value="<?php print $phone; ?>"
                    ><br>

                <p>Preferred Contact Method:</p>
                <p>(select both if flexible)</p>
                <input type="hidden" value="novalue" name="emailPref"/>
                <input <?php if ($emailPref=="emailPref") print ' checked="checked" '; ?>
                    id="emailPref"
                    name="emailPref"
                    tabindex="250"
                    type="checkbox"
                    value="emailPref"/> Email
                <input type="hidden" value="novalue" name="txtPhonePref"/>
                <input <?php if ($txtPhonePref=="txtPhonePref") print 'checked="checked" '; ?>
                    id="txtPhonePref"
                    name="txtPhonePref"
                    tabindex="260"
                    type="checkbox"
                    value="txtPhonePref"/> Phone<br>

                <label for="txtsubject">Subject:</label><br>
                <select id="txtsubject"
		                name="txtsubject"
		                tabindex="300">
		        <option <?php if($txtsubject=="mobile") print " selected "; ?>
		            value="mobile">Mobile Device</option>
		        <option <?php if($txtsubject=="computer") print " selected "; ?>
		            value="computer">Computer Repair</option>
		        <option <?php if($txtsubject=="network") print " selected "; ?>
		            value="network">Network Setup</option>
		        <option <?php if($txtsubject=="query") print " selected "; ?>
		            value="query">General Query</option>
		        <option <?php if($txtsubject=="other") print " selected "; ?>
		            value="other">Other</option>
		        </select><br>

                <label>Message: </label><br>
                <textarea name="message" id="message" cols="50" rows="20"><?php print $txtMessage; ?></textarea><br>
                <input
                    type="submit"
                    tabindex="1000"
                    class="button"
                    name="Send"
                    id="Send"
                    value="Send">
            </fieldset>
        </form>
<?php
}
?>
        </div>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>

