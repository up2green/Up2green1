<div id="content">

    <h1><?php echo __("Ensemble, plantons 2 013 arbres sur la Planète !"); ?></h1>

    <div id="map">
        <?php foreach ($programs as $id => $program) : ?>
        <span id="program-<?php echo $id ?>" class="program label-<?php echo $program['label-position'] ?>">
            <span class="title"><?php echo $program['title']; ?></span>
            <span class="count">0</span>
        </span>
        <?php endforeach; ?>
	</div>

    <div id="footer">
        <img class="logo left" src="/images/instant-plantation/logo-malteurop.jpg" />
        <img class="logo middle" src="/images/instant-plantation/logo-up2green.png" />
        <img class="logo right" src="/images/instant-plantation/logo-dalkia.jpg" />

        <p class="left"><?php echo __("Ces programmes d’agroforesterie contribuent au développement économique et social des populations locales"); ?></p>
        <p class="right"><?php echo __("Et participent à la lutte contre le réchauffement climatique en stockant le CO2 pendant leur croissance"); ?></p>
    </div>

    <div id="controls">
        <?php foreach ($programs as $id => $program) : ?>
        <div class="control" data-program="<?php echo $id ?>">
            <span class="control add-10" data-number="10"></span>
            <span class="control add-1" data-number="1"></span>
            <span class="control sub-1" data-number="-1"></span>
            <span class="control sub-10" data-number="-10"></span>
            <span class="label">
                <?php echo $program['title']; ?>
            </span>
        </div>
        <?php endforeach; ?>
	</div>
</div>
