<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <form action="expelled_list.php" method="post">
    	<div class='container'>
    		<ul class='pull-right'>
    			<li>
        			<input type="text" name="expelled_search_keyword" placeholder="제적 회원 통합 검색">
    			</li></br>
    		</ul>
        </div>
	</form>
	
	<?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from expelled_member";
    if (array_key_exists("expelled_search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["expelled_search_keyword"];
        $query .= " where student_id like '%$search_keyword%' or name like '%$search_keyword%'";
    }
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>학번</th>
            <th>이름</th>
            <th>제적 시기</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['student_id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['expulsion']}</td>";
            echo "<td width='17%'>
                <a href='expelled_form.php?student_id={$row['student_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['student_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        function deleteConfirm(student_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "expelled_delete.php?student_id=" + student_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>