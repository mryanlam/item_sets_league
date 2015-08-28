<?php
    include "static/header.php";
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <?php
                //If there is a file, open it and interpret it's results
                if (isset($_POST['submit'])) {
                    //print("<p> The contents of the file are </p> <br>");
                    $contents= file_get_contents($_FILES['file']['tmp_name']);
                    //print ($contents);
                    $api_key = file_get_contents('api.key'); // API Key is stored as a plaintext file in the webserver.
                    //API calls to /api/lol/static-data/en_US/v1.2/item/<item id> are not counted towards rate limit
                    $data = json_decode($contents, true);
                    $champion = $data['champion'];
                    $map = $data['mode'];
                    $title = $data['title'];
                    print("<p> This is an itemset for ".$champion." on the map ".$map." named ".$title."</p><br>");
                    foreach ($data['blocks'] as $block) {
                        print("<p>".$block['type']."</p><br>");
                        foreach ($block['items'] as $item) {
                            $quantity = $item['count'];
                            print($quantity." of item number ".$item['id']."<br>");
                        }
                    }

                }
                else {
                //Else, display a form for people to upload a file to.
                    include "static/upload_form.php";
                }
            ?>
        </div>
    </div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-4">
                <a  href="champion.php?champion=Vayne"><img src="img/champion/Vayne.png" alt="Vayne"></a>
                <h2>Vayne, the Night Hunter</h2>
            </div>
            <div class="col-md-4">
                <a  href="champion.php?champion=Corki"><img src="img/champion/Corki.png" alt="Corki"></a>
                <h2>Corki, the Daring Bombardier</h2>
            </div>
            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
        </div>

      <hr>
<?php
    include "static/footer.php";
?>
