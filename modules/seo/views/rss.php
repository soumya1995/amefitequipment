<?php 
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
	<image>
<url>http://news.playdoit.com/uploaded_files/thumb_cache/thumb_91_84_Poker+chips_hdJaIw.jpg</url>
<title>W3Schools.com</title>
<link>http://www.w3schools.com</link>
</image>

    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>
    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
   <?php
	if(is_array($result) && count($result) )
	{					
		foreach($result as $v)
		{ 
  ?>    
        <item>
          <title><?php echo xml_convert($v['title']); ?></title>
          <link><?php echo site_url('' . $v['url']) ?></link>
          <guid><?php echo site_url('' . $v['url']) ?></guid>		    
          <description><?php echo xml_convert($v['description']); ?></description>  
		  <enclosure url="http://news.playdoit.com/uploaded_files/thumb_cache/thumb_91_84_Poker+chips_hdJaIw.jpg" type="image/jpeg" length="810000"/>
		        <pubDate>Fri, 18 Jul 2014 11:25:15 +0530</pubDate>
        </item>     
		
		   
   <?php
      }
    } 
	?>    
    </channel>
</rss>