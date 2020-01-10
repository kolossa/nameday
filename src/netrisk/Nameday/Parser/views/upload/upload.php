
<html>

	<body>
		
		<h2>Please upload your file</h2>
		
		<div>
			<?php echo $msg; ?>
		</div>
		
		<form action="uploadnamedayfile" method="post" enctype="multipart/form-data">
			<input type="file" name="file" />
			
			<br><br>
			<input type="submit" value="Submit" name="submit">
		</form>
	</body>
</html>
<?php 

