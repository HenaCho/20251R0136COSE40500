<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "begin");

$student_id = $_GET['student_id'];

$ret2 = mysqli_query($conn, "delete from take where student_id = $student_id");
$ret3 = mysqli_query($conn, "delete from complete where student_id = $student_id");
$ret4 = mysqli_query($conn, "delete from finish where student_id = $student_id");
$ret = mysqli_query($conn, "delete from active_member where student_id = $student_id");

if(!$ret || !$ret2 || !$ret3 || !$ret4)
{
	mysqli_query($conn, "rollback");
	msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
	mysqli_close($conn);
	s_msg ('성공적으로 삭제 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=active_list.php'>";
}
?>