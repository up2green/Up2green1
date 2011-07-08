<?php if($displayOrganismeActif) : ?>
<Style id="organisme_actif">
	<IconStyle>
		<Icon>
			<href><?php echo image_path('gmap/pointeur/icon-64x64-organisme-violet.gif', 'absolute=true'); ?></href>
		</Icon>
    </IconStyle>
</Style>
<?php endif; ?>
<?php if($displayOrganismeInactif) : ?>
<Style id="organisme_inactif">
	<IconStyle>
		<Icon>
			<href><?php echo image_path('gmap/pointeur/icon-64x64-organisme-gris.gif', 'absolute=true'); ?></href>
        </Icon>
    </IconStyle>
</Style>
<?php endif; ?>
<?php if($displayProgrammeActif) : ?>
<Style id="programme_actif">
    <IconStyle>
        <Icon>
            <href><?php echo image_path('gmap/pointeur/icon-64x64-plantation-vert.gif', 'absolute=true'); ?></href>
        </Icon>
    </IconStyle>
    <LineStyle>
        <color>40000000</color>
        <width>3</width>
    </LineStyle>
	<PolyStyle>
		<color>73ff0000</color>
    </PolyStyle>
</Style>
<?php endif; ?>
<?php if($displayProgrammeInactif) : ?>
<Style id="programme_inactif">
    <IconStyle>
        <Icon>
            <href><?php echo image_path('gmap/pointeur/icon-64x64-plantation-gris.gif', 'absolute=true'); ?></href>
        </Icon>
    </IconStyle>
    <LineStyle>
        <color>40000000</color>
        <width>3</width>
    </LineStyle>
    <PolyStyle>
        <color>73ff0000</color>
    </PolyStyle>
</Style>
<?php endif; ?>
<?php if($displayProgrammePartenaire) : ?>
<Style id="programme_partenaire">
    <IconStyle>
		<Icon>
			<href><?php echo image_path('gmap/pointeur/icon-64x64-plantation-violet.gif', 'absolute=true'); ?></href>
		</Icon>
    </IconStyle>
    <LineStyle>
		<color>40000000</color>
		<width>3</width>
    </LineStyle>
	<PolyStyle>
		<color>73ff0000</color>
	</PolyStyle>
</Style>
<?php endif; ?>
