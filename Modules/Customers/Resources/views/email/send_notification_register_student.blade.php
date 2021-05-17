<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>[WE] Thư xác nhận đăng ký tài khoản</title>
    <style>
        #content {
            width: 600px;
            max-width: 100%;
            margin: auto;
            line-height: 1.8;
            font-weight: 400;
            font-size: 14px;
            font-family: Helvetica, sans-serif;
        }

        #content .header {
            padding: 30px;
        }

        #content .header .logo {
            display: block;
            margin: auto;
        }

        #content .body {
            width: 480px;
            max-width: 100%;
            margin: auto;
        }

        #content .opening {
            color: rgb(255, 153, 0);
            font-weight: 700;
        }
    </style>
</head>
<body>
<div>
    <div id="content">
        <div class="header">
            <img class="logo" src="">
        </div>
        <div class="body">
           <p>{{$student->name}}</p>
           <p>{{$student->activation_link}}</p>

            <p>Trân trọng,<br><b>Minh Việt Academy</b></p>
        </div>
    </div>
</div>
</body>
</html>
