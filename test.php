<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Test Page</title>
	
	<style>
		#la_results { /* the look of the overlay div with results */
			border: 1px solid #bbb;
			border-color: #bbb #6f6f6f #6f6f6f #bbb;
			border-top: 0;
			-moz-box-shadow: 3px 3px 8px #444;
			-webkit-box-shadow: 3px 3px 8px #444;
			-moz-border-radius-bottomright: 5px;
			-moz-border-radius-bottomleft: 5px;
			-webkit-border-bottom-right-radius: 5px;
			-webkit-border-bottom-left-radius: 5px;
			background: #fff;
		}
		
		/*the two divs below control the look and feel of individual results, which show up as LI elements in the overlay div */
		#la_results ul { 
			list-style-type: none; 
			margin:0; 
			padding:0; 
			font:normal 11px Geneva, Arial, Helvetica, sans-serif;
		}
		
		#la_results ul li a {
			display: block; 
			text-decoration:none; padding:3px	
		}
		
		.itemwhite { 
			background-color: #fff; /* the color of the "white" stripe in the results div */
		} 
		
		.itemcol { 
			background-color: #efefef; /* the color of the "color" stripe in the results div */
		} 
		
		#la_results li a:hover { 
			background-color: #f8bb49; /*the color of the hover effect when the user goes thru the results */
		} 

		/* the class below controls the font and the look of the "more search/full text search stripe */
		.itemsrch {
			color: #cc3333;
			font: bold 11px Geneva, Arial, Helvetica, sans-serif; 
			background-color:#FFFFCC;
		} 
		
		.nwylf { 
			color: #900; /* "not what you are looking for?" text color */
		} 
	</style>

</head>
<body>

<div id="la_wrapper" style="width:500px;background-color:#F3f3f3;margin:0;padding:6px;border: solid 1px #a9cee7;">
	<div id="la_pop_feat" style="float:right">
		<a href="#" onClick="return laFeatured('Featured Q&As',85,21,49,5); return false" class="la_feat">Featured</a> | 
		<a href="#" onClick="return laPopular('Popularity Contest'); return false" class="la_pop">Popular</a>
	</div>
	
	<h2 class="la_title">Ask Us - Anything</h2>
	
	<input type="text" 
		   id="la_suggest" 
		   style="display:block; margin-top: 6px; width: 100%; height: 24px; font-size: 14px" 
		   onFocus="document.getElementById('la_results').innerHTML=''" 
		   onKeyUp="if (this.value) {laFQM(this.value)} else {document.getElementById('la_results').innerHTML=''}" value="" />
		   
	<div id="la_results" style="padding-top: 2px; font-family: Helvetica, Arial, sans-serif; font-size:11px; position:absolute; margin-top:0px; width:500px; border: solid 1px #ccc;display:none"></div>
		<div class="la_topics_intro" style="padding-top:8px">Or select one of the popular topics: <span id="la_topics_list"> </span> 
	</div>
</div>

<script language="javascript">var lahilite="efefef"; var lanw=0;</script>
<script language="javascript" src="http://api.libanswers.com/api/ladata-243.js"></script>
<script type="text/javascript">listLATopics(10,150,60,1,0);</script> 
<!--End of the LibAnswers Widget -->  