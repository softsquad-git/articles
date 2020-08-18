<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5c8b33440b.js" crossorigin="anonymous"></script>
    <style>
        .container {
            width: 600px;
            margin: 50px auto 50px auto;
            border: 1px solid #e8e6e6;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px 0 rgb(224, 224, 224);
            font-family: 'Lato', sans-serif;
        }
        .txt-center{
            text-align: center;
        }
        .intro-welcome {
            font-size: 26px;
            margin-bottom: 15px;
        }
        .hello-user {
            font-size: 18px;
            font-weight: bold;
            color: #8bc34a;
        }
        p.text {
            font-size: 14px;
            color: #2f2f2f;
        }
        .key_verification {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p.sub-txt {
            font-size: 12px;
            color: #4a4949;
        }
        .footer {
            margin-top: 70px;
            border-top: 1px solid #d0d0d0;
            padding-top: 10px;
            color: #2d2d2d;
            padding-bottom: 10px;
            border-bottom: 1px solid #d0d0d0;
        }
        a {
            text-decoration: none;
            color: #556f36;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="intro-welcome">
        News Up
    </div>
    <div class="txt-center hello-user">
        Witaj, {{ $fullName }}
    </div>
    @yield('content')

    <div class="footer txt-center">
        <i class="fa fa-mail"></i> contact@news-up.com <br/> <br/>
        <i class="fa fa-url"></i> <a href="https://www.news-up.com" target="_blank">Strona główna</a>
    </div>
    <p class="txt-center sub-txt">
        Pamiętaj że każda wiadomość do Ciebie zawsze zawiera Twoje imię i nazwisko.
    </p>
</div>
</body>
</html>
