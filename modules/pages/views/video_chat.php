<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to :: AME Fitness Equipment</title>
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo theme_url();?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo theme_url();?>css/ame-preet.css" type="text/css" rel="stylesheet">
<style type="text/css" media="screen">
<!--
@import url("<?php echo resource_url();?>fancybox/jquery.fancybox.css");
-->
</style>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>
<body class="p10" style="width:355px;height:280px;">
<p class="heading">Live Video Chat</p>   
    <div id='myPublisherDiv'></div> 
    <div id='subscribersDiv'></div> 
    
    <script src='//static.opentok.com/v2/js/opentok.min.js'></script> 
    <script> 
      var apiKey = '45411082';
      var sessionId = '2_MX40NTQxMTA4Mn5-MTQ0NzczODE0NTIxMn5GQ2xTdmpLN3dZcVJqaUVJV0NlWDB3dnB-UH4'; 
      var token = 'T1==cGFydG5lcl9pZD00NTQxMTA4MiZzaWc9OTExZjg1NWRjZjZhMmY0NWU2NjE1YzVjOGU2MjBiYTc0Y2ZkMWIwMjpyb2xlPXB1Ymxpc2hlciZzZXNzaW9uX2lkPTJfTVg0ME5UUXhNVEE0TW41LU1UUTBOemN6T0RFME5USXhNbjVHUTJ4VGRtcExOM2RaY1ZKcWFVVkpWME5sV0RCM2RuQi1VSDQmY3JlYXRlX3RpbWU9MTQ0NzczOTQ3MSZub25jZT0wLjMzNjczNTM0NjU1MTU4NjMmZXhwaXJlX3RpbWU9MTQ0NzgyNTg3MQ==';
      var session = OT.initSession(apiKey, sessionId); 
      session.on({ 
          streamCreated: function(event) { 
            session.subscribe(event.stream, 'subscribersDiv', {insertMode: 'append'}); 
          } 
      }); 
      session.connect(token, function(error) {
        if (error) {
          console.log(error.message);
        } else {
          session.publish('myPublisherDiv', {width: 320, height: 240}); 
        }
      });
    </script> 
</body>
</html>