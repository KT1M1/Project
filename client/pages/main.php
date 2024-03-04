<?php
require_once("./server/show.php");
require_once("./server/main.php");

$populars = get_populars();

// Fetch the recipe data for recipes with IDs 13, 14, and 15
$recipe_data_13 = get_recipe_by_id(13)[0];
$recipe_data_14 = get_recipe_by_id(14)[0];
$recipe_data_15 = get_recipe_by_id(15)[0];
?>


<div class="banner-container">
    <img class="banner-img" src="./client/assets/img/banner1.jpg">
    <div class="text-overlay">
        <h2 class="banner-txt">Oszd meg az örömöt, ízleld meg a közösség erejét.</h2>
    </div>
</div>

<!--Most Popular-->
<div class="container">
    <div class="container-fluid popular-text">
        <div class="divider-container">
            <h2 class="divider myanchor" id="popular">LEGKEDVELTEBB RECEPTEK</h2>
            <hr>
        </div>

        <div class="introduct-text">
            <p>Itt a közösség ízlése és preferenciái határozzák meg, hogy melyik étel marad a dobogón. <br> Ez egy
                dinamikus és folyamatosan változó értékelési rendszer, amely nem korlátozódik az ételek összetevőire
                vagy elkészítésére.</p>
        </div>
    </div>

    

    <div class="row popular">

        <?php
        $counter = 1;
        foreach($populars as $popular) {
        ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="page/show_recipe/<?php echo $popular['id']; ?>">
                    <div class="card-div">
                        <div class="rank-cube">#<?php echo $counter; ?></div>
                        <div class="card-top">
                            <img class="card-pic" src="/uploads/imgs/<?php echo $popular['img_url']; ?>">
                        </div>
                        <div class="card-bottom">
                            <div class="card-text">
                                <p>
                                    <?php echo $popular['name']; ?>
                                </p>
                            </div>
                            <div class="card-rate">
                                <img class="img-fluid card-heart" src="./client/assets/img/heart.png">
                                <p class="card-heart"><?php echo $popular['likes']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php
            $counter++;
        }
        ?>
    </div>
</div>

<!--Search By Ingredient-->
<div class="container ing-nav-container">
    <h2 class="ing-title myanchor" id="ingredients">Keress alkalom alapján:</h2>
    <div class="ing-icon-container">
        <div class="ing-nav-piece">
            <a href="/page/search&occasion=29" class="rotate">
                <img class="img-fluid ing-icon rotate-image" src="./client/assets/img/occasion/xmas.jpg">
                <p class="ing-piece-txt">Karácsony</p>
            </a>
        </div>
        <div class="ing-icon-piece">
            <a href="/page/search&occasion=30" class="rotate">
                <img class="img-fluid ing-icon rotate-image" src="./client/assets/img/occasion/easter.png">
                <p class="ing-piece-txt">Húsvét</p>
            </a>
        </div>
        <div class="ing-icon-piece">
            <a href="/page/search&occasion=31" class="rotate">
                <img class="img-fluid ing-icon rotate-image" src="./client/assets/img/occasion/newy.jpg">
                <p class="ing-piece-txt">Szilveszter</p>
            </a>
        </div>
        <div class="ing-icon-piece">
            <a href="/page/search&occasion=54" class="rotate">
                <img class="img-fluid ing-icon rotate-image" src="./client/assets/img/occasion/bda.jpg">
                <p class="ing-piece-txt">Születésnap</p>
            </a>
        </div>
    </div>
</div>


