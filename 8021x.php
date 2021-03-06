<?php
require "main.php";
?><!DOCTYPE html>

<html>
	<head>
		<title>802.1X</title>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="guide.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
			  $("#root").click(function(){
			      $(".prompt").text("#");
			      $(".prompt2").text("#");
			  });
			  $("#sudo").click(function(){
			  		$(".prompt").text("$ sudo");
			  		$(".prompt2").text("$");
			  });
		  });
		</script>
	</head>
	<body>
		<ol id="steptostep">
			<li>
				First, get <span class="command">wpa_supplicant</span> installed and stuff.
				If you're feeling lazy, get <span class="command">NetworkManager</span> or <span class="command">wicd</span> running instead.
			</li>
			<li>
				You can get information on <span class="command">wpa_supplicant</span> by using <span class="command">man</span>.
				<pre class="command"><span class="prompt2">#</span> <span class="command">man</span> wpa_supplicant</pre>
			<li>
				<span class="command">wpa_supplicant</span> stores its config in <span class="dir">/etc/wpa_supplicant/wpa_supplicant.conf</span>. Navigate to it:
				<pre class="command"><span class="prompt">#</span> <span class="command">cd</span> /etc/wpa_supplicant/</pre>
			</li>
			<li>
				Now get rid of the current config file if you want to:
				<pre class="command"><span class="prompt">#</span> <span class="command">rm</span> wpa_supplicant.conf</pre>
			</li>
			<li>
				Then edit it, either with <span class="command">nano</span>:
				<pre class="command"><span class="prompt">#</span> <span class="command">nano</span> wpa_supplicant.conf</pre>
				...or with the hardcore <span class="command">vi</span>:
				<pre class="command"><span class="prompt">#</span> <span class="command">vi</span> wpa_supplicant.conf</pre>
			</li>
			<li>
				Now add the configuration settings:
				<pre class="file">
eapol_version=1
fast_reauth=0
ap_scan=0
network={
	key_mgmt=IEEE8021X
	eap=PEAP
	phase1=<span class="string">"peaplabel=1"</span>
	phase2=<span class="string">"auth=MSCHAPV2"</span>
	identity=<span class="string">"<span class="edit"><?php echo $user ?></span>@aber.ac.uk"</span>
	password=<span class="string">"<span class="edit"><?php echo $passwords[$password] ?></span>"</span>
}
				</pre>
			</li>
			<li>
				Now get <span class="command">wpa_supplicant</span> running:
				<pre class="command"><span class="prompt">#</span> <span class="command">wpa_supplicant</span>  -B -c /etc/wpa_supplicant/wpa_supplicant.conf -i eth0 -D wired</pre>
				If you're interested:
				<dl>
					<dt>-B</dt>
					<dd>Forces <span class="command">wpa_supplicant</span> to run in the background.

					<dt>-c</dt>
					<dd>Defines the configuration file for <span class="command">wpa_supplicant</span>; i.e. the one you just edited.

					<dt>-i</dt>
					<dd>Tells the program which interface to use. <span class="command">eth0</span> is the first Ethernet port. Similarly, <span class="command">wlan0</span> is the first wireless device. Due to <a href="https://en.wikipedia.org/wiki/Consistent_Network_Device_Naming">recent changes</a> this may be incorrect: run <span class="command">ip a</span> to find the correct name if <span class="command">eth0</span> doesn't work.</dd>

					<dt>-D</dt>
					<dd>Informs the program of the driver it should use.</dd>
				</dl>
			</li>
			<li>
				Finally, start the <abbr title="Dynamic Host Protocol">DHCP</abbr> client dæmon.
				<pre class="command"><span class="prompt">#</span> <span class="command">dhcpcd</span></pre>
			</li>
			<li>
				To make sure everything works, check if you can connect to the <abbr title="Local Area Network">LAN</abbr>: <!-- rarely useful but ten steps sounds better than nine -->
				<pre class="command"><span class="prompt2">#</span> <span class="command">ping</span> central</pre>
			</li>
			<li>
				And check that you can connect to the outside world:
				<pre class="command"><span class="prompt2">#</span> <span class="command">ping</span> google.com</pre>
		</ol>
	</body>
</html>
