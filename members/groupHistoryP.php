<?php
require_once("../db-connect.php");


$id = $_GET["id"];

$sql = "SELECT user.*, level_name.name AS levelName FROM user 
JOIN level_name ON user.user_level = level_name.id WHERE user_id='$id' AND valid=1 ";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// if (!$row) {
//     header("location: 404.php");
// }

$g_id = $_GET["g_id"];

$sqlGroup = "SELECT groups.*, user_and_groups.*, user_and_groups.compliment AS comment FROM groups JOIN user_and_groups ON groups.groups_id = user_and_groups.groups_id WHERE groups.groups_id = '$g_id' ";

$resultGroup = $conn->query($sqlGroup);
$rowGroup = $resultGroup->fetch_assoc();


if (!$rowGroup) {
    header("location: 404.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../template/style.css">
    <link href="../template/sidebars.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .btn-check:focus+.btn,
        .btn:focus {
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%);
        }

        .btn-cute {
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
    </style>



</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header text-center border border-bottom-1">
                <h4>後台管理</h4>
            </div>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        商家管理
                    </button>
                    <div class="collapse" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="link-dark rounded">店家資訊</a></li>
                            <li><a href="#" class="link-dark rounded">店家清單</a></li>
                            <li><a href="#" class="link-dark rounded">開團清單</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
                        會員管理
                    </button>
                    <div class="collapse show" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="user-list.php" class="link-dark rounded">會員清單</a></li>
                            <li><a href="#" class="link-dark rounded">優惠制度</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        客服管理
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="link-dark rounded">商家意見反應</a></li>
                            <li><a href="#" class="link-dark rounded">會員意見反應</a></li>

                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        <div>
            <i class="btn btn-light btn-cute fa-solid fa-arrows-left-right border-start-none" id="toggle"></i>
        </div>
        <!-- Page Content  -->
        <div id="content">
            <div class="d-flex justify-content-between mb-4">
                <!-- 可以放header -->
            </div>
            <div>
                <!-- content -->
                <div class="container">

                    <div class="row">
                    <div class="py-2 justify-content-center ">
                            <a href="javascript:history.go(-1)" class="btn text-Secondary  "><i class="fa-solid fa-arrow-rotate-left"></i></a>

                        </div>
                        <div class="py-2">
                            <table class="table table-bordered text-nowrap">
                                <nav aria-label="Page navigation example">
                                </nav>
                                <thead>
                                    <tr class="text-center">
                                        <th>會員編號</th>
                                        <th>會員姓名</th>
                                        <th>身分證字號</th>
                                        <th>會員等級</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td><?= $row["user_id"] ?></td>
                                        <td><?= $row["user_name"] ?></td>
                                        <td><?= $row["identity_card"] ?></td>
                                        <td><?= $row["levelName"] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered nowrap">
                            <tr>
                                <th>參團編號</th>
                                <td><?= $rowGroup["groups_id"] ?></td>
                            </tr>
                            <tr>
                                <th>店家名稱</th>
                                <td><?= $rowGroup["groups_name"] ?></td>
                            </tr>
                            <tr>
                                <th>用餐日期</th>
                                <td><?php
                                    $date = $rowGroup["eating_time"];
                                    $dateM = explode(" ", $date);
                                    echo $dateM[0];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>截團日期</th>
                                <td>
                                    <?php
                                    $date = $rowGroup["groups_end_time"];
                                    $dateM = explode(" ", $date);
                                    echo $dateM[0];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>成團與否</th>
                                <td>
                                    <?php
                                    if ($rowGroup["least_num"] <= $rowGroup["goal_num"]) {
                                        echo "是";
                                    } else {
                                        echo "否";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>成團最低人數</th>
                                <td><?= $rowGroup["least_num"] ?></td>
                            </tr>
                            <tr>
                                <th>目前參團人數</th>
                                <td><?= $rowGroup["goal_num"] ?></td>
                            </tr>
                            <tr>
                                <th>付款與否</th>
                                <td>
                                    <?php
                                    if ($rowGroup["least_num"] <= $rowGroup["goal_num"]) {
                                        echo "是";
                                    } else {
                                        echo "否";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if ($rowGroup["least_num"] <= $rowGroup["goal_num"]) : ?>
                                <tr>
                                    <th>用戶評論</th>
                                    <td>
                                        <?= $rowGroup["comment"] ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="../template/sidebars.js"></script>
</body>

</html>