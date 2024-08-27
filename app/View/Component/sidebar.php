<aside class="col-sm-2 p-0">
    <ul class="nav flex-column gap-2">
        <li class="nav-item d-flex align-items-center px-3 <?= preg_match("/^\/(overview).*/", $_SERVER["REQUEST_URI"]) ? "active" : "" ?>">
            <i class="bi bi-speedometer2"></i>
            <a class="nav-link text-reset" href="/overview">Dashboard</a>
        </li>

        <li class="nav-item d-flex align-items-center px-3 <?= preg_match("/^\/(peserta).*/", $_SERVER["REQUEST_URI"]) ? "active" : "" ?>">
            <i class="bi bi-people"></i>
            <a class="nav-link text-reset" href="/peserta">Peserta</a>
        </li>

        <?php if ($model["activeUser"]["role"] === "sup-admin") : ?>
            <li class="nav-item">
                <div class="px-3 <?= preg_match("/^\/(users|dusun).*/", $_SERVER["REQUEST_URI"]) ? "active" : "" ?>">
                    <span class="d-flex align-items-center">
                        <i class="bi bi-file-text"></i>
                        <span class="nav-link text-reset">Data</span>
                    </span>
                </div>
                <div class="px-3 bg-light">
                    <span class="d-flex flex-column px-3 py-0">
                        <a href="/dusun" class="nav-link text-reset">Dusun</a>
                        <a href="/users" class="nav-link text-reset">User</a>
                    </span>
                </div>
            </li>
        <?php endif; ?>

        <li class="nav-item d-flex align-items-center px-3">
            <i class="bi bi-door-open"></i>
            <a class="nav-link text-reset" href="/logout">Sign Out</a>
        </li>
    </ul>
</aside>