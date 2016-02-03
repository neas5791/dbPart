<!DOCTYPE xhtml>
<html>
<head>
	<title>Transcrete dbPart</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

		<script type="text/javascript" src='./js/partnumber.js'></script>
	
	<style type="text/css">
	table { border-collapse: collapse; }
	td, th { border: 1px solid black;
					 padding: 5px; }
	.zebra {
		background-color: #dddddd;
  	color: #666666;
	}
	.zebrahover { background-color: #FFFACD; }
	
	</style>

</head>
<body>
	<div id="wrapper">
		<header>
			<h1>Part Number List</h1>
		</header>
		
		<div id="table">
			<table>
				<tr id="head">
					<th>PID</th>
					<th>DESCRIPTION</th>
					<th>DRAWING NUMBER</th>
					<th>SUPPLIER PART NUMBER</th>
					<th>SUPPLIER</th>
				</tr>
				<?php foreach($results AS $row): ?>
					<tr value="<?php echo $row['PID']; ?>">
					<td><?php echo $row['PID']; ?></td>
					<td><?php echo $row['DESCRIPTION']; ?></td>
					<td><?php echo $row['DWG_NUMBER']; ?></td>
					<td><?php echo $row['PART_NUMBER']; ?></td>
					<td><?php echo $row['SUPPLIER']; ?></td>
				  </tr>
			<?php endforeach; ?>
			</table>
		</div>

		<div id="image">
			
		</div>
		
		<div id="addPart">
		<a href="form.html">Add new part</a>
			<form action="" method="post" enctype="multipart/form-data">

				<div id="block">
					<label for="supplierid">Supplier:</label>
					<select name="supplierid">
						<option value="0"></option>
						<?php foreach($suppliers as $supplier): ?>
						<option value="<?php echo $supplier['id']; ?>">
						<?php echo $supplier['company']; ?>
						</option>
						<?php endforeach; ?>	
					</select>
					<label for="sup_part_number">Supplier Part Number:</label>
					<input type="text" name="sup_part_number"></input>
					<label for="sup_part_number">Drawing Number:</label>
					<input type="text" name="drawing_number"></input>
				</div>

				<div>
					<label for="typeid">Type:</label>
					<select name="typeid">
						<option value="0"></option>
							<?php foreach($types as $type): ?>
						<option value="<?php echo $type['id']; ?>">
							<?php echo $type['type']; ?>
						</option> <?php endforeach; ?>
					</select>
					<label for="descr">Description:</label>
					<input type="text" name="descr"></input>
				</div>
				<div>
				<!-- <input type="checkbox" name="new_prod" value="true"> -->
				<label for="upload">Drawing or Image</label>
				<input type="file" name="upload"></input>
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
				<input type="hidden" name="action" value="upload">
				</div>
				<input type="submit" name="add" value="Add"></input>
			</form>
		</div>
	</div>
</body>
</html>