<?php

require_once "./def.php";

$submit = filter_input(INPUT_POST, "submit");

// 送られてきた情報管理配列
$result = [
    "status" => true,
    "errMsg" => "",
    "Flag" => 0
];

// どちらの情報が送られていてるのかを判定
if (isset($submit)) {
    $submit == "SignIn" ? $result["Flag"] = "1" : $result["Flag"] = "2";
}

// 共通処理をまとめたクラスのインスタンスを生成
$common = new Common();
$userInfo = [];
if (isset($submit)) {
    // サインイン
    if ($result["Flag"] == "1") {
        // 配列にデータを追加
        $userInfo["user"] = filter_input(INPUT_POST, "user");
        $userInfo["pass"] = filter_input(INPUT_POST, "pass");

        // 空白を削除
        $userInfo = $common->DataTrim($userInfo);

        /*
        * 値チェック
        */
        // 空白か
        if (empty($userInfo["user"])) {
            $result["errMsg"] = $result["errMsg"] . "USERNAMEを入力してください<br>";
            $result["status"] = false;
        }
        if (empty($userInfo["pass"])) {
            $result["errMsg"] = $result["errMsg"] . "PASSWORDを入力してください<br>";
            $result["status"] = false;
        }
        // 値が正しいか
        try {
            // データソース名を設定
            $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

            // $dbにPDOのインスタンス生成
            $db = new PDO($dsn, DB_USER, DB_PASS);

            //　PODの動作オプションを指定
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);                 // ステートメントのエミュレーションをオフ
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         // エラーを表示する
            $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);    // 空文字をnullに変換
            $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);                   // 小文字を大文字に変換
            $db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);                       // autocommitをオフ

            // USERNAMEとPASSWORDが合っているか
            if ($result["status"]) {
                $sql = "select user_id, count(UNAME), PASSWORD
                        from USERINFO
                        where UNAME = :UNAME;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':UNAME', $userInfo["user"], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row["COUNT(UNAME)"] == 0) {
                    $result["status"] = false;
                    $result["errMsg"] = $result["errMsg"] . "USERNAMEが間違っています<br>";
                }
                if ($row["PASSWORD"] != $userInfo["pass"]) {
                    $result["status"] = false;
                    $result["errMsg"] = $result["errMsg"] . "PASSWORDが間違っています<br>";
                }
            }
            // ユーザー情報が合っていた場合
            if ($result["status"]) {
                session_start();
                $_SESSION["USER_ID"] = $row["USER_ID"];
                header("Location: ./Index.php");
            }
        } catch (PDOException $exception) { // エラーキャッチ
            echo $exception;
        } finally {                         // db情報の破棄
            $db = null;
            $stmt = null;
        }
    }
    // サインアップ
    if ($result["Flag"] == "2") {
        // 配列にデータを追加
        $userInfo["user"] = filter_input(INPUT_POST, "user");
        $userInfo["pass"] = filter_input(INPUT_POST, "pass");
        $userInfo["repeatPass"] = filter_input(INPUT_POST, "repeatPass");

        // 空白を削除
        $userInfo = $common->DataTrim($userInfo);

        /*
        * 値チェック
        */
        // 空白か
        if (empty($userInfo["user"])) {
            $result["errMsg"] = $result["errMsg"] . "USERNAMEを入力してください<br>";
            $result["status"] = false;
        }
        if (empty($userInfo["pass"])) {
            $result["errMsg"] = $result["errMsg"] . "PASSWORDを入力してください<br>";
            $result["status"] = false;
        }
        if (empty($userInfo["repeatPass"])) {
            $result["errMsg"] = $result["errMsg"] . "REPEATPASSWORDを入力してください<br>";
            $result["status"] = false;
        }
        // 値が正しいか
        // REPEATPASSWORDがPASSWORDと同じか判定
        if ($userInfo["pass"] !== $userInfo["repeatPass"]) {
            $result["status"] = false;
            $result["errMsg"] = $result["errMsg"] . "REPEATPASSWORDが違います";
        }
        try {
            // このpasswordは使えるか
            if ($result["status"]) {
                // データソース名を設定
                $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

                // $dbにPDOのインスタンス生成
                $db = new PDO($dsn, DB_USER, DB_PASS);

                //　PODの動作オプションを指定
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);                 // ステートメントのエミュレーションをオフ
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         // エラーを表示する
                $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);    // 空文字をnullに変換
                $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);                   // 小文字を大文字に変換
                $db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);                       // autocommitをオフ

                $sql = "select count(PASSWORD)
                        from USERINFO
                        where PASSWORD = :PASSWORD;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':PASSWORD', $userInfo["pass"], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row["COUNT(PASSWORD)"] == 1) {    // パスワード判定
                    $result["status"] = false;
                    $result["errMsg"] = $result["errMsg"] . "このパスワードは使えません<br>";
                }
                $db = null;
                $stmt = null;
            }

            // ユーザー情報を登録してIndex.phpに遷移
            if ($result["status"]) {
                // データソース名を設定
                $dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

                // $dbにPDOのインスタンス生成
                $db = new PDO($dsn, DB_USER, DB_PASS);

                //　PODの動作オプションを指定
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);                 // ステートメントのエミュレーションをオフ
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         // エラーを表示する
                $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);    // 空文字をnullに変換
                $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);                   // 小文字を大文字に変換
                $db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);                       // autocommitをオフ

                // トランザクション開始
                $db->beginTransaction();

                // ユーザー情報をDBに追加
                $sql = "insert into USERINFO
                        select LPAD(max(USER_ID) + 1,'4','0'),:USER,:PASSWORD
                        from USERINFO";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':PASSWORD', $userInfo["pass"], PDO::PARAM_STR);
                $stmt->bindParam(':USER', $userInfo["user"], PDO::PARAM_STR);

                $stmt->execute();

                $db->commit();

                session_start();
                $_SESSION["USER_ID"] = $userInfo["user"];
                header("Location: ./Index.php");
            }
        } catch (PDOException $exception) { // エラーキャッチ
            echo $exception;
            $db->rollBack();
        } finally {                         // db情報の破棄
            $db = null;
            $stmt = null;
        }
    }
}

