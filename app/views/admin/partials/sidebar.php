<aside class="col-lg-2 bg-dark text-light p-3">
    <h2 class="h5">CMS</h2>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=dashboard'); ?>">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=notices'); ?>">Notices</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=downloads'); ?>">Downloads</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=services'); ?>">Services</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=employees'); ?>">Employees</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=gallery'); ?>">Gallery</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=settings'); ?>">Settings</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="<?= url('admin/index.php?page=publications'); ?>">Publications</a></li>
        <li class="nav-item">
            <form method="POST" action="<?= url('admin/index.php?page=logout'); ?>" class="m-0">
                <?= csrf_input(); ?>
                <button type="submit" class="nav-link text-warning btn btn-link p-0">Logout</button>
            </form>
        </li>
    </ul>
</aside>
