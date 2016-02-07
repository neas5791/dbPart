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
	
#overlay {
	position: fixed;
	top: 0;
	left: 0;
	background-color: rgba(0,0,0,.75);
	width: 100%;
	height: 100%;
	z-index: 50;
}

#photo {
	position: fixed;
	z-index: 100;
	top: 48%;
	left: 50%;
}

#photo img {
	width: auto;
	max-width: 800px;
	height: auto;
	max-height: 800px;
	border: 10px solid black;
}

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
					<th class="edit">EDIT</th>
				</tr>
				<?php foreach($results AS $row): ?>
					<tr class="clickable-row" value="<?php echo $row['PID']; ?>" data-href="/img/<?php echo $row['PID']; ?>.jpg" >
					<td><?php echo $row['PID']; ?></td>
					<td><?php echo $row['DESCRIPTION']; ?></td>
					<td id="dwg"><?php echo $row['DWG_NUMBER']; ?></td>
					<td id="part"><?php echo $row['PART_NUMBER']; ?></td>
					<td><?php echo $row['SUPPLIER']; ?></td>
					<td class="edit"><input type="radio" value="<?php echo $row['PID']; ?>" name="edit"></input></td>
				  </tr>
			<?php endforeach; ?>
			</table>
		</div>

		<div id="image">
			
		</div>
		
		<div id="addPart">
		<a href="addform.html" id="add">Add new part</a>
		<a href="editform.html" id="edit-button">Edit part</a>
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