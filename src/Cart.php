<?php

session_start();
if(!isset($_SESSION["USER_ID"])){
  header("Location: ./Login.php");
}
$userid = $_SESSION["USER_ID"];

$sum = 0;
$count = 0;
$product_id = filter_input(INPUT_GET,"product_id");
$pagename = filter_input(INPUT_GET,"pagename");
$exec = filter_input(INPUT_GET, "exec");

// カート商品削除
if(isset($exec)){
  $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";
  
  try{
    $db = new PDO($dsn, "se_c_root", "29_Man");

    $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $db -> beginTransaction();

    $stmt = $db -> prepare("DELETE FROM Cart WHERE user_id = :user_id AND product_id = :product_id");

    $stmt -> bindParam(":user_id", $userid, PDO::PARAM_STR);
    $stmt -> bindParam(":product_id", $product_id, PDO::PARAM_STR);
    $stmt -> execute();
    $db -> commit();    

  }catch(PDOException $peo){
    $db -> rollBack();
  }finally{
    $stmt = null;
    $db = null;
    header("Location: Cart.php");
  }
}
// カート商品削除

// カート追加
if(!isset($exec)){
  if(isset($product_id)){
    $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";
    
    try{
      $db = new PDO($dsn, "se_c_root", "29_Man");
  
      $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
      $db -> beginTransaction();
  
      $stmt = $db -> prepare("INSERT INTO Cart VALUES(:user_id, :product_id)");
  
      $stmt -> bindParam(":user_id", $userid, PDO::PARAM_STR);
      $stmt -> bindParam(":product_id", $product_id, PDO::PARAM_STR);
      $stmt -> execute();
      $db -> commit();    
  
    }catch(PDOException $peo){
      $db -> rollBack();
    }finally{
      $stmt = null;
      $db = null;
      if(isset($pagename)){
        header("Location: {$pagename}.php");
      }else{
        header("Location: Cart.php");
      }
    }
  }
}
// カート追加



// カート表示
//DB接続
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

$result = [
  "status"  => true, //エラーがあった場合  false
  "message" => "", //表示するメッセージ
  "result"  => null, //更新結果(件数)
];

if($_SERVER["REQUEST_METHOD"] !== "GET"){
  header("Location: Cart.php");
  exit();
}

try{
  $db = new PDO($dsn, "se_c_root", "29_Man");

  $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $sql = "SELECT * FROM Cart c JOIN PRODUCT p ON c.PRODUCT_ID = p.PRODUCT_ID";
  $where = " WHERE 1=1";
  $idwhere = "";

  if($userid) {
    $idwhere = " AND USER_ID = :userid";
  }

  $where .= $idwhere;

  // prepare : セット
  $stmt = $db -> prepare($sql.$where);
  
  if($userid){
    $stmt -> bindParam(":userid", $userid, PDO::PARAM_STR);
  }

  // TODO:debug
  // echo "SQL文:{$sql}{$where}";

  // execute : SQL の実行
  $stmt -> execute();

  $result["result"] = [];
  // fetch:1列
  while($rows = $stmt -> fetch(PDO::FETCH_ASSOC)){
      $result["result"][] = $rows;
      $sum += $rows["PRICE"];
      $count = count($result["result"]);
  }
  // var_dump($sum);
  if(empty($result["result"])){
    $result["message"] = $result["message"]."カートに商品が入っていません。";
    // お気に入り商品の登録はありません。
  }
}catch(PDOException $peo){
    exit("DBエラー".$peo -> getMessage());
}finally{
    $stmt = null;
    $db = null;
}
// カート表示

?>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
  <link rel="stylesheet" href="../assets/css/Decorate.css">
  <link rel="stylesheet" href="../assets/css/Cart.css">

  <title>Fashion EC site</title>
</head>

<body>

  <?php include('./Navbar/Navabar.php'); ?>

  <div id="content">
    <div class="titleArea">
      <h3>カート</h3>
    </div>
    <!-- メッセージ表示 -->
    <p class="message"><?= $result["message"] ?></p>

    <div class="cart-table">
      <?php if(isset($result["result"])) :?>
        <table border>
        <!-- 購入商品内容 -->
        <thead class="thead">
          <tr class="table_one">
            <th colspan="6">ご注文内容(<?= $count ?>)</th>
            <!-- <th ></th> -->
          </tr>
          <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
            <th>小計</th>
            <th>削除</th>
          </tr>
        </thead>
        
        <tbody>
          <?php foreach($result["result"] as $info) :?>
            <tr>
              <td class="p1"><img src="../assets/images/product/<?= $info["IMAGES"];?>.jpg" width:150px></td>
              <td>　<?= $info["PNAME"] ?>　</td>
              <td>　￥<?= $info["PRICE"] ?>　</td>
              <td>　1　</td>
              <td>　￥<?= $info["PRICE"] ?>　</td>
              <td>　<a href="Cart.php?exec=cancel&product_id=<?= $info["PRODUCT_ID"]?>"><i class="fa-solid fa-xmark"></i></a>　</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <!-- 購入商品内容 -->

        <!-- 購入商品金額 -->
        <tfoot class="tfoot">
          <tr>
            <th colspan="6" class="pricetext">商品金額合計</th>
          </tr>
          <tr>
            <td class="doll">￥<?= $sum ?></td>
            <td  colspan="5" class="pay-btn"><button type="submit">注文手続きへ</button></td>
          </tr>
        </tfoot>
        <!-- 購入商品金額 -->
      </table>  
      <?php endif?>
    </div>  
  </div>

  <?php include('./Navbar/Footer.php'); ?>

  <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>