<?php
    include "static/header.php";
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <?php

                //If there is a file, open it and interpret it's results
                if (isset($_POST['submit'])) {
                    //Get API key and prepare url for static api
                    $temp_key = file_get_contents('api.key'); // API Key is stored as a plaintext file in the webserver.
                    $api_key = rtrim($temp_key);
                    //API calls to /api/lol/static-data/en_US/v1.2/item/<item id> are not counted towards rate limit
                    $api_url_head = 'https://global.api.pvp.net/api/lol/static-data/na/v1.2/item/';
                    $api_url_tail = '?locale=en_US&itemData=all&api_key='.$api_key;
                    //Parse out the gold efficiency file into a dictionary
                    $efficiency_flatfile = file_get_contents('guides/item_tree.txt');
                    $efficiency_array = explode(PHP_EOL, $efficiency_flatfile);
                    $efficiency_lookup;
                    foreach ($efficiency_array as $line) {
                        $temp_arr = explode(",", $line);
                        $efficiency_lookup[$temp_arr[0]] = $temp_arr[1];
                    }
                    //var_dump($efficiency_lookup);
                    //Prepare the uploaded file
                    $contents= file_get_contents($_FILES['file']['tmp_name']); //opens the uploaded json file
                    $itemset_data = json_decode($contents, true);
                    $champion = $itemset_data['champion'];
                    $map = $itemset_data['mode'];
                    $title = $itemset_data['title'];
                    print("<h1> This is an itemset for ".$champion." on the map ".$map." named ".$title."</h1><br>");
                    foreach ($itemset_data['blocks'] as $block) {
                        print("<h2>".$block['type']."</h2><br>");
                        print('<table class="table table-condensed"> <thead> <tr><th>Item</th><th>Gold Efficiency</th></tr></thead><tbody>');
                        foreach ($block['items'] as $item) {
                            $quantity = $item['count'];
                            $item_id = $item['id'];
                            $api_url = $api_url_head.$item_id.$api_url_tail;
                            $item_json = file_get_contents($api_url);
                            $item_data = json_decode($item_json, true);
                            $img_name = $item_data['image']['full'];
                            $item_name = $item_data['name'];
                            $item_description = $item_data['sanitizedDescription'];
                            $item_id_str = (string) $item_id;
                            print('<tr><td>');
                            print('<a href="#" data-toggle="tooltip" title="'.$item_name.' '.$item_description.'"> <img src="img/item/'.$img_name.'" alt="'.$item_name." ".$item_description.'"> </a> </td>');
                            if (array_key_exists($item_id_str, $efficiency_lookup)) {
                                print("<td><p>".$efficiency_lookup[$item_id_str]."</p></td></tr>");
                            }
                            else {
                                print("<td>Gold Efficiency not calculated for this item</td></tr>");
                            }
                        }
                        print('</tbody></table>');
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
