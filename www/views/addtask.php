<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}
require_once('../admin/db.php');
$department = get_department_user($_SESSION['user']);
$account = getEmployeebyDepartment($department);
$idtask = uniqid();
$error = '';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date("d/m/Y H:i");

// addTask($accountID, $deadline, $departmentID, $detail, $id, $startDay, $status, $tagFile, $title)
if (
    isset($_POST['deadline']) && isset($_POST['title']) && isset($_POST['detail'])
    && isset($_POST['tagFile']) && isset($_POST['deadline']) && $_POST['accountID']
) {
    $re = addTask(
        $_POST['accountID'],
        $_POST['deadline'],
        $department,
        $_POST['detail'],
        $idtask,
        $date,
        "Waiting",
        $_POST['tagFile'],
        $_POST['title']
    );
    if ($re['code'] == 0) {
        header('Location: ../views/leader_index.php');
    }
} else {
    $error = "Check your infomation";
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Add task</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Thêm nhiệm vụ</h3>
                <form method="post" action="addtask.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label>Mã nhiệm vụ:</label>
                        <input disabled value='<?php echo $idtask ?>' class="form-control " name="id" id="id" type="text" placeholder="Chưa có mã nhiệm vụ">
                    </div>
                    <div class="form-group">
                        <label>Mã phòng ban</label>
                        <input disabled value='<?php echo $department ?>' class="form-control" name="department" id="department" type="text" placeholder="Chưa có phòng ban">
                    </div>
                    <div class="form-group">
                        <label>Ngày giao</label>
                        <input disabled value="<?php echo  $date ?>" class="form-control" name="startDay" id="startDay" type="text" placeholder="Ngày giao">
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input class="form-control" name="deadline" id="deadline" type="datetime-local" placeholder="Ngày giao">
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="hidden" value="Waiting" name="status" id="status">
                        <input class="form-control" name="title" id="title" type="text" placeholder="Chưa có tiêu đề">
                    </div>
                    <div class="form-group">
                        <label>Nhân viên</label>
                        <select class="form-control" name="accountID" id="accountID">'
                            <?php
                            while ($row = $account->fetch_assoc()) {
                            ?>
                                <option value='<?php echo $employee = $row["username"] ?>'><?php echo $row['username'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="detail" id="detail" cols="20" rows="10" style="height:100px" placeholder="Mô tả về nhiệm vụ"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">File đính kèm (nếu có)</label>
                        <input type='file' id="tagFile" name="tagFile" />
                    </div>
                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <div class="form-group">
                            <p class="text-center" style="margin:15px">
                                <button type="submit" onclick="submitTask()" class="btn btn-success px-5 h-5">Thêm</button></span>
                                <button class="btn btn-danger px-5 h-5">Huỷ bỏ</button></span>
                            </p>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>