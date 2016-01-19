<!DOCTYPE xhtml>
<html>
<head>
	<title>Transcrete dbPart</title>
	<script type="text/javascript">
		createEditableSelect(document.forms[0].prefix);
	</script>
</head>
<body>
<form method="post">
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
	<!-- <label for="sup_part_number">Supplier Part</label>
	<input type="text" name="sup_part_number"></input> -->
	<input type="submit" name="add" value="Add"></input>
</form>
</body>
</html>