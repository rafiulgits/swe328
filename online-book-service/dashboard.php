<?php include 'base.php'; ?>

<?php startblock('header') ?>
	<title>Dashboard : Nilkhet</title>
	<link rel="stylesheet" type="text/css" href="static/css/dashboard.css">
<?php endblock() ?>


<?php startblock('content') ?>
	<?php 

		// access checking
		if(isset($_SESSION['is_stuff'])){
			if($_SESSION['is_stuff'] != 't'){
				header('Location: error.php');
			}
		}
		else{
			header('Location: error.php');
		}

		$db = DB::connection();
		$res = pg_exec($db->getRefference(), "SELECT * FROM getBookStocks();");
		$arr = [];
		while ($data = pg_fetch_object($res)) {
			array_push($arr, $data);
		}

		$res = pg_exec($db->getRefference(), "SELECT * FROM getCategories();");
		$categoryList = [];
		while ($data = pg_fetch_object($res)) {
			array_push($categoryList, $data);
		}

		$res = pg_exec($db->getRefference(), "SELECT * FROM getAuthors();");
		$authorList = [];
		while ($data = pg_fetch_object($res)) {
			array_push($authorList, $data);
		}

		$res = pg_exec($db->getRefference(), "SELECT * FROM getPublishers();");
		$publisherList = [];
		while ($data = pg_fetch_object($res)) {
			array_push($publisherList, $data);
		}

		$res = pg_exec($db->getRefference(), "SELECT * FROM getCountries();");
		$countryList = [];
		while ($data = pg_fetch_object($res)) {
			array_push($countryList, $data);
		}

		$res = pg_exec($db->getRefference(), "SELECT * FROM getLanguages();");
		$languageList = [];
		while ($data = pg_fetch_object($res)) {
			array_push($languageList, $data);
		}

		$res = pg_exec($db->getRefference(),"SELECT id,total_price,status,order_time,order_date,name,address FROM voucher;");
		$orderList = [];
		while($data = pg_fetch_object($res)){
			array_push($orderList, $data);
		}

		pg_close($db->getRefference());

		$map = array('P' => 'Pending', 'A' => 'Accepted', 'D' => 'Delivered');
	?>

	<div class="d-flex justify-content-center mt-5">
		<div class="list-group list-group-horizontal">
			<a href="orderlist.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/item-list.svg" class="icons"> Order List
			</a>
			<a href="addbook.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/add-book.svg" class="icons"> Add Book
			</a>
			<a href="addstuff.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/stuff.svg" class="icons"> Add Stuff
			</a>
			<a href="stufflist.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/stufflist.svg" class="icons"> Stuff List
			</a>
		</div>
	</div>
	<div class="d-flex justify-content-center mt-5">
		<div class="list-group list-group-horizontal">
			<a href="addcategory.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/category.svg" class="icons"> Add Category
			</a>
			<a href="addlanguage.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/translate.svg" class="icons"> Add Language
			</a>
			<a href="addauthor.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/author.svg" class="icons"> Add Author
			</a>
			<a href="addpublisher.php" class="btn btn-light btn-lg mr-3">
				<img src="static/res/send.svg" class="icons"> Add Publisher
			</a>
		</div>
	</div>
	
	<br><br><br>
	<div class="d-flex justify-content-center mt-3">
		<div class="col-md-12">
			<p class="display-4 text-center">Book Stock Table</p>
			<table class="table table-bordered bg-dark text-white" id="book-table">
				<thead>
					<th>ISBN</th>
					<th>Book</th>
					<th>Edition</th>
					<th>Price</th>
					<th>Entry</th>
					<th>Sold</th>
					<th>Expenditure</th>
					<th>Update by</th>
					<th>Date</th>
					<th>Time</th>
				</thead>
				<tbody>
					<?php for($item=0; $item<count($arr); $item++): ?>
						<tr>
							<td><?php echo $arr[$item]->isbn; ?></td>
							<td><a href="updatebook.php?isbn=<?php echo  $arr[$item]->isbn ?>"><?php echo $arr[$item]->book; ?></a> </td>
							<td><?php echo $arr[$item]->edition; ?></td>
							<td><?php echo $arr[$item]->price; ?></td>
							<td><?php echo $arr[$item]->entry_copy; ?><a class="float-right " href="stockupdate.php?isbn=<?php echo $arr[$item]->isbn; ?>">add</a></td>
							<td><?php echo $arr[$item]->sold_copy; ?> </td>
							<td><?php echo $arr[$item]->expenditure; ?></td>
							<td><?php echo $arr[$item]->staff_name; ?></td>
							<td><?php echo $arr[$item]->entry_date; ?></td>
							<td><?php echo $arr[$item]->entry_time; ?></td>
						</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
	</div>
	<br><br><br>

	<div class="container-fluid mt-3">
		<h4 class="display-4 text-center mb-3">Manage Book Fields</h4>
		<div class="row justify-content-center">
			<div class="col-md-3">
				<div class="list-group">
					<h6 class="list-group-item bg-dark text-white">Categories</h6>
					<?php for($item=0; $item<count($categoryList); $item++): ?>
					<a href="category.php?name=<?php echo $categoryList[$item]->name ?>" class="list-group-item"><?php echo $categoryList[$item]->name; ?> 
						(<?php echo $categoryList[$item]->available; ?>)</a>
					<?php endfor; ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="list-group">
					<h6 class="list-group-item bg-dark text-white">Authors</h6>
					<?php for($item=0; $item<count($authorList); $item++): ?>
					<a href="author.php?name=<?php echo $authorList[$item]->name ?>" class="list-group-item"><?php echo $authorList[$item]->name; ?> 
						(<?php echo $authorList[$item]->available; ?>)</a>
					<?php endfor; ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="list-group">
					<h6 class="list-group-item bg-dark text-white">Publishers</h6>
					<?php for($item=0; $item<count($publisherList); $item++): ?>
					<a href="publisher.php?name=<?php echo $publisherList[$item]->name ?>" class="list-group-item"><?php echo $publisherList[$item]->name; ?> 
						(<?php echo $publisherList[$item]->available; ?>)</a>
					<?php endfor; ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="list-group">
					<h6 class="list-group-item bg-dark text-white">Languages</h6>
					<?php for($item=0; $item<count($languageList); $item++): ?>
					<a href="publisher.php?name=<?php echo $languageList[$item]->name ?>" class="list-group-item"><?php echo $languageList[$item]->name; ?> 
						(<?php echo $languageList[$item]->available; ?>)</a>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
	<br><br>

<?php endblock() ?>
