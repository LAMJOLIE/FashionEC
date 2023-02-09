<?php

//$user_id = filter_input(INPUT_GET, "user_id");
$category_id = filter_input(INPUT_GET, "category_id"); //GETやPOSTが存在しなくてもエラーにならない
//DB接続
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";
if( $_SERVER["REQUEST_METHOD"] !== "GET"){
  header("Location: #");
  exit();
}
$result = [
"status"  => true, //エラーがあった場合  false
"message" => "", //表示するメッセージ
"result"  => null, //更新結果(件数)
];


try {
  $db = new PDO($dsn, "se_c_root", "29_Man"); 
  //new PDO([接続先 DB 情報], [DB のログイン ID], [DB のパスワード])
  
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //プレースホルダ
  $sql = "SELECT * FROM PRODUCT"; //WHERE category = $category_id"; テーブル名の後には空白なし
  $where = "";
  
  // $category_Idが取れていたら
  if (isset($category_id)) {
    $where = " WHERE CATEGORY = :category_id";
  }else{
    $where = " WHERE CATEGORY LIKE 'I%'";
  }


  $stmt = $db -> prepare($sql.$where); 

  //バインドパラム
  $stmt -> bindParam(":category_id",$category_id,PDO::PARAM_STR);
  $stmt->execute(); //実行

  $result["result"] = [];
  while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) { //fetchは１レコードずつデータを取得していく PDO::FETCH_ASSOCはカラム名を連想配列として返す
    $result["result"][] = $rows;
  }
} catch (PDOException $error_message) {
  exit("DBエラー" . $error_message->getMessage());
}

$stmt = null;
$db = null; //データ破棄

?>

<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
  <link rel="stylesheet" href="../assets/css/Decorate.css">
  <link rel="stylesheet" href="../assets/css/Category.css">

  <title>Fashion EC site</title>
</head>

<body>


  <?php include('./Navbar/Navabar.php'); ?>


  <!-- todo 商品詳細ページにuser_idを送る -->
  <div id="product1" class="section-p1"></a>
    <div class="pro-container">
      <?php if(isset($result["result"])) : ?>
        <?php foreach($result["result"] as $info): ?>
          <div class="pro">
            <a href="Product.php?product_id=<?php echo $info["PRODUCT_ID"] ?>">
              <img src="../assets/images/product/<?= $info["IMAGES"];?>.jpg" alt="">
            </a>
            <!-- <h2><?= $info["PRODUCT_ID"] ?></h2> -->
            <h5><?= $info["PNAME"] ?></h5>
            <h4><?= $info["PRICE"] ?></h4>
            <a href="Cart.php?pagename=Item&product_id=<?= $info["PRODUCT_ID"] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
          </div>
          <?php endforeach; ?>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>  

  <?php include('./Navbar/Footer.php'); ?>

  <script src="../assets/js/Category_Search.js"></script>

  <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
</body>