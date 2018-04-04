<!DOCTYPE html>
<html lang="en">
    <?php include "top.php" ?>
    <div id="wrap">
        <div id="main">
            <article id="testimonials">
                <h2 style="margin-left:0;">Reviews and Testimonials</h2>
                <a href="#sendReview">Submit your own review</a>
                <br/>
                <br/>
                <hr/>
                <?php
                //open csv with list of testimonials
                $myFile = fopen("data/testimonials.csv", "r") or die("Unable to open file!");
                //store testimonials in a list
                while (!feof($myFile)) {
                    $list[] = fgetcsv($myFile);
                }
                fclose($myFile);
                print "\n";
                //iterate through the list and print each testimonial
                foreach ($list as $entry) {
                    if ($entry[1] == "") {
                        continue; // for the off chance we get a blank entry
                    }
                    print "\t\t\t<p>\"" . $entry[1] . "\"</p>\n";
                    print "\t\t\t<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;— " .
                            $entry[0] . "</p>\n";
                    print "\t\t\t<hr/>\n";
                }

                //initialize form variables (for submitting testimonial)
                $thisURL = $domain . $phpSelf;
                $txtReview = "";
                $txtReviewERROR = false;
                $txtName = "";
                $txtNameERROR = false;
                $errorMsg = array();
                $dataRecord = array();

                //for when form is submitted
                if (isset($_POST["submit"])) {
                    //security check
                    if (!securityCheck($thisURL)) {
                        $msg = "<p> Sorry you cannot view this page.";
                        $msg .= "This incident will be reported.</p>";
                        die($msg);
                    }
                    //save form entries to $dataRecord list
                    $txtReview = htmlentities($_POST["txtReview"], ENT_QUOTES, "UTF-8");
                    $dataRecord[] = $txtReview;

                    $txtName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                    $dataRecord[] = $txtName;

                    //save $dataRecord to csv
                    if (!$errorMsg) {
                        $filename = "data/testimonialSubmits.csv";
                        $file = fopen($filename, 'a');
                        fputcsv($file, $dataRecord);
                        fclose($file);
                    }
                    //hide form and thank user for submission
                    if (isset($_POST["submit"]) AND empty($errorMsg)) {
                        print "<h2 id='sendReview'>Thank you for your submission!</h2>";
                    }
                } else {
                    //show form
                    print "<h2>Send us a review!</h2>";
                    ?>
                    <form action="<?php print $phpSelf;//form directs to same spot on the page?>#sendReview" id="sendReview" method="post">
                        <fieldset>
                            <textarea name="txtReview" id="message" cols="50" rows="20"></textarea><br>
                            <label for="txtName">
                                Name (optional):
                            </label>
                            <input
                                type="text"
                                class="text"
                                name="txtName"
                                id="txtName"
                                >
                            <input
                                type="submit"
                                class="button"
                                name="submit"
                                id="submit"
                                value="submit">
                        </fieldset>
                    </form>
                    <?php
                }
                ?>
            </article>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>
</html>
