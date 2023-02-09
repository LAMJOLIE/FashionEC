<?php
/*
session_start();
$user_id = $_SESSION["user_id"];
*/
$user_id = "0000";
// 送られてきた値を受け取る変数
//$user_id = filter_input(INPUT_POST, "user_id");

//$_GET["user_id"];
$product_id = filter_input(INPUT_GET, "product_id");
$pagename = filter_input(INPUT_GET, "pagename");

if (isset($product_id)) {
    echo $product_id;
    //消去するデータを用意

    $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

    try {
        $db = new PDO($dsn, "se_c_root", "29_Man");

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $db -> beginTransaction();

        $stmt = $db->prepare("DELETE FROM FAVORITE WHERE user_id =:user_id and product_id = :product_id");

        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->execute();

        $db -> commit();
    } catch (PDOException $poe) {
        exit("DBエラー" . $poe->getMessage());
        $db -> rollBack();
    } finally {
        $stmt = null;
        $db  = null;
        if(isset($pagename)){
            header("Location: {$pagename}.php");
        }else{
            header("Location: Favorite.php");
        }
    }
}








//DB接続
// 開発環境
// $dsn = "mysql:host=localhost;dbname=studb;charset=utf8mb4";



// 本番環境
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

$result = [
    "status"  => true, //エラーがあった場合  false
    "message" => null, //表示するメッセージ
    "result"  => null, //更新結果(件数)
];

$user_id = "0000";
// $row=[
//     "USER_ID" => "0000",
// ];

if ($result["status"] == true) {
    try {
        // 開発環境
        // $db = new PDO($dsn, "dbuser", "ecc");

        // 本番環境
        $db = new PDO($dsn, "se_c_root", "29_Man");

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql = "SELECT *
                FROM FAVORITE F
                JOIN PRODUCT P
                ON F.product_id = P.product_id";
        $where = " WHERE 1=1";

        // prepare : セット
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        // TODO:debug
        echo "SQL文:{$sql}";
        // execute : SQL の実行
        $stmt->execute();

        $result["result"] = [];
        // fetch:1列
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result["result"][] = $rows;
        }
    } catch (PDOException $poe) {
        exit("DBエラー" . $poe->getMessage());
    } finally {
        $stmt = null;
        $db  = null;
    }
}




?>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
    <link rel="stylesheet" href="../assets/css/Decorate.css">
    <link rel="stylesheet" href="../assets/css/favorite.css">
    <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
    <title>Fashion EC site</title>
</head>

<body>
    <form action="Favorite.php" method="GET">
        <?php include('./Navbar/Navabar.php'); ?>

        <div id="content">
            <!--<img src="../assets/images/ZARA-STUDIO-FW22-02.jpg" class="frontpic" alt="">-->
            <div class="container">
                <div id="product1" class="section-p1">
                    <div class="pro-container">
                        <?php if (isset($result["result"])) : ?>
                            <?php foreach ($result["result"] as $info) : ?>
                                <div class="pro">
                                    <img src="../assets/images/product/<?= $info["IMAGES"]; ?>.jpg" alt="">
                                    <h5><?= $info["PNAME"] ?></h5>
                                    <h4><?= $info["PRICE"] ?></h4>
                                    <div class="item-icons">
                                        <a href="Item.php"><i class="fa-solid fa-cart-shopping"></i></a>
                                        <a href="Favorite.php?pagename=Item&product_id=<?= $info["PRODUCT_ID"] ?>"><i class="fa-solid fa-heart-circle-minus"></i></a>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <!-- Content Ends-->

        </div>

        <?php include('./Navbar/Footer.php'); ?>

        <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
        <script src="../assets/js/script.js"></script>
    </form>
</body>

</html>