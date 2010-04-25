<div class="form_recherche">
    <form name="recherche" action="" method="post">
        <input name="recherche_text" value="<?php echo $textRecherche ?>" />
        <select name="recherche_moteur">
            <option value="google">Google</option>
            <option value="yahoo">Yahoo</option>
            <option value="bing">Bing</option>
        </select>
        <input type="submit" name="recherche_submit" value="Rechercher" />
    </form>
</div>
<h2><?php echo $textRecherche ?></h2>
<div class="results">
    <?php foreach ($results as $result): ?>
    <div class="result">
        <h3><?php echo $result['title'] ?></h3>
        <?php echo $result['content'] ?>
    </div>
    <?php endforeach ?>
</div>