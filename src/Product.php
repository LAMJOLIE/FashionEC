<?php

// session_start();
// $user_id = $_SESSION["user_id"];


$product_id = filter_input(INPUT_GET, "product_id"); //GETやPOSTが存在しなくてもエラーにならない product_idd
//DB接続
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

$result = [
    "status"  => true, //エラーがあった場合  false
    "message" => "", //表示するメッセージ
];

// Array ( [PRODUCT_ID] => 0015 [PNAME] => ヘアーアクセサリー [PRICE] => 790 [CATEGORY] => I2 [SIZE] => 2 [GENDER] => 2 [IMAGES] => I201 )
$row = [
    "PRODUCT_ID" => "0015",
    "PNAME" => "ヘアーアクセサリー",
    "PRICE" => "790",
    "CATEGORY" => "I2",
    "GENDER" => "2",
    "IMAGES" => "I201"
];
// try {
//     $db = new PDO($dsn, "se_c_root", "29_Man");

//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :PRODUCT_ID";

//     //セット
//     $stmt = $db->prepare($sql);

//     //バインドパラム
//     $stmt->bindParam(":PRODUCT_ID", $product_id, PDO::PARAM_INT);

//     //実行
//     $stmt->execute();

//     // fetch:1列
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);
//     print_r($row);
// } catch (PDOException $poe) {
//     exit("DBエラー" . $poe->getMessage());
// } finally {
//     $stmt = null;
//     $db  = null;
// }
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/Decorate.css">
    <link rel="stylesheet" href="../assets/css/Product.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <title>PRODUCT</title>
</head>

<body>
    <!-- Header starts-->
    <div class="header">
        <?php include('Navbar/Navabar.php'); ?>
    </div>
    <!-- Header ends-->

    <!-- Content starts-->
    <section id="content">
        <!-- 商品名　値段　買い物かごに追加　お気に入りアイコン-->
        <div id="product1" class="section-p1">
            <div class="pro-container">
                <?php if (isset($row["PRODUCT_ID"])) : ?>
                    <div class="pro">
                        <img src="../assets/images/product/<?= $row["IMAGES"]; ?>.jpg" alt="">
                        <!-- <h2><?= $row["PRODUCT_ID"] ?></h2> -->
                        <h5><?= $row["PNAME"] ?></h5>
                        <h4><?= $row["PRICE"] ?></h4>
                        <div class="item-icons">
                            <a href="favorite.php?product_id=<?php echo $info["PRODUCT_ID"] ?>"><span class="fa-sharp fa-solid fa-heart-circle-plus"></span></a></li>
                            <a href="#"><i class="cart-in">買い物かごに追加する</i></a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <!-- Content Ends-->

    <!-- Footer starts-->
    <div class="footer">
        <!-- SNSリンク -->
        < href="#"></a>
    </div>
    <!-- Footer end-->


    </div>
    <?php include('Navbar/Footer.php'); ?>

    <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>