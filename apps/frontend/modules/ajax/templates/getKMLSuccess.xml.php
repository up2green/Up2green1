<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
	<name>up2green</name>
	<open>1</open>
	<description>Les différents sites de reforestations sur lesquels nous agissons</description>
	<Style id="sn_violet">
		<IconStyle>
			<scale>0.5</scale>
			<Icon>
				<href>http://reforestation.up2green.com/images/gmap/pointeur/60x60/empty/violet.png</href>
			</Icon>
		</IconStyle>
		<LabelStyle>
			<scale>0</scale>
		</LabelStyle>
		<BalloonStyle>
			<text>$[description]</text>
		</BalloonStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="sh_violet">
		<IconStyle>
			<scale>0.6</scale>
			<Icon>
				<href>http://reforestation.up2green.com/images/gmap/pointeur/60x60/empty/violet.png</href>
			</Icon>
		</IconStyle>
		<BalloonStyle>
			<text>$[description]</text>
		</BalloonStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id="msn_violet">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_violet</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#sh_violet</styleUrl>
		</Pair>
	</StyleMap>
	<Folder>
		<name><?php echo __("ONG et Organismes planteurs"); ?></name>
		<open>1</open>
		<description>Les sièges sociaux des différents organismes planteurs qui soutiennent up2green reforestation.</description>
		<?php foreach($organismes as $organisme) : ?>
		<?php if($organisme->getCoordinate() != null) : ?>
		<Placemark id="gmap-organisme-<?php echo $organisme->getId(); ?>">
			<name><?php echo $organisme->getTitle(); ?></name>
			<description><![CDATA[<html><body><?php echo $organisme->getAccroche(); ?></body></html>]]></description>
			<styleUrl>#msn_violet</styleUrl>
			<Point>
				<coordinates><?php echo $organisme->getCoordinate(); ?></coordinates>
			</Point>
		</Placemark>
		<?php endif; ?>
		<?php endforeach; ?>
	</Folder>
	<Folder>
		<name><?php echo __("Programmes de reforestation"); ?></name>
		<open>1</open>
		<description>Les sites de reforestation.</description>
		<?php foreach($programmes as $programme) : ?>
		<?php if($programme->getCoordinate() != null) : ?>
		<Placemark id="gmap-programme-<?php echo $programme->getId(); ?>">
			<name><?php echo $programme->getTitle(); ?></name>
			<description><![CDATA[<html>
				<body>
				<span class="title"><?php echo $programme->getTitle() ?></span>
				<span style="display:block;padding-top:10px;" class="content">
					<?php if($programme->getLogo()) : ?>
					<img class="gmap-programme" src="/uploads/programme/<?php echo $programme->getLogo() ?>" alt="Diapo Image" />';
					<?php endif; ?>
					<div class="accroche-programme"><?php echo $programme->getAccroche(); ?></div>';
					<a href="<?php echo sfConfig::get('app_url_blog') ?>/programme/<?php echo $programme->getSlug() ?>" class="read_more" target="_blank">Lire la suite</a>';
					<br />
				</span>
				</body>
			</html>]]></description>
			<styleUrl>#msn_violet</styleUrl>
			<Point>
				<coordinates><?php echo $programme->getCoordinate(); ?></coordinates>
			</Point>
		</Placemark>
		<?php endif; ?>
		<?php endforeach; ?>
	</Folder>
</Document>
</kml>
