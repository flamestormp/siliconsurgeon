<!DOCTYPE html>
<html lang="en">
    <?php include "top.php"?>
        <div id="wrap">
        <div id="main">
        <article id="testimonials">
        <?php
            $myFile = fopen("data/testimonials.csv", "r") or die("Unable to open file!");
            while(!feof($myFile)) {
                $list[] = fgetcsv($myFile);
            }
            fclose($myFile);
            foreach($list as $entry) {
                if($entry[1] == "") {
                    continue; // for the off chance we get a blank entry
                }
                print "<p>".$entry[1];
                print "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;— ".
                    $entry[0]."</p>";
                print "<hr/>";
            }
        ?>
        <article>
        </div>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>
