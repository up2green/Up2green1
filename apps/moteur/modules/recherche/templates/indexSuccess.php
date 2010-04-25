<div class="form_recherche">
    <form name="recherche" action="" method="post">
        <input type="hidden" id="hidden_text_search" value="<?php echo $textRecherche ?>" />
        <input type="hidden" id="hidden_moteur_search" value="<?php echo $moteur ?>" />
        <input name="recherche_text" value="<?php echo $textRecherche ?>" />
        <select name="recherche_moteur">
            <option value="<?php echo SearchEngine::GOOGLE ?>" <?php echo $moteur == SearchEngine::GOOGLE ? "SELECTED" : "" ?>>Google</option>
            <option value="<?php echo SearchEngine::YAHOO ?>" <?php echo $moteur == SearchEngine::YAHOO ? "SELECTED" : "" ?>>Yahoo</option>
            <option value="<?php echo SearchEngine::BING ?>" <?php echo $moteur == SearchEngine::BING ? "SELECTED" : "" ?>>Bing</option>
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
<?php if (sizeof($results) > 0): ?>
<div class="more_results">
    <input type="button" id="more_results" value="Afficher plus de résultats" />
</div>
<?php endif; ?>