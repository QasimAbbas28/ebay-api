
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
  <script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 15000,
      values: [ 3000, 9000 ],
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
      max: 15000,
      values: [ 3000, 9000 ],
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
	  function copyToClipboard(text) {
	    window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
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
		<form method="post" action="ebay-scrape.php" id="search">
			<div >
	    		<label>Country</label>
	    		<input type="radio" name="country" value="UK" checked> UK
			  	<input type="radio" name="country" value="US"> US<br>
	  		</div>

	  		<div class="form-group">
			  	<label>Keyword</label>
			  	<input class="form-control" type="text" name="keyword" placeholder="Enter keyword to search" required="required" />
		  	</div>

		  	<div class="form-group">
			  	<label>Categories</label>
			  	<select class="form-control" title="Select a category for search" name="category" required="required">
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
			
			<div class="form-group">
				<label>Feedback</label>
				<input class="form-control" type="text" id="feedbackmin" name="feedbackmin" placeholder="feedback minimum" required="required" />
				<input class="form-control" type="hidden" name="feedbackmax" placeholder="feedback maximum" />
				<div id="slider-range2"></div>
			</div>

			<div class="form-group">
				<label>Item Sold</label>
				<select class="form-control" name="itemsold" required="required">
					<option value="0">Anyone</option>
					<option value="7">7 Days</option>
					<option value="14">14 Days</option>
					<option value="30">30 Days</option>
					<option value="60">60 Days</option>
				</select>
			</div>

			<div class="form-group">
				<label>Price</label>
				<input class="form-control" id="pricemin" type="text" name="pricemin" placeholder="price minimum"  required="required"/>
				<input class="form-control" id="pricemax" type="hidden" name="pricemax" placeholder="price maximum" />
				<div id="slider-range"></div>
			</div>

			<div class="form-group">
				<label>Items Find</label>
				<input class="form-control" type="number" name="itemsfind" required="required">
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
            <th>Link</th>
        </tr>
    </thead>
    <tbody>
    	<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     		$internalErrors = libxml_use_internal_errors(true);
     		include("simple_html_dom.php");

			$dom = new DOMDocument();
			$web = "http://www.ebay.com";
			if($_POST['country']=='UK')
			{
				$web = "http://www.ebay.co.uk";
			}
			$keyword= str_replace(" ", "+", $_POST['keyword']);
			$price_ex = explode("-",$_POST['pricemin']);
			$pricemin = $price_ex[0];
			$pricemax = $price_ex[1];
			// var_dump($web."/sch/i.html?_nkw=".$keyword."&_in_kw=1&_ex_kw=&_sacat=".$_POST['category']."&_udlo=".$pricemin."&_udhi=".$pricemax."&_ftrt=901&_ftrv=1&_sabdlo=&_sabdhi=&_samilow=&_samihi=&_sadis=15&_stpos=&_sargn=-1%26saslc%3D1&_salic=1&_sop=12&_dmd=1&_ipg=200&rt=nc");die;
			$dom->loadHTML(file_get_contents($web."/sch/i.html?_nkw=".$keyword."&_in_kw=1&_ex_kw=&_sacat=".$_POST['category']."&_udlo=".$pricemin."&_udhi=".$pricemax."&_ftrt=901&_ftrv=1&_sabdlo=&_sabdhi=&_samilow=&_samihi=&_sadis=15&_stpos=&_sargn=-1%26saslc%3D1&_salic=1&_sop=12&_dmd=1&_ipg=200&rt=nc"));

			$categories = $dom->getElementById("gh-cat");
			$catOptions = $categories->getElementsByTagName('option');
			$category = "";
			foreach ($catOptions as $key => $value) {
				if($value->getAttribute('value')==$_POST['category'])
				{
					$category = $value->nodeValue;
					break;
				}
			}

			$listView = $dom->getElementById("ListViewInner");
			$listItems = $listView->getElementsByTagName('li');
			$id= 1;

			foreach ($listItems as $listItem) {
				if($id>$_POST['itemsfind'])
				{
					break;
				}

				$imgSrc= "";

				$image = $listItem->getElementsByTagName('img');
				foreach ($image as $img) {
					    $imgSrc= $img->getAttribute('src');
						break;
				}
				$itemtitle = "";
				$title = $listItem->getElementsByTagName('h3');
				foreach ($title as $key => $h3) {
					$itemtitle = str_replace("New listing", " ", $h3->nodeValue);	
				}
				
				$productLink = "";
				$anchor = $listItem->getElementsByTagName('a');
				$sellerUsername = "";
				$price = "";
				foreach ($anchor as $a) {
					
					$dom2 = new DOMDocument();
					$productLink = $a->getAttribute('href');
					$dom2->loadHTML(file_get_contents($productLink));
					$finder = new DomXPath($dom2);
					$classname="mbg-l";
					$feedbacks = "0";
					$nodes = $finder->query("//*[contains(@class, '$classname')]");
					foreach ($nodes as $n) {
						$feedbacks = $n->nodeValue;
					}

					$classname="vi-qtyS";
					$sold = "0";
					$nodes_sold = $finder->query("//*[contains(@class, '$classname')]");
					foreach ($nodes_sold as $n) {
						$sold = $n->nodeValue;
					}
					$usernameAnchor = $dom2->getElementById("mbgLink");
					$username="";
					if(!empty($usernameAnchor)){
						$username = $usernameAnchor->getElementsByTagName('span');
						foreach ($username as $u) {
							$sellerUsername = $u->nodeValue;
							
						}
					}
					
					$domPrice = $dom2->getElementById("prcIsum");
					if(!empty($domPrice))
					{
						$price = $domPrice->nodeValue;	
					}
					else
					{
						$price = "Not Found";
					}					
					break;
				}
				$feedback_ex = explode("-",$_POST['feedbackmin']);
				$feedbackmin = $feedback_ex[0];
				$feedbackmax = $feedback_ex[1];
				
				$feedbacks_rplc = str_replace("(", "", $feedbacks);
				$feedbacks = str_replace(")", "", $feedbacks_rplc);
				$feedbacks_rplc = str_replace(" ", "", $feedbacks);
				$feedbacks_rplc = preg_replace('/\s+/', '', $feedbacks_rplc);

				if($itemtitle!="" && $id<=$_POST['itemsfind'] && ($feedbacks_rplc>=$feedbackmin && $feedbacks_rplc<=$feedbackmax)){
					echo "<tr>";
					echo "<td>".$id."</td>";
					echo "<td><img style='width:150px; height:auto;' src='".$imgSrc."' /></td>";
					echo "<td>".$itemtitle." <button data-id='".$itemtitle."' onclick='copyToClipboard($(this).attr(\"data-id\"))'>Copy</button></td>";
					echo "<td>".$category."</td>";
					echo "<td>".$sellerUsername."</td>";
					echo "<td>".$feedbacks_rplc."</td>";
					echo "<td>".intval($sold)."</td>";
					echo "<td>".utf8_decode($price)."</td>";
					echo "<td><a class='btn btn-sm btn-primary' href='".$productLink."' target='_blank'>View on eBay</td>";
					$id++;
					echo "</tr>";
				}
			}

			libxml_use_internal_errors($internalErrors);
		} ?>
    </tbody>
</table>

</div>
</body>
</html>