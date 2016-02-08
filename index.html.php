<!DOCTYPE xhtml>
<html>
<head>
	<title>Transcrete dbPart</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

		<script type="text/javascript" src='./js/partnumber.js'></script>
	
	<style type="text/css">
	html {
		font-family: Arial,sans-serif;
		font-size: 0.9em;
	}
	a {
		font-weight: 0.75em;	
	}
	table { 
		border-collapse: collapse; 
	}
	
	td, th { 
		border: 1px solid black;
		padding: 5px; 
		font-size: 0.75em;
	}
	
/*	form label{
		float: left;
		width: 150px;
		margin-bottom: 5px;
	}*/
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
					<th class="edit" id="clickme"><!-- EDIT --></th>
					<th>PID</th>
					<th>DESCRIPTION</th>
					<th>DRAWING NUMBER</th>
					<th>SUPPLIER PART NUMBER</th>
					<th>SUPPLIER</th>
				</tr>
				<?php foreach($results AS $row): ?>
					<tr class="clickable-row" value="<?php echo $row['PID']; ?>" data-href="/img/<?php echo $row['PID']; ?>.jpg" >
						<td class="edit"><input type="radio" value="<?php echo $row['PID']; ?>" name="edit"></input></td>
						<td><?php echo $row['PID']; ?></td>
						<td><?php echo $row['DESCRIPTION']; ?></td>
						<td id="dwg"><?php echo $row['DWG_NUMBER']; ?></td>
						<td id="part"><?php echo $row['PART_NUMBER']; ?></td>
						<td><?php echo $row['SUPPLIER']; ?></td>
				  </tr>
			<?php endforeach; ?>
			</table>
		</div>

		<div id="image">
			
		</div>
		
		<div id="toolbox">
			<a href="create_part.html" id="add_part">Create New Part</a>
			<a href="create_supplier.html" id="add_supplier">Create New Supplier</a>
			<a href="create_drawing.html" id="add_drawing">Create New Drawing</a>
		
			<form  class="form" id="create_part" action="" method="post" enctype="multipart/form-data">
					<div>
						<label for="descr">Description:</label>
						<input type="text" name="descr"></input>
					</div>
					<div>
						<label for="upload">Image:
						<input type="file" name="upload"></input></label>
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
						<input type="hidden" name="action" value="upload">
						<input type="submit" name="add" value="Add"/>
					</div>
			</form>
			<form  class="form" id="create_supplier" action="" method="post" enctype="multipart/form-data">
					<h2>Create supplier form</h2>
					<input type="submit" name="add" value="Add"/>
			</form>

			<form  class="form" id="create_drawing" action="" method="post" enctype="multipart/form-data">
					<h2>Create drawing form</h2>
					<input type="submit" name="add" value="Add"/>
			</form>

		</div>

		<div id="nav-toolbox">

			<div class="part">
				<a href="addform.html" id="add-button">Add new part</a>
				<a href="editform.html" id="edit-button">Edit part</a>
			</div>

			<div class="drawing">
				<a href="add_drawing.html" id="add-button">Add new Drawing</a>
			</div>

			<div>
				
			</div>
			<form class="form" action="" method="post" enctype="multipart/form-data">

				<div id="part-form">
					<label for="descr">Description:</label>
					<input type="text" name="descr"></input>

					<label for="upload">Drawing or Image</label>
					<input type="file" name="upload"></input>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
					<input type="hidden" name="action" value="upload">
				</div>
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
					<label for="sup_part_number" class="sup_part_number">Supplier Part Number:</label>
					<input type="text"  class="sup_part_number" name="sup_part_number"></input>
					<label for="drawing_number" class="drawing_number">Drawing Number:</label>
					<input type="text" class="drawing_number" name="drawing_number"></input>
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
				
				</div>
				<div>
				<!-- <input type="checkbox" name="new_prod" value="true"> -->
				
				</div>
				<input type="submit" name="add" value="Add"></input>
			</form>
		</div>
	</div>
</body>
</html>