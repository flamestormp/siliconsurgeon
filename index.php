<!DOCTYPE html>
<html lang="en">
    <?php include 'top.php' ?>
        <div id="wrap">
        <div id="main">
        <?php
            $myFile = fopen("data/testimonials.csv", "r") or die("Unable to open file!");
            while(!feof($myFile)) {
                $list[] = fgetcsv($myFile);
            }
            fclose($myFile);
            $index = count($list)-2;
            $rand = mt_rand(0, $index);
            print "<p style='text-align: center;padding-top:1%;'><i>\"".$list[$rand][1]."\"</i></p>";
        ?>
        <section id="content">
            <div class="css-slideshow">
               <figure>
                    <a href="services.php#mobile">
                        <img class="slideshow" src="img/placeholder1.jpg">
                    </a>
                </figure>
                <figure>
                    <a href="services.php#repair">
                        <img class="slideshow" src="img/placeholder2.png">
                        </a>
                </figure>
                <figure>
                    <a href="services.php#networking">
                        <img class="slideshow" src="img/placeholder3.jpg">
                    </a>
                </figure>
            </div>
            <article id="overview">
                <h1 id="flair"> Personal  *  Home  *  Business </h1>
                <p class="home">We are here for all kinds of customers! Whether
                    you are a single person, small business, or even a large
                    enterprise, we will have your back! Silicon Surgeon is
                    operationally a straightforward service: bring us the
                    problem and consider it resolved. We promise to avoid the
                    jargon altogether and speak in terms the average person
                    would understand. Our diagosis will be right to the point
                    and the treatment will cure all your technological ails!
                    Overprescribing not our style, so you can be sure that you
                    not are paying for more than what you need.
                </p>
                <p class="home">
                    Serving the Champlain Valley for over a decade, we are proud
                    to serve the local community with vigor and passion. Our
                    success comes from our dedication to provide each customer
                    with a top tier value at a reasonable rate. We strive to
                    deliver a reliable service by communicating clearly with
                    each client to ensure that all needs are met with
                    satisfaction. The crew is ready and willing to work with you
                    personally to get the job done. We want to work with you!
                    Call, contact us online, or stop by for a free quote!
                </p>
            </article>
        </section>
        </div>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>

