<html>
<head>
<title>{SITENAME}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="themes/{THEME}/css/bootstrap.css">
<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/{THEME}/css/bootstrap-theme.min.css">
<script type="text/javascript" src="{SITEURL}loader.php?js={JSFILES}"></script>
<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
</head>
<body>
<div class="container-fluid" style="padding-top:10px">
	<div class="row">
		<div class="col-sm-12">
	    	<h2>{L_5236}</h2>
	    	<hr />
			<div class="well">
	      		<form name="faqsindex" action="viewhelp.php" method="post">
	        		<select class="btn btn-primary btn-md" name="cat" onChange="document.faqsindex.submit()">
	          			<option value=""> {FNAME} </option>
	          			<!-- BEGIN cats -->
	          			<option value="{cats.ID}">{cats.CAT}</option>
	          			<!-- END cats -->
	        		</select>
	        		<span class="pull-right"> 
	        			<a class="btn btn-success btn-sm" href="help.php"><span class="glyphicon glyphicon-question-sign"></span> {L_5243}</a>  
	        			<a class="btn btn-danger btn-sm" href="javascript:parent.$.fancybox.close();"><span class="glyphicon glyphicon-remove"></span> {L_678}</a> 
	        		</span>
	      		</form>
	      	</div>
			<legend>{FNAME}</legend>
	      	<ul class="nav nav-tabs nav-stacked">
	        	<!-- BEGIN faqs -->
	        	<li><a href="#faq{faqs.ID}"><span class="glyphicon glyphicon-search"></span> {faqs.Q}</a></li>
	        	<!-- END faqs -->
	      	</ul>
	      	<!-- BEGIN faqs -->
	      	<table class="table table-bordered table-condense table-striped">
	      		<tr>
	      			<th><a name="faq{faqs.ID}"></a>{faqs.Q}<span style="float:right"><a class="btn btn-info" href="#top"><span class="glyphicon glyphicon-arrow-up"></span> {L_5245}</a></span></th>
	      		</tr>
	      		<tr>
	      			<td>{faqs.A}</td>
	      		</tr>
	      	</table>
	      	<!-- END faqs -->
	 	</div>
	</div>
</div>
</body>
</html>
