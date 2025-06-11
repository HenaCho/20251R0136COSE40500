<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "active_insert.php";

if (array_key_exists("student_id", $_GET)) {
    $student_id = $_GET["student_id"];
    $query = "select * from active_member where student_id = $student_id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_array($result);
    if(!$student) {
        msg("회원이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "active_modify.php";
    
    $take_studies = array();
	$complete_studies = array();
	$finish_projects = array();

	$query = "select study_id from take where student_id = $student_id";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
    	$take_studies[] = $row['study_id'];
	}

	$query = "select study_id from complete where student_id = $student_id";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
    	$complete_studies[] = $row['study_id'];
	}

	$query = "select project_id from finish where student_id = $student_id";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
    	$finish_projects[] = $row['project_id'];
	}
}

$ongoing_studies = array();
$finished_studies = array();
$ongoing_projects = array();
$finished_projects = array();

$query = "select * from ongoing_study";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    $ongoing_studies[$row['study_id']] = $row['study_name'];
}

$query = "select * from finished_study";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    $finished_studies[$row['study_id']] = $row['study_name'];
}

$query = "select * from ongoing_project";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    $ongoing_projects[$row['project_id']] = $row['project_name'];
}

$query = "select * from finished_project";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    $finished_projects[$row['project_id']] = $row['project_name'];
}

?>
    <div class="container">
        <form name="active_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="student_id" value="<?=$student['student_id']?>"/>
            <h3>회원 정보 <?=$mode?></h3>
            <h5>다중 선택의 경우 ctrl을 누른 상태로 선택하시면 여러 개를 선택할 수 있습니다.</h5>
            <p>
                <label for="student_id">학번</label>
                <input type="text" placeholder="학번 입력" id="student_id" name="student_id" value="<?=$student['student_id']?>"/>
            </p>
            <p>
                <label for="name">이름</label>
                <input type="text" placeholder="이름 입력" id="name" name="name" value="<?=$student['name']?>"/>
            </p>
            <p>
                <label for="registration">가입 시기 (year-month-date)</label>
                <input type="text" placeholder="가입 시기 입력" id="registration" name="registration" value="<?=$student['registration']?>"/>
            </p>
            <p>
                <label for="level">회원 등급</label>
                <input type="text" placeholder="회원 등급 입력" id="level" name="level" value="<?=$student['level']?>"/>
            </p>
            <p>
            	<label for="take_study_id">수강 스터디</label>
                <select name="take_study_id[]" id="take_study_id" multiple="multiple">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                    	foreach ($ongoing_studies as $id => $name) {
            				$selected = ($mode != "입력" && $take_studies && in_array($id, $take_studies)) ? "selected" : "";
            				echo "<option value='{$id}' $selected>{$name}</option>";
        				}
                    ?>
                </select>
            </p>
            <p>
            	<label for="join_project_id">참여 프로젝트</label>
                <select name="join_project_id" id="join_project_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($ongoing_projects as $id => $name) {
                            if($id == $student['join_project_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
            	<label for="complete_study_id">이수 스터디</label>
                <select name="complete_study_id[]" id="complete_study_id" multiple="multiple">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                    	foreach ($finished_studies as $id => $name) {
            				$selected = ($mode != "입력" && $complete_studies && in_array($id, $complete_studies)) ? "selected" : "";
            				echo "<option value='{$id}' $selected>{$name}</option>";
        				}
                    ?>
                </select>
            </p>
            <p>
            	<label for="finish_project_id">완료 프로젝트</label>
                <select name="finish_project_id[]" id="finish_project_id" multiple="multiple">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                    	foreach ($finished_projects as $id => $name) {
            				$selected = ($mode != "입력" && $finish_projects && in_array($id, $finish_projects)) ? "selected" : "";
            				echo "<option value='{$id}' $selected>{$name}</option>";
        				}
                    ?>
                </select>
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
                    else if(document.getElementById("registration").value == "") {
                        alert ("가입 시기를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("level").value == "") {
                        alert ("회원 등급을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("join_project_id").value == "-1") {
                    	alert ("참여 프로젝트를 선택해 주십시오. 참여 프로젝트가 없다면 '없음'을 선택해 주십시오."); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>