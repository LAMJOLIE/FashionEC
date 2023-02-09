    <!-- Navbar starts -->
    <!-- pppp -->

    <nav id="header" class="navbar">
        <span class="open-slide">
            <a href="#" onclick="openSideMenu()">
                <svg width="30" height="30">
                    <path d="M0,5 30,5" stroke="#000" stroke-width="5" />
                    <path d="M0,14 30,14" stroke="#000" stroke-width="5" />
                    <path d="M0,23 30,23" stroke="#000" stroke-width="5" />
                </svg>
            </a>
        </span>

        
        <a href="./Index.php">
            <img src="../assets/images/logo4.png" class="logo" alt="">
        </a>


        <ul class="navbar-nav">
            <li><a href="./Login.php"><span class="fa-solid fa-user"></span></a></li>
            <li><a href="#" onclick="togglePopUp()"><span class="fa-solid fa-magnifying-glass"></span></a></li>
            <li><a href="./Favorite.php"><span class="fa-sharp fa-solid fa-heart-circle-plus"></span></a></li>
            <li><a href="./Cart.php"><span class="fa-solid fa-cart-shopping"></span></a></li>
        </ul>
    </nav>

    <!-- <div class="menu-bar">
        <ul>
            <li>
                <a href="Index.php">HOME</a>
            </li>

            <li>
                <a href="#">WOMEN</a>
            </li>

            <li>
                <a href="#">MEN</a>
            </li>

            <li><a href="#">ITEMS</a></li>
            <li><a href="Contact.php">CONTACT</a></li>
        </ul>
    </div> -->

    <!-- Catergory Bar starts -->
    <div class="category__wrap">
        <ul class="category__lists">

            <li class="category__list">
                <a href="./Index.php">HOME</a>
            </li>

            <li class="category__list">
                <a href="../src/Man.php">MAN</a>
                <ul class="dropdown_lists">
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M1">トップス</a>
                    </li>
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M2">ジャケット/アウター</a>
                    </li>
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M3">パンツ</a>
                    </li>
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M4">オールインワン</a>
                    </li>
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M5">スーツ</a>
                    </li>
                    <li class="dropdown_list">
                        <a href="../src/Man.php?category_id=M6">シューズ</a>
                    </li>
                </ul>

            </li>
            <li class="category__list">
                <a href="../src/Woman.php">WOMAN</a>
                <ul class="dropdown_lists">

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W1">トップス</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W2">ジャケット/アウター</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W3">ワンピース</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W4">パンツ</a>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W5">オールインワン</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W6">スーツ</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Woman.php?category_id=W7">シューズ</a>
                    </li>
                </ul>
            </li>
            <li class="category__list">
                <a href="../src/Item.php">ITEMS</a>
                <ul class="dropdown_lists">

                    <li class="dropdown_list">
                        <a href="../src/Item.php?category_id=I1">アクセサリー</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Item.php?category_id=I2">ヘアアクセサリー</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Item.php?category_id=I3">帽子</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Item.php?category_id=I4">バッグ</a>
                    </li>

                    <li class="dropdown_list">
                        <a href="../src/Item.php?category_id=I5">財布</a>
                    </li>
                </ul>
            </li>

            <li class="category__list">
                <a href="./Contact.php">CONTACT</a>
            </li>

        </ul>
    </div>
    <!-- Catergory Bar ends-->


    <!-- Side Menu starts -->
    <div id="side-menu" class="side-nav">
        <a href="#" class="btn-close" onclick="closeSideMenu()">&times;</a>
        <a href="./index.php">HOME</a>
        <a href="./Woman.php">WOMEN</a>
        <a href="./Man.php">MEN</a>
        <a href="./Item.php">ITEMS</a>
        <a href="./About.php">ABOUT</a>
        <a href="./Contact.php">CONTACT</a>
    </div>
    <!-- Side Menu ends -->

    <!-- Search overlap page starts -->
    <div id="fullsearch" class="full-screen hidden flex-container-center">
        <a href="#" class="searchbtn-close" onclick="togglePopUp()">&times;</a>
        <div class="searchTitle">
            <h2></h2>Please Enter To Search</h2>
        </div>
        <form id="searchBarForm" name action="Search.php" method="get" target="_self" enctype="">
            <input id="search-Keyword" type="text" name="search-Keyword" value="" type="hidden" placeholder="Enter search term" required>
            <button type="submit" value="Send" class="search-send-button">Search</button>
        </form>
    </div>
    <!-- Search overlap page ends -->


    <!-- Navbar starts -->