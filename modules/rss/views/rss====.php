<?php 


function xml_convert($str, $protect_all = FALSE)
{
	$temp = '__TEMP_AMPERSANDS__';

	// Replace entities to temporary markers so that
	// ampersands won't get messed up
	$str = preg_replace("/&#(\d+);/", "$temp\\1;", $str);

	if ($protect_all === TRUE)
	{
		$str = preg_replace("/&(\w+);/",  "$temp\\1;", $str);
	}

	$str = str_replace(array("&","<",">","\"", "'", "-"),
						array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;", "&#45;"),
						$str);

	// Decode the temp markers back to entities
	$str = preg_replace("/$temp(\d+);/","&#\\1;",$str);

	if ($protect_all === TRUE)
	{
		$str = preg_replace("/$temp(\w+);/","&\\1;", $str);
	}

	return $str;
}


header("Content-Type: application/rss+xml");
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"    
    >
    <channel>
    <title><?php echo $feed_name; ?></title>
    <link><?php echo $feed_url; ?></link>    
    <description><?php echo $page_description; ?></description>
	

    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>
    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
   
        <item>
          <title><?php echo xml_convert("Water Treatment, Water Purification, Wastewater Treatment Solutions UAE"); ?></title>
          <link><?php echo base_url(); ?></link>
          <guid><?php echo base_url(); ?></guid>		    
          <description><?php echo xml_convert("Aquacare is one of the company which provides water treatment, water filtration, water purification, wastewater treatment solutions in UAE. To Know more visit now."); ?></description>  
        </item>     
		
		   
    </channel>
</rss>