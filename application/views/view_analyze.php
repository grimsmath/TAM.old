<style type="text/css">
	.query-container {
		margin: 10px;
	}
	
	.query-container #query {
		padding: 0;
		margin: 0;
		width: 100%;
		border: solid 1px #999;
	}
</style>

<h1 class="blue-gradient">Query Analyzer</h1>

<div class="command-bar">
	<ul>
		<li><a id="lnkRun" href="#">Run Query</a></li>
		<li><a id="lnkReset" href="#">Clear</a></li>
	<ul>
</div>

<div class="data-table-container">
	<div class="query-container">
		<textarea id="query" name="query" cols="80" rows="10"></textarea>
	</div>
	<div id="results"></div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		editAreaLoader.init({
			id: "query",			// textarea id
			syntax: "sql",			// syntax to be uses for highgliting
			font_size: 12,
			height: 200,
			allow_resize: "y",
			start_highlight: true	// to display with highlight mode on start-up
		});

		$('#results').flexigrid({
			sortorder: "asc",
			usepager: true,
			title: "Query Results",
			showTableToggleBtn: false,
			useRp: true,
			rp: 25,
			height: 200
		});
		
		$('#lnkRun').click(function() {
			alert("Hello");
			$('#results').flexigrid({
				url: CI.base_url + '/api/doAnalyze',
				dataType: 'json',
				usepager: true,
				title: "Query Results",
				showTableToggleBtn: false,
				useRp: true,
				rp: 25,
				height: 200,
				success: function(data){
					alert("hello");
				},
                error: function(){
					g.addData();
				}
			});
		});
	});
</script>