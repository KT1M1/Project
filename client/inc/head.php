<button class="back-to-top" type="button"></button>

<div class="sticky">
    <div class="container">
        <header>
            <h1>
                <a class="brand" href="/">Flavora</a>
            </h1>

            <div>
                <button class="btn nav-btn search-icon" type="button">
                    <a href="/page/search">
                        <img class="img-icon" src="/client/assets/img/search.png" alt="Search">
                    </a>
                </button>
            </div>

            <div id="profile">
                <!-- The button will be inserted here by JavaScript -->
            </div>

            <button class="btn nav-btn navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Elkészítés
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#ingredients">Könnyű</a></li>
                                <li><a class="dropdown-item" href="#ingredients">Közepes</a></li>
                                <li><a class="dropdown-item" href="#ingredients">Nehéz</a></li>
                            </ul>
                        </li>
                        <!--3. DROPDOWN-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Alkalom
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Karácsony</a></li>
                                <li><a class="dropdown-item" href="#">Húsvét</a></li>
                                <li><a class="dropdown-item" href="#">Szilveszter</a></li>
                                <li><a class="dropdown-item" href="#">Születésnap</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var profile = document.getElementById("profile");
        var currentPath = window.location.pathname;

        // Check if we're on the profile page
        if (currentPath === "/page/profile") {
            // If yes, show the Logout button
            profile.innerHTML = `<a href="/logout" class="btn nav-btn">
                                            <img class="img-icon" src="/client/assets/img/signout.png" alt="Logout">
                                        </a>`;
        } else {
            // If not, show the Profile button
            profile.innerHTML = `<a href="/page/profile" class="btn nav-btn">
                                            <img class="img-icon" src="/client/assets/img/user.png" alt="Profile">
                                        </a>`;
        }
    });

</script>