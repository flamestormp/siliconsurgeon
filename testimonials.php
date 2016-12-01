<!DOCTYPE html>
<html lang="en">
    <?php include "top.php"?>
        <div id="wrap">
        <div id="main">
        <article id="testimonials">
        <h1>Reviews and Testimonials</h1>
        <br/>
        <hr/>
        <?php
            $myFile = fopen("data/testimonials.csv", "r") or die("Unable to open file!");
            while(!feof($myFile)) {
                $list[] = fgetcsv($myFile);
            }
            fclose($myFile);
            print "\n";
            foreach($list as $entry) {
                if($entry[1] == "") {
                    continue; // for the off chance we get a blank entry
                }
                print "\t\t\t<p>\"".$entry[1]."\"</p>\n";
                print "\t\t\t<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;— ".
                    $entry[0]."</p>\n";
                print "\t\t\t<hr/>\n";
            }
        ?>
        </article>
        </div>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>
