<? //Generate text file on the fly
    if (isset($_POST['submit'])) {
        //print("<p> The contents of the file are </p> <br>");
        $contents= file_get_contents($_FILES['file']['tmp_name']);
        //print ($contents);
        $data = json_decode($contents, true);
        $champion = $data['champion'];
        $map = $data['mode'];
        $data['title'] = 'iteminsights.azurewebsites.net';
        //print ("<p> This is an itemset for ".$champion." on the map ".$map." named ".$title."</p><br>");
        foreach ($data['blocks'] as $block) {
            //print("<p>".$block['type']."</p><br>");
            foreach ($block['items'] as $item) {
                $quantity = $item['count'];
                //print($quantity." of item number ".$item['id']."<br>");
            }
        }
        //The content of the build with be the blocks, each block contains items
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=items.json");

        // do your Db stuff here to get the content into $content
        $output = json_encode($data);
        print $output;
    }
    else {
        include "static/header.php";
        print('<div class="jumbotron">'."\n");
        print('    <div class="container">'."\n");
        //print('<h1>Error: No arguments found</h1>'. "\n");
        include "static/upload_form.php";
        print('    </div>'."\n");
        print('</div>'."\n");
        print('<div class="container">');
        print('<hr>');
        include "static/footer.php";
    }
?>
