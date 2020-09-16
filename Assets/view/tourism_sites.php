<?php $sites = DAL::getDALT("tourism_sites"); ?>
<div class="container">
    <h1>Sites available</h1>
    <div class="row">
        <?php foreach($sites as $site) { ?>
            <div class="site_container col-md-6">
            <h2><?= $site['name'] ?></h2>
            <img src="<?= SELF_DIR."Assets/Images/".$site['image'] ?>" alt="">
            <p><?= $site['description'] ?> </p>
        </div>
        <?php } ?>
    </div>
</div>