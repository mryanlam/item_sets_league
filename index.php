<?php
    include "static/header.php";
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <?php

                function file_get_contents_curl($url) {
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
                    curl_setopt($ch, CURLOPT_URL, $url);

                    $data = curl_exec($ch);
                    curl_close($ch);

                    return $data;
                }

                //If there is a file, open it and interpret it's results
                if (isset($_POST['submit'])) {
                    //print("<p> The contents of the file are </p> <br>");
                    $contents= file_get_contents($_FILES['file']['tmp_name']);
                    //print ($contents);
                    $api_key = file_get_contents('api.key'); // API Key is stored as a plaintext file in the webserver.
                    $api_url_head = 'https://global.api.pvp.net/api/lol/static-data/na/v1.2/item/';
                    $api_url_tail = '?locale=en_US&itemData=all&api_key='.$api_key;
                    //https://global.api.pvp.net/api/lol/static-data/na/v1.2/item/1001?locale=en_US&itemData=all&api_key=<API KEY>
                    //API calls to /api/lol/static-data/en_US/v1.2/item/<item id> are not counted towards rate limit
                    $itemset_data = json_decode($contents, true);
                    $champion = $itemset_data['champion'];
                    $map = $itemset_data['mode'];
                    $title = $itemset_data['title'];
                    print("<p> This is an itemset for ".$champion." on the map ".$map." named ".$title."</p><br>");
                    foreach ($itemset_data['blocks'] as $block) {
                        print("<p>".$block['type']."</p><br>");
                        foreach ($block['items'] as $item) {
                            $quantity = $item['count'];
                            $item_id = $item['id'];
                            $api_url = $api_url_head.$item_id.$api_url_tail;
                            //$item_json = file_get_contents($api_url);
                			$item_json = file_get_contents_curl($api_url);

                            // if ($this->responseCode == 200) {
                                $item_data = json_decode($item_json, true);
                                $img_name = $item_data['image']['full'];
                                $item_name = $item_data['name'];
                                $item_description = $item_data['sanitizedDescription'];
                                print($quantity." of <img src=\"img/item/".$img_name."\" alt=\"".$item_name." ".$item_description."\"> <br>");
                            // }
                            // else {
                                //print("API ERROR ".$this->responseCode."<br>");
                                print("Query was ".$api_url."<br>");
                                print("Item JSON <br>");
                                var_dump($item_json);
                                print("Item Data <br>");
                                var_dump($item_data);
                            //}
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
                <a  href="champion.php?champion=Sivir"><img src="img/champion/Sivir.png" alt="Sivir"></a>
                <h2>Sivir, the Battle Mistress</h2>
            </div>
        </div>

      <hr>
<?php
    include "static/footer.php";
?>