// 共通した処理をまとめたクラス
class Common
{
    function DataTrim($userInfo)        // データの空白を消す処理
    {
        foreach ($userInfo as &$data) {
            $data = str_replace(" ", "", $data);
        }
        return $userInfo;
    }
    function isEmpty($userInfo)
    {
        if (empty($userInfo)) {
            return false;
        }
    }
}
?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
    <link rel="stylesheet" href="../assets/css/Login.css">

    <title>SignIn or SignUp</title>
</head>

<body>
    <div class="login-wrap">
        <div class="login-html">
            <!-- ▼select SignIn or SignUp▼ -->
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">SignIn</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">SignUp</label>
            <!-- ▲select SignIn or SignUp▲ -->
            <div class="login-form">
                <div class="sign-in-htm"> <!-- ▼sign-in-htm▼ -->
                    <form action="./Login.php" method="POST">
                        <div class="group"> <!-- ユーザーネーム -->
                            <label for="user" class="label">Username</label>
                            <input id="user" type="text" class="input" name="user">
                        </div>
                        <div class="group"> <!-- パスワード -->
                            <label for="pass" class="label">Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="pass">
                        </div>
                        <div class="group"> <!-- 送信 -->
                            <input type="submit" class="button" value="SignIn" name="submit">
                        </div>
                        <div class="hr"></div>
                        <!-- エラーがある場合はここに表示する -->
                        <?= $result["errMsg"]; ?>
                    </form>
                </div> <!-- ▲sign-in-htm▲ -->
                <div class="sign-up-htm">
                    <form action="./Login.php" method="POST">
                        <div class="group"> <!-- ユーザーネーム -->
                            <label for="user" class="label">Username</label>
                            <input id="user" type="text" class="input" name="user">
                        </div>
                        <div class="group"> <!-- パスワード -->
                            <label for="pass" class="label">Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="pass">
                        </div>
                        <div class="group"> <!-- パスワード確認用 -->
                            <label for="pass" class="label">Repeat Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="repeatPass">
                        </div>
                        <div class="group"> <!-- 送信 -->
                            <input type="submit" class="button" value="SignUp" name="submit">
                        </div>
                        <div class="hr"></div>
                        <!-- エラーがある場合はここに表示する -->
                    </form>
                </div> <!-- ▲sign-up-htm▲ -->
            </div> <!-- ▲▲sign-in-htm▲▲ -->
        </div> <!-- ▲▲▲login-html▲▲▲ -->
    </div> <!-- ▲▲▲▲login-wrap▲▲▲▲ -->
</body>

</html>