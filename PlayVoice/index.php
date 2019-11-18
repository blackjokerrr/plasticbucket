<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
    <?php 
        $url = 'https://plasticbucket-cb721.firebaseio.com/NodeMCU.json';
        $response = file_get_contents($url);
        $result = json_decode($response);


        if($result->ID_01 >= 0 && $result->ID_01 <= 9){
            print '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php">';
        }else if($result->ID_01 > 9){
            print '<audio autoplay>'.'<source src="Marshmello - Alone ( Squalzz Remix ) [kakzmuzik.com].mp3" type="audio/mpeg">'.'</audio>';
        }
        print $result->ID_01;
    
    ?>
    
</body>
</html>