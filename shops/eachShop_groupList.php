<?php

$shopID=$_GET["shop_id"];


require_once("../db-connect.php");
if(!isset($_GET["p"])){
    $p=1;
  }else{
    $p=$_GET["p"];
  }

  if(!isset($_GET["types"])){
    $types="1";
  }else{
    $types=$_GET["types"];
  }

  switch($types){
    case "1":
        $order="ASC";
        break;
    case "2":
        $order="DESC";
        break;

    default:
        $order="id ASC";
  }


$type= (isset($_GET['type']) && !empty($_GET['type']))?$_GET["type"]:"all";
if($type=='all') {
    $sql="SELECT * FROM groups WHERE shop_id='$shopID'";
}
// 開團中
else if($type=='start'){
    $sql="SELECT * FROM `groups` JOIN shop ON groups.shop_id=shop.shop_id
    WHERE now() > `groups_start_time` and  now() <`groups_end_time` and groups.shop_id='$shopID'";
}
// 已用餐，歷史訂單
else if($type=='history'){
    $sql="SELECT *  FROM groups WHERE least_num <= goal_num AND shop_id='$shopID' AND now() > `eating_date`
    ";}
// 已成團，成團人數超過最小限制
else if($type=='group'){
    $sql="SELECT *  FROM groups WHERE least_num <= goal_num AND shop_id='$shopID' AND now() <= `eating_date` AND now() > `groups_end_time`";
}
// 未成團
else if($type=='ungroup'){
    $sql="SELECT *  FROM groups WHERE least_num > goal_num AND shop_id='$shopID' AND now() > `groups_end_time`
    ";}else{
    $sql="SELECT * FROM groups WHERE shop_id='$shopID'";

}
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$groups_count=$result->num_rows;

$per_page=5;
$page_count=CEIL($groups_count/$per_page);

$start=($p-1)*$per_page;

if($type=='all') {
    $sql="SELECT * FROM groups WHERE shop_id='$shopID'";
}
// 開團中
else if($type=='start'){
    $sql="SELECT *  FROM groups WHERE least_num > goal_num AND shop_id='$shopID' AND now() >= `groups_start_time` AND  now() <=`groups_end_time`";
}
// 已用餐，歷史訂單
else if($type=='history'){
    $sql="SELECT *  FROM groups WHERE least_num <= goal_num AND shop_id='$shopID' AND now() > `eating_date`
    ";}
// 已成團，成團人數超過最小限制
else if($type=='group'){

    $sql="SELECT *  FROM groups WHERE least_num <= goal_num AND shop_id='$shopID' AND now() <= `eating_date` AND now() > `groups_end_time`";

}
// 未成團
else if($type=='ungroup'){
    $sql="SELECT *  FROM groups WHERE least_num > goal_num AND shop_id='$shopID' AND now() > `groups_end_time`
    ";
}else{
    $sql="SELECT * FROM groups WHERE shop_id='$shopID'";

}

$result=$conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);


?>
<!doctype html>
<html lang="en">

<head>
  <title>開團清單</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../template/style.css">
  <link rel="stylesheet" href="../template/sidebars.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    .nav-tabs .nav-link{
            font-weight: 500;
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;

        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
            margin-bottom: -1px;
            background: 0 0;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            font-weight: 900;
            color:maroon;
        }
    </style>
</head>

<body>
  <div class="">
    <div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
            <div class="sidebar-header text-center border border-bottom-1">
                <h4>後台管理</h4>
            </div>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                        data-bs-target="#home-collapse" aria-expanded="true">
                        商家管理
                    </button>
                    <div class="collapse show" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="shop_list.php" class="link-dark rounded">店家清單</a></li>
                            <li><a href="shop_groups_list.php" class="link-dark rounded">開團清單</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                        data-bs-target="#dashboard-collapse" aria-expanded="false">
                        會員管理
                    </button>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="link-dark rounded">會員清單</a></li>
                            <li><a href="#" class="link-dark rounded">優惠制度</a></li>
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
                <!-- 可以放content -->

        <div class="d-flex justify-content-between mb-4">
          <div>
            <h2 class="mb-4">開團清單</h2>
            <!-- search -->
            <!-- <div class="input-group">
              <div class="form-outline">
                <input id="search-focus" type="search" id="form1" class="form-control" placeholder="Search" />
              </div>
              <a href="" class="btn btn-outline-secondary input-group-text">
                <img src="./bootstrap-icons-1.8.1/search.svg" class="" alt="">
              </a>
            </div> -->
          </div>
          <div>
            <div class="input-group">


              <date_interval_create_from_date_string>


              </ㄎ>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between ">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link <?php if($type=='all') echo "active"?>" aria-current="page" href="eachShop_groupList.php?shop_id=<?=$shopID?>&type=all">全部開團</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($type=='start') echo "active"?>" href="eachShop_groupList.php?shop_id=<?=$shopID?>&type=start">開團中</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($type=='ungroup') echo "active"?>" href="eachShop_groupList.php?shop_id=<?=$shopID?>&type=ungroup">未成團</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($type=='group') echo "active"?>"href="eachShop_groupList.php?shop_id=<?=$shopID?>&type=group">已成團</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($type=='history') echo "active"?>" href="eachShop_groupList.php?shop_id=<?=$shopID?>&type=history">歷史訂單</a>
            </li>
          </ul>

        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <table class="table table-hover border border-1">
            <thead class=" p-3 mb-2 ">
              <tr>
                <th>開團編號</th>
                <th>開團時間</th>
                <th>截止時間</th>
                <th>用餐時間</th>
                <th>最少成團人數</th>
                <th>目前人數</th>
                <th>價格</th>
                <!-- <th>是否成團</th> -->
                <th>檢視</th>

              </tr>
            </thead>
            <tbody>
            <?php if($groups_count>0): ?>
                <?php foreach($rows as $row): ?>
              <tr>
                <td><a href="#"><?=$row["groups_id"]?></a></td>
                <td><?=$row["groups_start_time"]?></td>
                <td><?=$row["groups_end_time"]?></td>
                <td><?=$row["eating_date"]?> &nbsp; <?=$row["eating_time"]?></td>
                <td><?=$row["least_num"]?></td>
                <td><?=$row["goal_num"]?></td>
                <td><?=$row["price"]?></td>
                <td><a href="shop_groupsList_check.php?groups_id=<?=$row["groups_id"]?>" class="btn text-white" style="background-color:#BDC0BA; color:white;"> 檢視</a></td>


            </tr>

              <?php endforeach; ?>
                  <?php else: ?>

                    <?php endif; ?>
            </tbody>
          </table>
        </div>
        <a href="shop_detail.php?shop_id=<?=$row["shop_id"]?>" class="btn text-white mb-4" style="background-color:#BDC0BA; color:white;">返回店家主頁</a>



        <!-- pagination -->
        <div class="py-2">
            <nav aria-label="Page navigation example">
             <ul class="pagination">
               <!-- 動態產生頁碼數字 -->



              </ul>
            </nav>
            </div>
      </div>
    </div>

  </div>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
    <script src="../template/sidebars.js"></script>

</body>

</html>