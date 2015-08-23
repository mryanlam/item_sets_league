<?php
    include "static/header.php";
    $lang = 'en_US'; //default to US English
    if (isset($_GET['language'])) {
        $lang = $_GET['language'];
    }
    print (<!-- Main jumbotron for a primary marketing message or call to action -->);
    print (<div class="jumbotron">);
        print (<div class="container">);
            //Champion Name as header
            if (isset($_GET['champion'])) {
                $data = json_decode('data/'.$lang.'/champion/'.$_GET['champion'].'json');
                $name = $data['data'][$_GET['champion']]['name'];
                $title = $data['data'][$_GET['champion']]['title'];
                $image = $data['data'][$_GET['champion']]['image']['full'];
                print ('<img src="img/champion/'.$image.'" alt="'.$name.'">');
                print ("<h1>$name</h1><br>");
                print ("<p>$title</p>");
            } else {
                print ('<h1>ERROR: Champion not specified</h1> <br>');
            }
        print (</div>);
    print (</div>);

    include "static/footer.php";
?>
