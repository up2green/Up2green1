<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2">
	<Document>
	<name>up2green</name>
	<description>Les différents sites de reforestations sur lesquels nous agissons</description>
	<Style id="organisme_actif">
		<IconStyle>
			<scale>1</scale>
			<Icon>
				<href><?php echo image_path('gmap/pointeur/organisme-actif.png', 'absolute=true'); ?></href>
			</Icon>
		</IconStyle>
	</Style>
	<Style id="organisme_inactif">
		<IconStyle>
			<scale>0.8</scale>
			<Icon>
				<href><?php echo image_path('gmap/pointeur/organisme-inactif.png', 'absolute=true'); ?></href>
			</Icon>
		</IconStyle>
	</Style>
	<Style id="programme_actif">
		<IconStyle>
			<scale>1</scale>
			<Icon>
				<href><?php echo image_path('gmap/pointeur/programme-actif.png', 'absolute=true'); ?></href>
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
	<Style id="programme_inactif">
		<IconStyle>
			<scale>0.8</scale>
			<Icon>
				<href><?php echo image_path('gmap/pointeur/programme-inactif.png', 'absolute=true'); ?></href>
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
	<Folder>
		<name><?php echo __("ONG et Organismes planteurs"); ?></name>
		<description>Les sièges sociaux des différents organismes planteurs qui soutiennent up2green reforestation.</description>
		<?php foreach($organismes as $organisme) : ?>
		<?php if($organisme->getPoint()->getOutput() != null) : ?>
		<Placemark id="gmap-organisme-<?php echo $organisme->getId(); ?>">
			<name><?php echo $organisme->getTitle(); ?></name>
			<description><![CDATA[<?php echo $organisme->getAccroche(); ?>]]></description>
			<styleUrl><?php echo $organisme->getIsActive() ? '#organisme_actif' : '#organisme_inactif' ?></styleUrl>
			<Point>
				<coordinates><?php echo $organisme->getPoint()->getOutput(); ?></coordinates>
			</Point>
		</Placemark>
		<?php endif; ?>
		<?php endforeach; ?>
	</Folder>
	<Folder>
		<name><?php echo __("Programmes de reforestation"); ?></name>
		<description>Les sites de reforestation.</description>
		<?php foreach($programmes as $programme) : ?>
		<Placemark id="gmap-programme-<?php echo $programme->getId(); ?>">
			<name><?php echo $programme->getTitle(); ?></name>
			<description></description>
			<styleUrl><?php echo $programme->getIsActive() ? '#programme_actif' : '#programme_inactif' ?></styleUrl>
			<MultiGeometry>			
			<?php if($programme->getPoint()->getOutput() != null) : ?>
			<Point>
				<coordinates><?php echo $programme->getPoint()->getOutput(); ?></coordinates>
			</Point>
			<?php endif; ?>				
			<?php foreach($programme->getPolygonnes() as $polygonne) : ?>
			<Polygon>
				<tessellate>1</tessellate>
				<altitudeMode>relativeToGround</altitudeMode>
				<outerBoundaryIs>
					<LinearRing>
						<coordinates>
						<?php foreach($polygonne->getPoints() as $point) : ?>
						<?php echo $point->getOutput(true, true) ?>
						<?php endforeach; ?>
						</coordinates>
					</LinearRing>
				</outerBoundaryIs>
			</Polygon>
			<?php endforeach; ?>
			</MultiGeometry>			
		</Placemark>
		<?php endforeach; ?>
	</Folder>
</Document>
</kml>
