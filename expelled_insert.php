<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "begin");

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$expulsion = $_POST['expulsion'];

$result = mysqli_query($conn, "insert into expelled_member(student_id, name, expulsion) values('$student_id', '$name', '$expulsion')");

if(!$result)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
	mysqli_close($conn);
    s_msg ('성공적으로 입력 되었습니다');
    echo "<script>location.replace('expelled_list.php');</script>";
}

?>