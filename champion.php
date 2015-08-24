<?php
    include "static/header.php";
    $lang = 'en_US'; //default to US English
    if (isset($_GET['language'])) {
        $lang = $_GET['language'];
    }
    print(' <!-- Main jumbotron for a primary marketing message or call to action -->');
    print(' <div class="jumbotron">'."\n");
    print('     <div class="container">'."\n");
    print('         <div class="row">');
    print('             <div class="col-md-4">');
            //Champion Name as header
            if (isset($_GET['champion'])) {
                $champion_key = $_GET['champion'];
                $file_path = 'data/'.$lang.'/champion'.'/'.$champion_key.'.json';
                //print ("$file_path is where my json file is <br>");
                $local_file = file_get_contents($file_path);
                $data = json_decode($local_file, true);
                $name = $data['data'][$_GET['champion']]['name'];
                $title = $data['data'][$_GET['champion']]['title'];
                $image = $data['data'][$_GET['champion']]['image']['full'];
                print('<img src="img/champion/'.$image.'" alt="'.$name.'">');
                print('    </div>'."\n");
                print('             <div class="col-md-4">');
                print("<h1>$name</h1>");
                print("<p>$title</p>");
                print('    </div>'."\n");
                print('</div>'."\n");
            } else {
                print('<h1>ERROR: Champion not specified</h1> <br>');
            }
    print('    </div>'."\n");
    print('</div>'."\n");


    print('<div class="container">');
    print('    <div class="row">');
    print('        <div class="col-md-4">');
    print('            <h2>Stats</h2>');
    print('                  <table class="table table-condensed">');
    // foreach($data['data'][$_GET['champion']]['stats'] as $stat => $value) {
    //     print("$stat => $value <br>");
    // }
    //Health
    $hp = $data['data'][$_GET['champion']]['stats']['hp'];
    $hppl = $data['data'][$_GET['champion']]['stats']['hpperlevel'];
    print('<tr><td>Health</td><td>'.$hp.'+('.$hppl." per level)</td></tr>");
    //Health Regen
    $hp_regen = $data['data'][$_GET['champion']]['stats']['hpregen'];
    $hp_regenpl = $data['data'][$_GET['champion']]['stats']['hpregenperlevel'];
    print('<tr><td>Health Regen</td><td>'.$hp_regen.'+('.$hp_regenpl." per level) </td></tr>");
    //Mana
    $mp = $data['data'][$_GET['champion']]['stats']['mp'];
    $mppl = $data['data'][$_GET['champion']]['stats']['mpperlevel'];
    print('<tr><td>Mana</td><td>'.$mana.'+('.$mppl." per level) </td></tr>");
    //Mana Regen
    $mp_regen = $data['data'][$_GET['champion']]['stats']['mpregen'];
    $mp_regenpl = $data['data'][$_GET['champion']]['stats']['mpregenperlevel'];
    print('<tr><td>Mana Regen</td><td>'.$mp_regen.'+('.$mp_regenpl." per level) </td></tr>");
    //Attack Range
    $attack_range = $data['data'][$_GET['champion']]['stats']['attackrange'];
    print('<tr><td>Attack Range</td><td>'.$attack_range."</td></tr>");
    //Attack Damage
    $ad = $data['data'][$_GET['champion']]['stats']['attackdamage'];
    $adpl = $data['data'][$_GET['champion']]['stats']['attackdamageperlevel'];
    print('<tr><td>Attack Damage</td><td>'.$ad.'+('.$adpl." per level) </td></tr>");
    //Calculate Attackspeed
    $base_as = 0.625/($data['data'][$_GET['champion']]['stats']['attackspeedoffset'] + 1);
    $aspl = $data['data'][$_GET['champion']]['stats']['attackspeedperlevel'];
    print('<tr><td>Attack Speed</td><td>'.$base_as.'*('.$aspl." * (current level - 1)) </td></tr>");
    //Armor
    $armor = $data['data'][$_GET['champion']]['stats']['armor'];
    $armorpl = $data['data'][$_GET['champion']]['stats']['armorperlevel'];
    print('<tr><td>Armor</td><td>'.$armor.'+('.$armorpl." per level) </td></tr>");
    //Magic Resist
    $mr = $data['data'][$_GET['champion']]['stats']['spellblock'];
    $mrpl = $data['data'][$_GET['champion']]['stats']['spellblockperlevel'];
    print('<tr><td>Magic Resist</td><td>'.$mr.'+('.$mrpl." per level) </td></tr>");
    //Move Speed
    $ms = $data['data'][$_GET['champion']]['stats']['movespeed'];
    print('<tr><td>Move Speed</td><td>'.$ms."</td></tr>");
    print('</table>');
    print('        </div>');
    print('   </div>');
    print('<hr>');

    include "static/footer.php";
?>
