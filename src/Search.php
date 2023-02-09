<?php

$price1 = filter_input(INPUT_GET, "search-price1", FILTER_VALIDATE_INT);
$price2 = filter_input(INPUT_GET, "search-price2", FILTER_VALIDATE_INT);
$keyword = filter_input(INPUT_GET, "search-keyword");

if (!isset($keyword)) {
    $keyword = filter_input(INPUT_GET, "keyword");
}


// TODO:debug
// echo "price1 = {$price1}<br>";
// echo "price2 = {$price2}<br>";
// echo "keyword = {$keyword}<br>";

//DB接続
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("Location: Search.php");
    exit();
}
$result = [
    "status"  => true, //エラーがあった場合  false
    "message" => "", //表示するメッセージ
    "result"  => null, //更新結果(件数)
];

$keyword = str_replace("　", "", $keyword);
$keyword = str_replace(" ", "", $keyword);
// var_dump($keyword);
// if(!$keyword){
//     $result["status"] = false;
//     $result["message"] = $result["message"]."検索結果が見つかりません<br>検索キーワードが正確に入力されているかご確認の上、サイド検索してみてください。<br>";
// }
if ($result["status"] == true) {
    try {
        $db = new PDO($dsn, "se_c_root", "29_Man");

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql = "SELECT * FROM PRODUCT";
        $where = " WHERE 1=1";
        $pricewhere = "";
        $keywordwhere = "";

        if ($price1) {
            if ($price2) {
                $pricewhere = " AND price BETWEEN :price1 AND :price2"; //price both
            } else {
                $pricewhere = " AND price >= :price1"; //only price1
            }
        } else if ($price2) {
            $pricewhere = " AND price <= :price2"; //only price2
        }

        if ($keyword) {
            $keyWhere = '%' . $keyword . '%';
            $keywordwhere = ' AND pname LIKE :keyword'; // only keyword
            // if($pricewhere) {
            //     $pricewhere .= " AND".$pricewhere; //key + price
            //   }
        }
        $where .= $keywordwhere;
        $where .= $pricewhere;

        // prepare : セット
        // echo $sql.$where;
        $stmt = $db->prepare($sql . $where);

        if ($keyword) {
            $stmt->bindParam(":keyword", $keyWhere, PDO::PARAM_STR);
        }
        if ($price1) {
            $stmt->bindParam(":price1", $price1, PDO::PARAM_INT);
        }
        if ($price2) {
            $stmt->bindParam(":price2", $price2, PDO::PARAM_INT);
        }

        // TODO:debug
        // echo "SQL文:{$sql}{$where}";


        // execute : SQL の実行
        $stmt->execute();

        $result["result"] = [];
        // fetch:1列
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result["result"][] = $rows;
        }
        if (empty($result["result"])) {
            $result["message"] = $result["message"] . "検索結果が見つかりません<br>検索キーワードが正確に入力されているかご確認の上、サイド検索してみてください。<br>";
        }
    } catch (PDOException $poe) {
        exit("DBエラー" . $poe->getMessage());
    } finally {
        $stmt = null;
        $db  = null;
    }
}


/* SELECE * FROM product */
/* WHERE PNAME LIKE :keyword (キーワードあり)*/
/* WHERE PRICE BETWEEN :price1 AND MAX(price) (販売価格1　だけあり)*/
/* WHERE PRICE BETWEEN MIN(price) AND :price2 (販売価格2　だけあり)*/
/* WHERE PRICE BETWEEN :price1 AND :price2 (販売価格1、2ともあり)*/
/* msg 検索結果が見つかりません 検索キーワードが正確に入力されているかご確認の上、サイド検索してみてください。*/

?>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
    <link rel="stylesheet" href="../assets/css/Decorate.css">
    <link rel="stylesheet" href="../assets/css/Search.css">

    <title>Fashion EC site</title>
</head>

<body>

    <?php include('./Navbar/Navabar.php'); ?>

    <div id="content">
        <form action="Search.php" method="GET">

            <!-- 検索 -->
            <div class="titleArea">
                <h3>SEARCH</h3>
            </div>
            <div class="searchbox">
                <div class="search-price">
                    <span class="title">販売価格</span>
                    <span class="C">
                        <input id="search-price1" name="search-price1" fw-filter="isNumber" fw-label="最低販売価格" placeholder size="15" type="text">
                        ~
                        <input id="search-price2" name="search-price2" fw-filter="isNumber" fw-label="最高販売価格" placeholder size="15" type="text">
                    </span>
                </div>
                <div class="search-keyword">
                    <span class="title">キーワード</span>
                    <span class="C">
                        <input id="keyword" name="keyword" fw-filter="isNumber" fw-label="" placeholder size="15" type="text">
                    </span>
                </div>
                <button class="searchbtn" type="submit">[ SEARCH ]</button>
            </div>
        </form>
        <p class="message"><?= $result["message"] ?></p>
        <div id="product1" class="section-p1">
            <div class="pro-container">
                <?php if (isset($result["result"])) : ?>
                    <?php foreach ($result["result"] as $info) : ?>
                        <div class="pro">
                            <img src="../assets/images/product/<?= $info["IMAGES"]; ?>.jpg" alt="">
                            <!-- <h2><?= $info["PRODUCT_ID"] ?></h2> -->
                            <h5><?= $info["PNAME"] ?></h5>
                            <h4><?= $info["PRICE"] ?></h4>
                            <div class="item-icons">
                                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                                <a href="#"><i class="fa-sharp fa-solid fa-heart-circle-plus"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <?php include('./Navbar/Footer.php'); ?>

    <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>