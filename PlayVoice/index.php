<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PlayVoice</title>
</head>
<body>
    <?php 
        $url = 'https://plasticbucket-cb721.firebaseio.com/NodeMCU.json';
        $response = file_get_contents($url);
        $path = json_decode($response);

        
        foreach($path as $i){
            if($i->Value == 50 && $i->Status == 1){
                print '<audio autoplay>'.'<source src="plasticvoice.mp3" type="audio/mpeg">'.'</audio>';
                print "<p>Value: ".$i->Value." Name: ".$i->Name."</p>";
            }
        }
        print '<META HTTP-EQUIV="Refresh" CONTENT="4;URL=index.php">';

    
    ?>
    
</body>
</html>