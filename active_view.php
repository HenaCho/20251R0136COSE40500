<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("student_id", $_GET)) {
    $student_id = $_GET["student_id"];
    $query = "select * from active_member where student_id = $student_id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
    if (!$student) {
        msg("회원이 존재하지 않습니다.");
    }
}
$query = "select study_id, study_name, study_level, semester from take natural join ongoing_study where student_id = $student_id";
$take_study = mysqli_query($conn, $query);

$query = "select project_id, project_name, project_leader, start from active_member join ongoing_project on active_member.join_project_id = ongoing_project.project_id where student_id = $student_id";
$join_project = mysqli_query($conn, $query);

$query = "select study_id, study_name, study_level, finish_semester from complete natural join finished_study where student_id = $student_id";
$complete_study = mysqli_query($conn, $query);

$query = "select project_id, project_name, project_leader, finish from finish natural join finished_project where student_id = $student_id";
$finish_project = mysqli_query($conn, $query);
?>
    <div class="container fullwidth">

        <h3>회원 정보 상세 보기</h3>

        <p>
            <label for="student_id">학번</label>
            <input readonly type="text" id="student_id" name="student_id" value="<?= $student['student_id'] ?>"/>
        </p>

        <p>
            <label for="name">이름</label>
            <input readonly type="text" id="name" name="name" value="<?= $student['name'] ?>"/>
        </p>

        <p>
            <label for="registration">가입 시기</label>
            <input readonly type="text" id="registration" name="registration" value="<?= $student['registration'] ?>"/>
        </p>

        <p>
            <label for="level">회원 등급</label>
            <input readonly type="text" id="level" name="level" value="<?= $student['level'] ?>"/>
        </p>

        <p>
            <label for="take.study_id">수강 스터디</label>
            <table class="table table-striped table-bordered">
        		<tr>
            		<th>스터디 코드</th>
            		<th>스터디 이름</th>
            		<th>스터디 등급</th>
            		<th>수강 학기</th>
        		</tr>
        		<?
        		$row_index = 1;
        		while ($row = mysqli_fetch_array($take_study)) {
            		echo "<tr>";
            		echo "<td>{$row['study_id']}</td>";
            		echo "<td>{$row['study_name']}</td>";
            		echo "<td>{$row['study_level']}</td>";
            		echo "<td>{$row['semester']}</td>";
            		echo "</tr>";
            		$row_index++;
        		}
        		?>
        	</table>
        </p>
        
        <p>
            <label for="join_project_id">참여 프로젝트</label>
            <table class="table table-striped table-bordered">
        		<tr>
            		<th>프로젝트 코드</th>
            		<th>프로젝트 이름</th>
            		<th>프로젝트 리더</th>
            		<th>시작 시기</th>
        		</tr>
        		<?
        		$row_index = 1;
        		while ($row = mysqli_fetch_array($join_project)) {
            		echo "<tr>";
        		 	echo "<td>{$row['project_id']}</td>";
            		echo "<td>{$row['project_name']}</td>";
            		echo "<td>{$row['project_leader']}</td>";
            		echo "<td>{$row['start']}</td>";
            		echo "</tr>";
            		$row_index++;
        		}
        		?>
        	</table>
        </p>
        
        <p>
            <label for="complete.study_id">이수 스터디</label>
            <table class="table table-striped table-bordered">
        		<tr>
            		<th>스터디 코드</th>
            		<th>스터디 이름</th>
            		<th>스터디 등급</th>
            		<th>이수 학기</th>
        		</tr>
        		<?
        		$row_index = 1;
        		while ($row = mysqli_fetch_array($complete_study)) {
            		echo "<tr>";
            		echo "<td>{$row['study_id']}</td>";
            		echo "<td>{$row['study_name']}</td>";
            		echo "<td>{$row['study_level']}</td>";
            		echo "<td>{$row['finish_semester']}</td>";
            		echo "</tr>";
            		$row_index++;
        		}
        		?>
        	</table>
        </p>
        
        <p>
            <label for="finish.project_id">완료 프로젝트</label>
            <table class="table table-striped table-bordered">
        		<tr>
            		<th>프로젝트 코드</th>
            		<th>프로젝트 이름</th>
            		<th>프로젝트 리더</th>
            		<th>완료 시기</th>
        		</tr>
        		<?
        		$row_index = 1;
        		while ($row = mysqli_fetch_array($finish_project)) {
        		  	echo "<tr>";
        		  	echo "<td>{$row['project_id']}</td>";
            		echo "<td>{$row['project_name']}</td>";
            		echo "<td>{$row['project_leader']}</td>";
            		echo "<td>{$row['finish']}</td>";
            		echo "</tr>";
            		$row_index++;
        		}
        		?>
        	</table>
        </p>

    </div>
<? include "footer.php" ?>