<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "begin");

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$registration = $_POST['registration'];
$level = $_POST['level'];
$join_project_id = $_POST['join_project_id'];
$take_study_id = $_POST['take_study_id'];
$complete_study_id = $_POST['complete_study_id'];
$finish_project_id = $_POST['finish_project_id'];

$query1 = "update active_member set name = '$name', registration = '$registration', level = '$level', join_project_id = '$join_project_id' where student_id = '$student_id'";

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

$take_to_delete = array_diff($take_studies, $take_study_id);
$complete_to_delete = array_diff($complete_studies, $complete_study_id);
$finish_to_delete = array_diff($finish_projects, $finish_project_id);

$take_to_add = array_diff($take_study_id, $take_studies);
$complete_to_add = array_diff($complete_study_id, $complete_studies);
$finish_to_add = array_diff($finish_project_id, $finish_projects);
	
$result1 = mysqli_query($conn, $query1);
$result2 = true;
$result3 = true;
$result4 = true;
$result5 = true;
$result6 = true;
$result7 = true;
if($take_to_delete)
{
	foreach($take_to_delete as $id)
	{
		$result2 = mysqli_query($conn, "delete from take where student_id = $student_id and study_id = $id");
	}
}
if($complete_to_delete)
{
	foreach($complete_to_delete as $id)
	{
		$result2 = mysqli_query($conn, "delete from complete where student_id = $student_id and study_id = $id");
	}
}
if($finish_to_delete)
{
	foreach($finish_to_delete as $id)
	{
		$result2 = mysqli_query($conn, "delete from finish where student_id = $student_id and project_id = $id");
	}
}

if($take_to_add)
{
	foreach($take_to_add as $id)
	{
		$result5 = mysqli_query($conn, "insert into take(study_id, student_id) values('$id', '$student_id')");
	}
}
if($complete_to_add)
{
	foreach($complete_to_add as $id)
	{
		$result6 = mysqli_query($conn, "insert into complete(study_id, student_id) values('$id', '$student_id')");
	}
}
if($finish_to_add)
{
	foreach($finish_to_add as $id)
	{
		$result7 = mysqli_query($conn, "insert into finish(project_id, student_id) values('$id', '$student_id')");
	}
}

if(!$result1 || !$result2 || !$result3 || !$result4 || !$result5 || !$result6 || !$result7)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
	mysqli_close($conn);
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('active_list.php');</script>";
}
?>