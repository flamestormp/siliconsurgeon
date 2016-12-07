<!DOCTYPE html>
<html lang="en">
    <?php include "top.php" ?>
    <div id="wrap">
        <div id="main">
            <article id="testimonials">
                <h1>Reviews and Testimonials</h1>
                <a href="#sendReview">Submit your own review</a>
                <br/>
                <br/>
                <hr/>
                <?php
                $myFile = fopen("data/testimonials.csv", "r") or die("Unable to open file!");
                while (!feof($myFile)) {
                    $list[] = fgetcsv($myFile);
                }
                fclose($myFile);
                print "\n";
                foreach ($list as $entry) {
                    if ($entry[1] == "") {
                        continue; // for the off chance we get a blank entry
                    }
                    print "\t\t\t<p>\"" . $entry[1] . "\"</p>\n";
                    print "\t\t\t<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;— " .
                            $entry[0] . "</p>\n";
                    print "\t\t\t<hr/>\n";
                }

                $thisURL = $domain . $phpSelf;
                $txtReview = "";
                $txtReviewERROR = false;
                $txtName = "";
                $txtNameERROR = false;
                $errorMsg = array();
                $dataRecord = array();

                if (isset($_POST["submit"])) {
                    if (!securityCheck($thisURL)) {
                        $msg = "<p> Sorry you cannot view this page.";
                        $msg .= "This incident will be reported.</p>";
                        die($msg);
                    }

                    $txtReview = htmlentities($_POST["txtReview"], ENT_QUOTES, "UTF-8");
                    $dataRecord[] = $txtReview;

                    $txtName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                    $dataRecord[] = $txtName;

                    if (!$errorMsg) {
                        $filename = "data/testimonialSubmits.csv";
                        $file = fopen($filename, 'a');
                        fputcsv($file, $dataRecord);
                        fclose($file);
                    }
                    if (isset($_POST["submit"]) AND empty($errorMsg)) {
                        print "<h2 id='sendReview'>Thank you for your submission!</h2>";
                    }
                } else {
                    print "<h2>Send us a review!</h2>";
                    ?>
                    <form action="<?php print $phpSelf; ?>#sendReview" id="sendReview" method="post">
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
