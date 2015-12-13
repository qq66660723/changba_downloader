<!doctype html>
<html lang="en-US">
<head>

	<meta charset="utf-8">

	<title>唱吧作品在线下载器 - 一款完全免费的唱吧作品在线下载工具</title>
	
		<meta content="width=device-width,user-scalable=no" name="viewport">
	<script type="text/javascript" src="/jquery/jquery.js"></script>
	<script type="text/javascript" src="http://tajs.qq.com/stats?sId=49890980" charset="UTF-8"></script>
	<link rel="stylesheet" href="css/main.css">
	

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	
	
</head>

<body>



<?php
    if ($_GET["add"] != "")
	{
		$text_add = $_GET["add"];
	}else
	{
		$text_add = "请输入唱吧歌曲分享链接，以http://开头";
	}
?>

	<div id="main">

		<h2>唱吧作品在线下载器</h2>

		<form method="get">

			<fieldset>

				<p><label for="add">唱吧作品地址：</label></p>
				<p><input type="text" name="add" value="<?php echo $text_add;?>" onBlur="if(this.value=='')this.value='请输入唱吧歌曲分享链接，以http://开头'" onFocus="if(this.value=='请输入唱吧歌曲分享链接，以http://开头')this.value=''"></p> 
				
				</br>
				
				<?php
					function getSubstr($str, $leftStr, $rightStr)
					{
					//取文本中间过程
					$left = strpos($str, $leftStr);
					//echo '左边:'.$left;
					$right = strpos($str, $rightStr,$left);
					//echo '<br>右边:'.$right;
					if($left < 0 or $right < $left) return '';
					return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
					}
					
				    if ($text_add != "请输入唱吧歌曲分享链接，以http://开头")
					{
						echo '<div id="load" style="word-break: break-all;"><p>加载中，请稍候...</p></br></div>';
						$code = @file_get_contents($text_add);
						if (strpos($code,"没有找到该作品") != false)
						{//未找到作品
							echo '  <script type="text/javascript">
								$("#load").html("<p>抱歉，未找到该作品，请检查歌曲链接是否正确</br>如有问题或疑问，请发送邮件至gdsgltc@gmail.com联系解决</br>感谢！</p></br>");
							    </script>
							';
						}else if (strpos($code,"导出该作品") != false)
						{//找到作品
					
							if (strpos($code,"bokecc.com") != false)
							{//视频MV
								$title = getSubstr($code , '<h1 style="font-size: 0; height: 0; overflow: hidden;">', ' - 唱吧,最时尚的手机KTV</h1>');
								$singer = getSubstr($code , '&lt; <span class=\'twemoji\'>', '</span>的主页</a>');
								$vid = getSubstr($code , 'ecc.com/player?vid=', '&amp;siteid=');
								$uid = getSubstr($code , '&amp;siteid=', '&amp;autoStart=true');
								$mvurl_normal = "http://www.flvcd.com/parse.php?kw=http%3A%2F%2Fp.bokecc.com%2Fplayvideo.bo%3Fuid%3D".$uid."%26playerid%3D%26playertype%3D%26autoStart%3Dtrue%26vid%3D".$vid."&format=";
								$mvurl_high = "http://www.flvcd.com/parse.php?kw=http%3A%2F%2Fp.bokecc.com%2Fplayvideo.bo%3Fuid%3D".$uid."%26playerid%3D%26playertype%3D%26autoStart%3Dtrue%26vid%3D".$vid."&format=high";
								$code_mvurl_normal = file_get_contents($mvurl_normal);
								$code_mvurl_normal = iconv("gb2312", "utf-8//IGNORE",$code_mvurl_normal ); 
								$url_mvurl_normal = getSubstr($code_mvurl_normal , '<br>下载地址：<a href="', '" target="_blank" class="link"');
								$code_mvurl_high = file_get_contents($mvurl_high);
								$code_mvurl_high = iconv("gb2312", "utf-8//IGNORE",$code_mvurl_high ); 
								$url_mvurl_high = getSubstr($code_mvurl_high , '<br>下载地址：<a href="', '" target="_blank" class="link"');
																
																
								echo '  <script type="text/javascript">
									$("#load").html("<p>作品：'.$title.'</br>ID：'.$singer.'</br>类型：MV视频</br>下载地址：</br><a target=\"_blank\" href=\"'.$url_mvurl_normal.'\">'.$url_mvurl_normal.'(普通版)</a> </br><a target=\"_blank\" href=\"'.$url_mvurl_high.'\">'.$url_mvurl_high.'(高清版)</a></p></br>");
									</script>
								';
							}else
							{//音乐文件
								$songurl = getSubstr($code , '(function(){var a="', '",b=/userwork\/([');
								$title = getSubstr($code , '<h1 style="font-size: 0; height: 0; overflow: hidden;">', ' - 唱吧,最时尚的手机KTV</h1>');
								$singer = getSubstr($code , '&lt; <span class=\'twemoji\'>', '</span>的主页</a>');
								echo '  <script type="text/javascript">
									$("#load").html("<p>作品：'.$title.'</br>ID：'.$singer.'</br>类型：MP3音乐</br>下载地址：</br><a target=\"_blank\" href=\"'.$songurl.'\">'.$songurl.'</a></p></br>");
									</script>
								';
							}
							
						}else
						{//未知情况错误提示
							echo '  <script type="text/javascript">
								$("#load").html("<p>抱歉，发生未知错误以至未能找到下载地址</br>请再次确认作品链接地址是否正确</br>如有问题或疑问，请发送邮件至gdsgltc@gmail.com联系解决</br>感谢！</p></br>");
							    </script>
								';
						}						
					}					
				?>
								
				<p><input type="submit" value="下载"></p>

			</fieldset>

		</form>

	</div> <!-- end main -->

<!--页尾begein-->
	<div id="foot">	
		<p>
		<a href="index.php" style="text-decoration:none;">首页</a>丨
		<a href="help.php" style="text-decoration:none;">不会下载？点我！</a>丨
		<a href="about.php" style="text-decoration:none;">关于</a>
		</br>
		<p>Copyright © 2015 唱吧作品在线下载器</p>
		</p>
	</div>


<!--页尾end-->
</body>	
</html>