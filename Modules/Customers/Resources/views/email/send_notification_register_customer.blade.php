<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>[Minh Việt] Chào mừng gia đình đến với Minh Việt Academy</title>
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
            <p class="opening">Minh Việt xin thông báo:</p>
            <p>Kính gửi bạn <b>{{$customer->name}}</b>,</p>
            <br>
            <p>Minh Việt đã nhận được yêu cầu đăng ký của bạn.</p>
            <p>Mã gia đình (Family ID - FID) của bạn là: <b>{{$customer->family->mv_id}}</b></p>
            <p>Để tạo một hồ sơ quản lý và học bạ điện tử tại MVA (còn được gọi là SIS), phụ huynh vui lòng đăng nhập
                vào sis.minhvietacademy.org</p>
            <p>Tên tài khoản: <b>{{$customer->email}}</b></p>
            <p>Mật khẩu: {{substr($customer->phone, 3)}}</p>
            <p>Sau khi đăng nhập thành công, phụ huynh cần hoàn tất hồ sơ học sinh và xác nhận đăng ký học thử cho
                con.</p>
            <p>Phụ huynh xem hướng dẫn hoàn tất hồ sơ học sinh và quy trình đăng ký học tập với MVA tại <a
                    href="http://bit.ly/3bTfXm3">đây</a>.</p>
            <p>Để được hỗ trợ, xin vui lòng liên hệ support@minhviet.org hoặc số điện thoại hotline của nhà trường:
                0886023235 (Vinaphone) hoặc 0378240235 (Viettel).
            </p>

            <br>

            <p>Trân trọng,<br><b>Minh Việt Academy</b></p>
        </div>
    </div>
</div>
</body>
</html>
