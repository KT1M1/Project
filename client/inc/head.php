<button class="back-to-top" type="button"></button>

<div class="sticky">
    <div class="container">
        <header>
            <h1>
                <a class="brand" href="/">RecipeShare</a>
            </h1>
            
            <div class="input-group custom-search-group">
                <input type="text" class="search-field d-none d-lg-block" placeholder="Keresés..." />
                <button class="btn nav-btn search-icon" type="button">
                    <img class="img-icon" src="/client/assets/img/search.png" alt="">
                </button>
            </div>


            <div>
                <button class="btn nav-btn" type="button">
                    <a href="/page/profile">
                        <img class="img-icon" src="/client/assets/img/user.png" alt="">
                    </a>
                </button>
            </div>
            
            <button class="btn nav-btn navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <img class="img-icon" src="/client/assets/img/menu-burger.png" alt="">
            </button>
        </header>
    </div>

    <div class="nav-container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/page/upload_recipe">Recept feltöltése</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#popular">Most népszerű</a>
                    </li>
            <!--1. DROPDOWN-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Kategória
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#main-course">Főétel</a></li>
                    <li><a class="dropdown-item" href="#snack">Köztes étkezés</a></li>
                    <li><a class="dropdown-item" href="#dessert">Desszertek és sütik</a></li>
                    </ul>
                    </li>
            <!--2. DROPDOWN-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hozzávaló
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#ingredients">Hús ételek</a></li>
                            <li><a class="dropdown-item" href="#ingredients">Tenger gyümölcsei</a></li>
                            <li><a class="dropdown-item" href="#ingredients">Tészta ételek</a></li>
                            <li><a class="dropdown-item" href="#ingredients">Vegetáriánus vagy Vegán ételek</a></li>
                        </ul>
                    </li>
            <!--3. DROPDOWN-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Alkalom
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Karácsony</a></li>
                            <li><a class="dropdown-item" href="#">Húsvét</a></li>
                            <li><a class="dropdown-item" href="#">Szilveszter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#popular">Rólunk</a>
                    </li>
                </ul>

            </div>
            </div>
        </nav>
    </div>
</div>
