<?php
class ebay{
	private $url = 'http://svcs.ebay.com/services/search/FindingService/v1';
	private $app_id; //api key
	private $global_id; //e-bay region (eg. EBAY-US)
	private $version = '1.0.0'; //version of the API to use
	private $format = 'json'; //format of the returned data 

	public function __construct($app_id, $global_id){
	  $this->app_id = $app_id;
	  $this->global_id = $global_id;
	}

	public function getSingleItem($itemID = '', $siteid= 0){
		$url='';
		if($siteid == 'EBAY-GB')
		{
			$url= "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=".$this->app_id."&siteid=3&version=967&ItemID=".$itemID."&IncludeSelector=Details";
		}
		$url= "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=".$this->app_id."&siteid=0&version=967&ItemID=".$itemID."&IncludeSelector=Details";

	  	return json_decode(file_get_contents($url), true);
	}

	public function findItems($keyword = '', $limit = 2){

	  $url    = $this->url . '?';
	  $url .= 'operation-name=findItemsByKeywords';
	  $url .= '&service-version=' . $this->version;
	  $url .= '&keywords=' . urlencode($keyword);
	  $url .= '&paginationInput.entriesPerPage=' . $limit;
	  
	  $url .= '&security-appname='. $this->app_id;
	  $url .= '&response-data-format=' . $this->format;

	  return json_decode(file_get_contents($url), true);
	}

	public function findItemsAdvanced($keyword = '', $category_id='0', $item_sort = 'BestMatch', $item_type = 'FixedPriced', $condition_type='All', $min_price = '0', $max_price = '9999999', $min_feedbacks='0', $max_feedbacks='9999999', $limit = 2, $siteid= 'EBAY-US', $max_qty = "1", $min_qty = "1"){

      $url    = $this->url . '?';
      $url .= 'operation-name=findItemsAdvanced';
      $url .= '&service-version=' . $this->version;
      $url .= '&global-id=' . $siteid;
      $url .= '&keywords=' . urlencode($keyword);
      if($category_id!='0')
      {
      	$url .= '&categoryId=' . $category_id;
      }
      $url .= '&sortOrder='. $item_sort;
      $url .= '&itemFilter(0).name=ListingType';
      $url .= '&itemFilter(0).value='. $item_type;
      $url .= '&itemFilter(1).name=MinPrice';
      $url .= '&itemFilter(1).value=' . $min_price;
      $url .= '&itemFilter(2).name=MaxPrice';
      $url .= '&itemFilter(2).value=' . $max_price;
      $url .= '&itemFilter(3).name=FeedbackScoreMin';
      $url .= '&itemFilter(3).value=' . $min_feedbacks;
      $url .= '&itemFilter(4).name=FeedbackScoreMax';
      $url .= '&itemFilter(4).value=' . $max_feedbacks;
      
      if($min_qty!='' && $max_qty!='')
      {
      	$url .= '&itemFilter(5).name=MinQuantity';
      	$url .= '&itemFilter(5).value='. $min_qty;
      	$url .= '&itemFilter(6).name=MaxQuantity';
      	$url .= '&itemFilter(6).value='. $max_qty;
      }
      if($condition_type!='All')
      {
      	$url .= '&itemFilter(7).name=Condition';
      	$url .= '&itemFilter(7).value='. $condition_type;
      }
      $url .= '&paginationInput.entriesPerPage=' . $limit;
      $url .= '&descriptionSearch=false';

      $url .= '&security-appname='. $this->app_id;
      $url .= '&response-data-format=' . $this->format;
      // var_dump($url);die;
      return json_decode(file_get_contents($url), true);
  	}

  	public function sortOrders(){

	  $sort_orders = array(
	      'BestMatch' => 'Best Match',
	      'BidCountFewest' => 'Bid Count Fewest',
	      'BidCountMost' => 'Bid Count Most',
	      'CountryAscending' => 'Country Ascending',
	      'CountryDescending' => 'Country Descending',
	      'CurrentPriceHighest' => 'Current Highest Price',
	      'DistanceNearest' => 'Nearest Distance',
	      'EndTimeSoonest' => 'End Time Soonest',
	      'PricePlusShippingHighest' => 'Price Plus Shipping Highest',
	      'PricePlusShippingLowest' => 'Price Plus Shipping Lowest',
	      'StartTimeNewest' => 'Start Time Newest'
	  );

	  return $sort_orders;
	}
	
}
?>