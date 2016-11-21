<!DOCTYPE html>
<html lang="en">
    <?php include 'top.php'?>
    <body>

<?php
print "<pre>";
print_r($_POST);
print "</pre>";
$thisURL = $domain . $phpSelf;

/** Form Variables **/
$name = "";
$email = "";
$txtsubject = "";
$txtMessage = "";

/** Error Variables **/
$nameERROR = false;
$emailERROR = false;
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
    $name = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $name;
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
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
    if ($email == "") {
        $errorMsg[] = "Please enter your email address.";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address seems to be incorrect";
        $emailERROR = true;
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
?>
        <!-- DISPLAY ERRORS HERE OR SUCESS MESSAGE IF NOT FIRST VISIT -->
        <h2> Send Us A Message </h2>
        <form action="<?php print $phpSelf; ?>" id="contactUs" method="post">
            <fieldset class="contactform">
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
		        <label for="txtsubject">Subject:</label><br>
		        <select id="txtubject"
		                name="txtsubject"
		                tabindex="200">
		        <option <?php if($txtsubject=="mobile") print " selected "; ?>
		            value="mobile">Mobile Device</option>
		        <option <?php if($txtsubject=="computer") print " selected "; ?>
		            value="computer">Computer Repair</option>
		        <option <?php if($txtsubject=="network") print " selected "; ?>
		            value="network">Network Setup</option>
		        <option <?php if($txtsubject=="other") print " selected "; ?>
		            value="other">Other</option>
		        </select><br>
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
            </fieldset>
        </form>
        <?php include "footer.php" ?>
    </body>
</html>

