<?php 
require_once('class.ebay.php');
$ebay = new ebay('Hassnain-WebShop-PRD-d08fa563f-a6f7b979', 'EBAY-US');
$sort_orders = $ebay->sortOrders();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ebay Scrapping</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
  	
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="jquery.copy-to-clipboard.js"></script>
  <script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100000,
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      	$price_ex = explode("-",$_POST['pricemin']);
		$pricemin = $price_ex[0];
		$pricemax = $price_ex[1];
		echo "values: [ ".$pricemin.", ".$pricemax." ],";
		}else{
			echo "values: [ 3000, 9000 ],";
		}
      ?>
      slide: function( event, ui ) {
        $( "#pricemin" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
      }
    });
    $( "#pricemin" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      "-" + $( "#slider-range" ).slider( "values", 1 ) );
  } );

  $( function() {
  $( "#slider-range2" ).slider({
      range: true,
      min: 0,
      max: 500000,
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      	$feedback_ex = explode("-",$_POST['feedbackmin']);
		$feedbackmin = $feedback_ex[0];
		$feedbackmax = $feedback_ex[1];
		echo "values: [ ".$feedbackmin.", ".$feedbackmax." ],";
		}else{
			echo "values: [ 3000, 9000 ],";
		}
      ?>
      slide: function( event, ui ) {
        $( "#feedbackmin" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
      }
    });
    $( "#feedbackmin" ).val( $( "#slider-range2" ).slider( "values", 0 ) +
      "-" + $( "#slider-range2" ).slider( "values", 1 ) );
  } );
  </script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(".loader").fadeOut("slow");
		    $('#example').DataTable( {
		        dom: 'Bfrtip',
		        buttons: [
		            {
		                extend: 'copyHtml5',
		            },
		            'excelHtml5',
		            'csvHtml5',
		            'pdfHtml5'
		        ]
		    } );
		} );
	</script>

	<script>
	  function copyToClipboardFunc(text) {
	    CopyToClipboard(text);
	    alert("Copy Success! Paste it at eBay List Title.");

	  }
	</script>

	<style type="text/css">
		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
		}
		#example_wrapper
		{
			border: 1px solid grey;
    		padding: 10px;
		}
	</style>
</head>
<body>
<div class="loader"></div>
<div class="container">
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h2 class="text-center"><u>Hot Items</u></h2>
	</div>
