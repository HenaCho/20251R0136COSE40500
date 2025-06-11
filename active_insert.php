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

if($join_project_id)
{
	$query1 = "insert into active_member(student_id, name, registration, level, join_project_id) values('$student_id', '$name', '$registration', '$level', '$join_project_id')";
}
else
{
	$query1 = "insert into active_member(student_id, name, registration, level, join_project_id) values('$student_id', '$name', '$registration', '$level', 'NULL')";
}

$result1 = mysqli_query($conn, $query1);
$result2 = true;
$result3 = true;
$result4 = true;
if($take_study_id)
{
	foreach($take_study_id as $id)
	{
		$result2 = mysqli_query($conn, "insert into take(study_id, student_id) values('$id', '$student_id')");
	}
}
if($complete_study_id)
{
	foreach($complete_study_id as $id)
	{
		$result3 = mysqli_query($conn, "insert into complete(study_id, student_id) values('$id', '$student_id')");
	}
}
if($finish_project_id)
{
	foreach($finish_project_id as $id)
	{
		$result4 = mysqli_query($conn, "insert into finish(project_id, student_id) values('$id', '$student_id')");
	}
}

if(!$result1 || !$result2 || !$result3 || !$result4)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
	mysqli_close($conn);
    s_msg('성공적으로 입력 되었습니다');
    echo "<script>location.replace('active_list.php');</script>";
}
?>