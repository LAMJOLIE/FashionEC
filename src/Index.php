<?php

//DB接続
$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("Location: Search.php");
    exit();
}
$result = [
    "status"  => true, //エラーがあった場合  false
    "message" => null, //表示するメッセージ
    "result"  => null, //更新結果(件数)
];


if ($result["status"] == true) {
    try {
        $db = new PDO($dsn, "se_c_root", "29_Man");

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql = "SELECT * FROM PRODUCT";
        $where = "";


        // prepare : セット
        $stmt = $db->prepare($sql . $where);

        // TODO:debug
        // echo "SQL文:{$sql}{$where}";
        // execute : SQL の実行
        $stmt->execute();

        $result = [];
        // fetch:1列
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $rows;
        }

        $indexes = array_rand($result,4);


    } catch (PDOException $poe) {
        exit("DBエラー" . $poe->getMessage());
    } finally {
        $stmt = null;
        $db  = null;
    }
}

// var_dump ($result);
// foreach ($result as $value) {
//     var_dump($value["PRODUCT_ID"]);
// }

?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
    <link rel="stylesheet" href="../assets/css/Decorate.css">
    <link rel="stylesheet" href="../assets/css/Index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

    <title>Fashion EC site</title>
</head>

<body>

    <?php include('./Navbar/Navabar.php'); ?>

    <section id="content">
    <div class="container">
            <!-- Slider main container -->
            <div class="swiper">

                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><img src="../assets/images/winter1.jpg"></div>
                    <div class="swiper-slide"><img src="../assets/images/winter2.jpg"></div>
                    <div class="swiper-slide"><img src="../assets/images/winter3.jpg"></div>

                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
        </div>
        <div class="product-t">
            <h2>RECOMMEDATION</h2>
            <p>Collection New Morden Design</p>
        </div>

        <div id="product1" class="section-p1">

            <div class="pro-container">
            <?php foreach ($indexes as $index) : ?>
                    <div class="pro">
                        <img src="../assets/images/product/<?= $result[$index]["IMAGES"];?>.jpg" alt="">

                        <div class="des">
                            
                            <h5><?= $result[$index]["PNAME"]; ?></h5>
                            <h4><?php echo "¥".number_format($result[$index]["PRICE"]); ?></h4>
                                <div class="item-icons">
                                    <a href="Cart.php?pagename=Index&product_id=<?= $result[$index]["PRODUCT_ID"] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                                    <a href="Favorite.php?pagename=Index&product_id=<?= $result[$index]["PRODUCT_ID"] ?>"><i class="fa-sharp fa-solid fa-heart-circle-plus"></i></a>
                                    
                                </div>
                        </div>
                    </div>
            <?php endforeach ?>
            </div>

        </div>
    </section>



    <?php include('./Navbar/Footer.php'); ?>
    
    <script src="https://kit.fontawesome.com/4d6369389a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>