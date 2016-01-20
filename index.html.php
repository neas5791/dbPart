<!DOCTYPE xhtml>
<html>
<head>
	<title>Transcrete dbPart</title>
	<script type="text/javascript">
		createEditableSelect(document.forms[0].prefix);
	</script>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
	<label for="supplierid">Supplier:</label>
	<select name="supplierid">
		<option value="0"></option>
		<?php foreach($suppliers as $supplier): ?>
			<option value="<?php echo $supplier['id']; ?>">
			<?php echo $supplier['company']; ?>
			</option>
		<?php endforeach; ?>	
	</select>
	<label for="prefix">Prefix:</label>

	<input type="text" name="prefix" selectBoxOptions="
		<?php
			$str = '';
			foreach($prefixes as $prefix){
				$str .= $prefix['prefix'].';';
			}

			echo $str; ?>"> </input>
	<!-- <select name="prefix">
		<option value="0"></option>
		<?php foreach($prefixes as $prefix): ?>
			<option value="<?php echo $prefix['prefix']; ?>">
			<?php echo $prefix['prefix']; ?>
			</option>
		<?php endforeach; ?>	
	</select> -->


	<label for="sup_part_number">Supplier Part Number:</label>
	<input type="text" name="sup_part_number"></input>
	<label for="descr">Description:</label>
	<input type="text" name="descr"></input>
	<label for="typeid">Type:</label>
	<select name="typeid">
		<option value="0"></option>
		<?php foreach($types as $type): ?>
			<option value="<?php echo $type['id']; ?>">
			<?php echo $type['type']; ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="checkbox" name="new_prod" value="true">
	<label for="upload">Supplier Part</label>
	<input type="file" name="upload"></input>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	<input type="hidden" name="action" value="upload">
	<input type="submit" name="add" value="Add"></input>
</form>
</body>
</html>