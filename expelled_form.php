<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "expelled_insert.php";

if (array_key_exists("student_id", $_GET)) {
    $student_id = $_GET["student_id"];
    $query = "select * from expelled_member where student_id = $student_id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_array($result);
    if(!$student) {
        msg("회원이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "expelled_modify.php";
}

?>
    <div class="container">
        <form name="expelled_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="student_id" value="<?=$student['student_id']?>"/>
            <h3>제적 회원 정보 <?=$mode?></h3>
            <p>
                <label for="student_id">학번</label>
                <input type="text" placeholder="학번 입력" id="student_id" name="student_id" value="<?=$student['student_id']?>"/>
            </p>
            <p>
                <label for="name">이름</label>
                <input type="text" placeholder="이름 입력" id="name" name="name" value="<?=$student['name']?>"/>
            </p>
            <p>
                <label for="expulsion">제적 시기 (year-month-date)</label>
                <input type="text" placeholder="제적 시기 입력" id="expulsion" name="expulsion" value="<?=$student['expulsion']?>"/>
            </p>
            </br>
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("student_id").value == "") {
                        alert ("학번을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("name").value == "") {
                        alert ("이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("expulsion").value == "") {
                        alert ("제적 시기를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>