</div>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="background-color: #cccaca; border: 1px solid grey;">
	<br />
		<form method="post" action="ebay-scrape-api.php" id="search">
			<div >
	    		<label>Country</label>
	    		<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
	    			$radiobuttonvalue = $_POST['country'];
	    		?>
		    		<input type="radio" name="country" value="EBAY-GB" <?php if($radiobuttonvalue == "EBAY-GB") { echo 'checked="checked"';} ?>> UK
				  	<input type="radio" name="country" value="EBAY-US" <?php if($radiobuttonvalue == "EBAY-US") { echo 'checked="checked"';} ?>> US<br>
			  	<?php } else { ?>
				  	<input type="radio" name="country" value="EBAY-GB" checked > UK
				  	<input type="radio" name="country" value="EBAY-US"> US<br>
			  	<?php } ?>
	  		</div>

	  		<div class="form-group">
			  	<label>Keyword</label>
			  	<input class="form-control" type="text" name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" placeholder="Enter keyword to search" required="required" />
		  	</div>

		  	<div class="form-group">
			  	<label>Categories</label>
			  	<select class="form-control" title="Select a category for search" name="category" id="category" required="required">
			  		<option selected="selected" value="0">All Categories</option>
					<option value="20081">Antiques</option>
					<option value="550">Art</option>
					<option value="2984">Baby</option>
					<option value="267">Books</option>
					<option value="12576">Business &amp; Industrial</option>
					<option value="625">Cameras &amp; Photo</option>
					<option value="15032">Cell Phones &amp; Accessories</option>
					<option value="11450">Clothing, Shoes &amp; Accessories</option>
					<option value="11116">Coins &amp; Paper Money</option>
					<option value="1">Collectibles</option>
					<option value="58058">Computers/Tablets &amp; Networking</option>
					<option value="293">Consumer Electronics</option>
					<option value="14339">Crafts</option>
					<option value="237">Dolls &amp; Bears</option>
					<option value="11232">DVDs &amp; Movies</option>
					<option value="6000">eBay Motors</option>
					<option value="45100">Entertainment Memorabilia</option>
					<option value="172008">Gift Cards &amp; Coupons</option>
					<option value="26395">Health &amp; Beauty</option>
					<option value="11700">Home &amp; Garden</option>
					<option value="281">Jewelry &amp; Watches</option>
					<option value="11233">Music</option>
					<option value="619">Musical Instruments &amp; Gear</option>
					<option value="1281">Pet Supplies</option>
					<option value="870">Pottery &amp; Glass</option>
					<option value="10542">Real Estate</option>
					<option value="316">Specialty Services</option>
					<option value="888">Sporting Goods</option>
					<option value="64482">Sports Mem, Cards &amp; Fan Shop</option>
					<option value="260">Stamps</option>
					<option value="1305">Tickets &amp; Experiences</option>
					<option value="220">Toys &amp; Hobbies</option>
					<option value="3252">Travel</option>
					<option value="1249">Video Games &amp; Consoles</option>
					<option value="99">Everything Else</option>
				</select>
			</div>
			<input type="hidden" name="cat" id="cat">
			
			<div class="form-group">
				<label>Feedback</label>
				<input class="form-control" type="text" value="<?php echo isset($_POST['feedbackmin']) ? $_POST['feedbackmin'] : '' ?>" id="feedbackmin" name="feedbackmin" placeholder="feedback minimum" required="required" />
				<div id="slider-range2"></div>
			</div>

			<div class="form-group">
				<label>Item Sold</label>
				<select class="form-control" name="itemsold" id="itemsold" required="required">
					<option value="0">Anyone</option>
					<option value="7">7 Days</option>
					<option value="14">14 Days</option>
					<option value="30">30 Days</option>
					<option value="60">60 Days</option>
				</select>
			</div>

			<div class="form-group">
				<label>Sort By</label>
				<select class="form-control" name="sort" id="sort" required="required">
					<?php
					  foreach($sort_orders as $key => $sort_order){
					  ?>
					      <option value="<?php echo $key; ?>"><?php echo $sort_order; ?></option>
					<?php 
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<label>Listing Type</label>
				<select class="form-control" name="listingtype" id="listingtype" required="required">
					<option value="All" selected="selected">All</option>
					<option value="Auction">Auction</option>
					<option value="AuctionWithBIN">Auction With BIN</option>
					<option value="Classified">Classified</option>
					<option value="FixedPrice">Fixed Price</option>
					<option value="StoreInventory">Store Inventory</option>
				</select>
			</div>

			<div class="form-group">
				<label>Condition Type</label>
				<select class="form-control" name="conditiontype" id="conditiontype" required="required">
					<option value="All" selected="selected">All</option>
					<option value="1000">New</option>
					<option value="1500">New other</option>
					<option value="1750">New with defects</option>
					<option value="2000">Manufacturer refurbished</option>
					<option value="2500">Seller refurbished</option>
					<option value="3000">Used</option>
					<option value="4000">Very Good</option>
					<option value="5000">Good</option>
					<option value="6000">Acceptable</option>
					<option value="7000">For parts or not working</option>
				</select>
			</div>

			<div class="form-group">
				<label>Price</label>
				<input class="form-control" id="pricemin" type="text" name="pricemin" placeholder="price minimum"  required="required" value="<?php echo isset($_POST['pricemin']) ? $_POST['pricemin'] : '' ?>" />
				
				<div id="slider-range"></div>
			</div>

			<div class="form-group">
				<label>Min. Quantity (Leave Empty For Default)</label>
				<input class="form-control" type="number" name="minQty" value="<?php echo isset($_POST['minQty']) ? $_POST['minQty'] : '' ?>" />
			</div>

			<div class="form-group">
				<label>Max. Quantity (Leave Empty For Default)</label>
				<input class="form-control" type="number" name="maxQty" value="<?php echo isset($_POST['maxQty']) ? $_POST['maxQty'] : '' ?>" />
			</div>

			<div class="form-group">
				<label>Items Find</label>
				<input class="form-control" type="number" name="itemsfind" required="required" value="<?php echo isset($_POST['itemsfind']) ? $_POST['itemsfind'] : '' ?>" />
			</div>

			<div class="form-group" style="float:right;">
				<input type="submit" class="btn btn-success" />
			</div>
		</form>
	</div>
</div>
<br />
<hr />
<br />
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Item Title</th>
            <th>Category</th>
            <th>Username</th>
            <th>Feedbacks</th>
            <th>eBay Sales</th>
            <th>Price Target</th>
            <th>Currency</th>
            <th>Link</th>
        </tr>
    </thead>
    <tbody>
    	<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ebay = new ebay('Hassnain-WebShop-PRD-d08fa563f-a6f7b979', $_POST['country']);

			$keyword= str_replace(" ", "+", $_POST['keyword']);
			$price_ex = explode("-",$_POST['pricemin']);
			$pricemin = $price_ex[0];
			$pricemax = $price_ex[1];
			$category = "";
			$limit = $_POST['itemsfind'];
			$imgSrc= "";
			$itemtitle = "";
			$productLink = "";
			$sellerUsername = "";
			$price = "";
			$sold= '';
			$feedbacks_rplc='';
			$id= 1;
			$feedback_ex = explode("-",$_POST['feedbackmin']);
			$feedbackmin = $feedback_ex[0];
			$feedbackmax = $feedback_ex[1];
			
			$results = $ebay->findItemsAdvanced($_POST['keyword'], $_POST['category'], $_POST['sort'], $_POST['listingtype'], $_POST['conditiontype'], $pricemin, $pricemax, $feedbackmin, $feedbackmax, $limit, $_POST['country'], $_POST['maxQty'], $_POST['minQty']);

		    $item_count = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['@count'];
		  
		    if($item_count > 0){
		        $items = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['item'];
		        
		        foreach($items as $i)
		        {
		        	$itemtitle = $i['title'][0];
		        	$imgSrc= $i['galleryURL'][0];
		        	$price = $i['sellingStatus'][0]['currentPrice'][0]['__value__'];
		        	$currency = utf8_decode($i['sellingStatus'][0]['currentPrice'][0]['@currencyId']);
		        	$category = $i['primaryCategory'][0]['categoryName'][0];
		        	$productLink = $i['viewItemURL'][0];
		        	$itemID = $i['itemId'][0];

		        	$itemResults = $ebay->getSingleItem($itemID, $_POST['country']);
		        	
		        	$sellerUsername = $itemResults['Item']['Seller']['UserID'];
		        	$feedbacks_rplc = $itemResults['Item']['Seller']['FeedbackScore'];
		        	$sold = $itemResults['Item']['QuantitySold'];
		        	
					echo "<tr>";
					echo "<td>".$id."</td>";
					echo "<td><img style='width:150px; height:auto;' src='".$imgSrc."' /></td>";
					echo "<td>".$itemtitle." <button data-id='".$itemtitle."' onclick='copyToClipboardFunc($(this).attr(\"data-id\"))'>Copy</button></td>";
					if($_POST['category']=='0')
					{
						echo "<td>".$category."</td>";
					}
					else
					{
						echo "<td>".$_POST['cat']."</td>";
					}
					
					echo "<td>".$sellerUsername."</td>";
					echo "<td>".$feedbacks_rplc."</td>";
					echo "<td>".intval($sold)."</td>";
					echo "<td>".utf8_decode($price)."</td>";
					echo "<td>".$currency."</td>";
					echo "<td><a class='btn btn-sm btn-primary' href='".$productLink."' target='_blank'>View on eBay</td>";
					$id++;
					echo "</tr>";
		        }
		    }
		    else
		    {
		    	echo "No Items Found!";
		    }
		}
		?>
    </tbody>
</table>

</div>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
	<script type="text/javascript">
	  document.getElementById('category').value = "<?php echo $_POST['category'];?>";
	  document.getElementById('itemsold').value = "<?php echo $_POST['itemsold'];?>";
	  document.getElementById('sort').value = "<?php echo $_POST['sort'];?>";
	  document.getElementById('listingtype').value = "<?php echo $_POST['listingtype'];?>";
	  document.getElementById('conditiontype').value = "<?php echo $_POST['conditiontype'];?>";
	  
	  $('#category').on('change', function(){
	  	$('#cat').val($('#category option:selected').text());
	  });
	</script>
<?php } ?>
</body>
</html>