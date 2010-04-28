<div class="form_recherche">
    <form name="recherche" action="" method="post">
        <input type="hidden" id="hidden_text_search" value="<?php echo $textRecherche ?>" />
        <input type="hidden" id="hidden_moteur_search" value="<?php echo $moteur ?>" />
        <input name="recherche_text" value="<?php echo $textRecherche ?>" />
        <select name="recherche_moteur">
            <option value="<?php echo SearchEngine::WEB ?>" <?php echo ($moteur == SearchEngine::WEB ? "SELECTED" : "") ?>>Web</option>
            <option value="<?php echo SearchEngine::IMG ?>" <?php echo ($moteur == SearchEngine::IMG ? "SELECTED" : "") ?>>Images</option>
            <option value="<?php echo SearchEngine::NEWS ?>" <?php echo ($moteur == SearchEngine::NEWS ? "SELECTED" : "") ?>>Actualités</option>
        </select>
        <input type="submit" name="recherche_submit" value="Rechercher" />
    </form>
</div>
<h2><?php echo $textRecherche ?></h2>
<div class="results">
    <?php
    if ($moteur == SearchEngine::WEB):
        foreach ($results as $result):
            include_partial('recherche/web', array('result' => $result));
        endforeach;
    elseif ($moteur == SearchEngine::IMG):
        foreach ($results as $result):
            include_partial('recherche/img', array('result' => $result));
        endforeach;
        elseif ($moteur == SearchEngine::NEWS):
        foreach ($results as $result):
            include_partial('recherche/new', array('result' => $result));
        endforeach;
    endif;
    ?>

</div>
<?php if (sizeof($results) > 0): ?>
<div class="more_results">
    <input type="button" id="more_results" value="Afficher plus de résultats" />
</div>
<?php endif; ?>