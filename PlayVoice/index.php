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
        $url = 'https://plasticbucket-cb721.firebaseio.com/NodeMCU.json'; #ดึงค่าผ่าน FireBase เป็น Json 
        $content = file_get_contents($url);
        $path = json_decode($content); #Decode Json ออกเพื่อนำมาเก็บไว้ในตัวแปร path

        #Check Plastic Voice ว่าค่าเข้ามาหรือเปล่าโดยการวน Loop เข้าไปใน Json ของ API Firebase ของ Project
        foreach($path as $navigate){
            /* เงื่อน Check ค่าที่ส่งขึ้นมาว่า มีค่าตั้งแต่ 50 และ ไม่เท่ากับ 1024 หรือเปล่า เพราะ ค่า <= 500 คือค่าที่ Laser อ่อนกำลังลง คือมีวัตถุมาบัง Laser ถ้า Laser มีกำลังมากจะ < 1024 ลงไปไม่มาก
            เพราะ Max ที่สุดที่ Sensor สามารถวัดได้คือ 1024 ซึ่ง เราจะยิง Laser ตลอดเวลาจึงมีเงื่อนไขว่าจะต้องไม่เท่ากับ 1024 */
            if($navigate->Value <= 500 && $navigate->Value != 1024){
                print '<audio autoplay>'.'<source src="plasticvoice.mp3" type="audio/mpeg">'.'</audio>'; # เล่นเสียงจาก File เสียง ซึ่งอัดมาจาก Google Translate
                print "<p>Value: ".$navigate->Value." Name: ".$navigate->Name."</p>"; #Show ค่าและ ID ของ NodeMCU ที่ส่งค่าขึ้นมาบน Firebase
            }
        }

        #ทำการ Refesh ทุกๆ 4 วินาที
        print '<META HTTP-EQUIV="Refresh" CONTENT="4;URL=index.php">';

    
    ?>
    
</body>
</html>