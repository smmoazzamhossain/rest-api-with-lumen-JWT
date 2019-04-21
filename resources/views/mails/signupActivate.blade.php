<div class="container" style="width: 100%; text-align: center;">
	<div class="header" style="padding: 16px; background: #efefef; font-family: monospace; font-size: 18px; color: #9192b1;"> 
		<h2 class="title">Parallax Programmers</h2> 
	</div>
	<div class="content" style="font-size: 17px; font-family: monospace; letter-spacing: -0.5px;">
		<p>Thanks for signup. before going next, Please activate your account</p>
		<p class="button" style="margin: 50px;"><a href="{{URL::to('/api/v1/signup/activate/'.$user['activation_token'])}}" style="padding: 8px; background: #2c9e64; color: #f7f7f7; text-decoration: none; letter-spacing: -0.5px;">
			Activate Account</a>
		</p>
		<p>Thanks for using our service.</p>
	</div>
	<div class="footer" style="padding: 12px; background: #efefef; font-family: monospace; font-size: 18px;color: #9192b1;">
		<p>Contact : 01829618477</p>
	</div>
</div>