<!--Main Course-->
<div class="container">
    <div class="container-fluid">
        <div class="divider-container">
            <h2 class="divider-left myanchor" id="main-course">Főétel</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="course-container">
                <p class="course-text"> &emsp; A főétel jellemzően a leglaktatóbb fogás, amely az <span
                        class="highlight-text"> ebédet vagy a vacsorát </span> alkotja, és az étkezés középpontjában
                    áll. <br> &emsp; Ezen ételkategória rendkívül változatos, és számos kulturális, regionális és
                    személyes ízlési preferenciát tükröző variációval rendelkezik. <br> &emsp; Leggyakrabban <span
                        class="highlight-text"> húsok, halak</span> vagy más fehérjeforrások alkotják a főételt, de
                    vegetáriánus vagy vegán ételek esetében is számos izgalmas lehetőség áll rendelkezésre.</p>
            </div>
            <div class="category-btn">
                <a href="/page/search&category=4">
                    <button type="button" class="btn ctg-button">Ismerd meg a kategória további fogásait!</button>
                </a>
            </div>
        </div>
        <!--IMG-->
        <div class="col-12 col-md-6">
            <a href="page/show_recipe/<?php echo $recipe_data_13['id']; ?>">
                <div class="card-div">
                    <div class="card-top">
                        <img class="card-pic" src="/uploads/imgs/<?php echo $recipe_data_13['img_url']; ?>">
                    </div>
                    <div class="card-bottom">
                        <div class="card-text">
                            <p>
                                <?php echo $recipe_data_13['name']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!--Snack-->
<div class="container">
    <div class="container-fluid">
        <div class="divider-container">
            <h2 class="divider-left myanchor" id="snack">Köztes étkezés</h2>
            <hr>
        </div>
    </div>
    <div class="row snack">
        <div class="col-12 col-md-6">
            <div class="course-container">
                <p class="course-text"> &emsp; A köztes étkezések kategóriájába tartozó receptek rendkívül változatosak
                    és izgalmasak lehetnek, hiszen kielégítik az éhségünket a főétkezések között, miközben finom és
                    tápláló ételeket kínálnak. <br> &emsp; Ezek a könnyű és ízletes fogások ideálisak a nap bármely
                    szakaszában, legyen szó <span class="highlight-text"> reggeliről,</span> délutáni <span
                        class="highlight-text"> nasiról</span> vagy esti snackről.</p>
            </div>
            <div class="category-btn">
                <a href="/page/search&category=5">
                    <button type="button" class="btn ctg-button">Ismerd meg a kategória további fogásait!</button>
                </a>
            </div>
        </div>
        <!--IMG-->
        <div class="col-12 col-md-6">
            <a href="page/show_recipe/<?php echo $recipe_data_15['id']; ?>">
                <div class="card-div">
                    <div class="card-top">
                        <img class="img-fluid card-pic" src="/uploads/imgs/<?php echo $recipe_data_15['img_url']; ?>">
                    </div>
                    <div class="card-bottom">
                        <div class="card-text">
                            <p>
                                <?php echo $recipe_data_15['name']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!--Dessert-->
<div class="container">
    <div class="container-fluid">
        <div class="divider-container">
            <h2 class="divider-left myanchor" id="dessert">Desszertek és sütik</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="course-container">
                <p class="course-text"> &emsp; A desszertek kategóriájába tartozó receptek számtalan lehetőséget
                    kínálnak az <span class="highlight-text">édes</span> élvezetek világában. <br> &emsp; Ezek az ételek
                    nem csupán egyszerűen kielégítik az édesszájúak vágyait, hanem igazi művészi alkotások is lehetnek.
                    <br> &emsp; A különféle <span class="highlight-text">sütemények, torták, fagylaltok</span> és egyéb
                    édes finomságok minden alkalomra megtalálhatók, és segítenek megkoronázni az étkezést egy kellemes
                    és édes lezárással.
                </p>
            </div>
            <div class="category-btn">
                <a href="/page/search&category=7">
                    <button type="button" class="btn ctg-button">Ismerd meg a kategória további fogásait!</button>
                </a>
            </div>
        </div>
        <!--IMG-->
        <div class="col-12 col-md-6">
            <a href="page/show_recipe/<?php echo $recipe_data_14['id']; ?>">
                <div class="card-div">
                    <div class="card-top">
                        <img class="card-pic" src="/uploads/imgs/<?php echo $recipe_data_14['img_url']; ?>">
                    </div>
                    <div class="card-bottom">
                        <div class="card-text">
                            <p>
                                <?php echo $recipe_data_14['name']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>