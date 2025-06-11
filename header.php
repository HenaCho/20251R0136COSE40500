<html lang='ko'>
<head>
    <title>KU-club</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="active_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">KU-club</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="활동 회원 통합 검색">
                </li>
                <li><a href='active_list.php'>활동 회원 목록</a></li>
                <li><a href='active_form.php'>활동 회원 등록</a></li>
                <li><a href='expelled_list.php'>제적 회원 목록</a></li>
                <li><a href='expelled_form.php'>제적 회원 등록</a></li>
            </ul>
        </div>
    </div>
</form>