<?php
require_once('class.ebay.php');

$ebay = new ebay('YOUR EBAY API ID HERE', 'EBAY-US');
$sort_orders = $ebay->sortOrders();
?>

<form action="app.php" method="post">
  <input type="text" name="search" id="search">
  <select name="sort" id="sort">
  <?php
  foreach($sort_orders as $key => $sort_order){
  ?>
      <option value="<?php echo $key; ?>"><?php echo $sort_order; ?></option>
  <?php 
  }
  ?>
  </select>
  <input type="submit" value="Search">
</form>

<?php
if(!empty($_POST['search'])){

  $results = $ebay->findItemsAdvanced($_POST['search'], $_POST['sort']);
   echo "<pre>";
        print_r($results);
        echo "</pre>";
        die;
  $item_count = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['@count'];
  
  if($item_count > 0){
      $items = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['item'];

      foreach($items as $i){
        echo "<pre>";
        print_r($i);
        echo "</pre>";
        die;
?>
      <li>
          <div class="item_title">
              <a href="<?php echo $i['viewItemURL'][0]; ?>"><?php echo $i['title'][0]; ?></a>
          </div>
          <div class="item_img">
              <img src="<?php echo $i['galleryURL'][0]; ?>" alt="<?php echo $i['title']; ?>">
          </div>
          <div class="item_price">
              <?php echo $i['sellingStatus'][0]['currentPrice'][0]['@currencyId']; ?>
              <?php echo $i['sellingStatus'][0]['currentPrice'][0]['__value__']; ?>
          </div>
      </li>
<?php
      }
  }        
}
?>