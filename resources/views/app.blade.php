<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>일기에 나를 적다</title>
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/animate.css">
</head>
<body>
<div id="app">
    <!-- 상단 헤더바 -->
    <div>
        <header></header>
    </div>

    <div class="container">
        <div class="wrap-1200">

            <div>
                <flash v-if="flashActivated" />
            </div>

            <router-view></router-view>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>
