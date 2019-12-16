<!DOCTYPE html>
<html lang="en">
<head>
    <!-- รองรับ responsive และ การอ่านตัวหนังสือภาษาไทย !-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- ชื่อ Title ของ Website !-->
    <title>PlayVoice</title>
    <!-- นำ Bootstrap เข้ามาเพื่อตกแต่งหน้า Website ให้สวยขึ้น !-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Itim&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Itim', cursive;
        }
        .content{
            font-size: 25px;
        }
    </style>

</head>
<body class="bg-info">
    <?php
        /*เราจะรับค่าจาก Firebase Check เพื่อทำการเล่นเพลง*/
        $url = 'https://plasticbucket-cb721.firebaseio.com/NodeMCU.json'; #ดึงค่าผ่าน FireBase เป็น Json
        $content = file_get_contents($url);
        $path = json_decode($content); #Decode Json ออกเพื่อนำมาเก็บไว้ในตัวแปร path

        #ดึง API ของเวลาในกรุงเทพ
        $time_of_bangkok = 'http://worldtimeapi.org/api/timezone/Asia/Bangkok';
        $time_of_bangkok_content = file_get_contents($time_of_bangkok);
        $clock = json_decode($time_of_bangkok_content);

        $start = 0;
        $stop = 0;

        $reset = '';

        $counter_Bottle = 0;




        print '<div class="container">';
        print '<h1 class="text-center"><b>Plastic Bucket</b></h1><hr>';
        #Check Plastic Voice ว่าค่าเข้ามาหรือเปล่าโดยการวน Loop เข้าไปใน Json ของ API Firebase ของ Project
        foreach($path as $navigate){
            /* เป็นเงื่อนไขในการ Check ค่าที่ส่งขึ้นมาว่า มีค่าตั้งแต่ 50 และ ไม่เท่ากับ 1024 หรือเปล่า เพราะ ค่า <= 500 คือค่าที่ Laser อ่อนกำลังลง คือมีวัตถุมาบัง Laser ถ้า Laser มีกำลังมากจะ < 1024 ลงไปไม่มาก
            เพราะ Max ที่สุดที่ Sensor สามารถวัดได้คือ 1024 ซึ่ง เราจะยิง Laser ตลอดเวลาจึงมีเงื่อนไขว่าจะต้องไม่เท่ากับ 1024 */
            if($navigate->Value >= 900 && $navigate->Value <= 1024){
                print '<audio autoplay>'.'<source src="plasticvoice.mp3" type="audio/mpeg">'.'</audio>'; # เล่นเสียงจาก File เสียง ซึ่งอัดมาจาก Google Translate
                print '<h3 style="float: left;"><b>NodeMCU ที่ใช้งานอยู่ : &nbsp</b></h3>';
                print "<p class='content'>ค่าของ Sensor: ".$navigate->Value.", ID ของ NodeMCU: ".$navigate->Name."</p>"; #Show ค่าและ ID ของ NodeMCU ที่ส่งค่าขึ้นมาบน Firebase

            }
            $counter_Bottle = $navigate->Plastic_Bottle;
        }

        /* ส่วนเเสริมของ Project มีการ Reset ขวดพลาสติกทุกๆ 1 วัน และ นับจำนวนขวดพลาสติกที่เก็บทุกๆ 1 วัน */
        $start = strpos($clock->datetime, 'T') + 1; # หาตัวอักษร T

        $stop  = strpos($clock->datetime, "."); # หาอักขระ '.'

        # เข้าไปใน String ของ datetime ตัวอย่างเช่น 2019-05-01T19:20:35.5999999
        for($loop = 0;$loop < 2;$loop++){
            $reset.= (string)$clock->datetime[$start];
            $start += 1;
        }

        # ถ้าครบ 24 ชั่วโมง จะทำการ reset ขวดพลาสติก หรือก็คือ มีเจ้าหน้าที่หรือแม่บ้านมาเก็บขวดไปเรียบร้อยเเล้ว
        if($reset == "24"){
            $counter_Bottle = 0;
        }

        # Show ขวดพลาสติกบน Website
        print '<p class="content">จำนวนขวดของวันนี้ : '.$counter_Bottle.'</p> ';
        print '</div>';

        #ทำการ Refesh หน้าเว็บทุกๆ 2 วินาที
        print '<META HTTP-EQUIV="Refresh" CONTENT="2;URL=index.php">';


    ?>


    <!-- นำ Bootstrap เข้ามาเพื่อตกแต่งหน้า Website ให้สวยขึ้น !-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>