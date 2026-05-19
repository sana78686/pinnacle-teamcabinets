<?php
	$db = \Config\Database::connect();
	$user_id ="";
	if($full_order_data['0']['affiliate_id'] != 0)
	{
		$user_id = $full_order_data['0']['affiliate_id'];
	} else {
		$user_id = $full_order_data['0']['user_id'];
	}
	$user_name_query = $db->query("SELECT * FROM user_register WHERE id = ?", [$user_id]);
	$user_results = $user_name_query->getResultArray();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AdminLTE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<div class="box box-primary">
	<!-- <div style="width:100%;float:left; margin-left:15px;">
		<label>Hello Warehouse, <br>
	</div>
	<div style="width:100%;float:left; margin-left:15px;">
		<br>
		<label>New order is placed. Please find below the product details:</label>  
		<br>
	</div> --><br/>	
	<h4 style="width:100%;float:left; margin-left:15px;">Warehouse Pick List</h4><br>
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 		
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc; border-top:3px solid #398ebd; border-collapse: collapse;">
                  
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px 20px 20px 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">							
							<tr>
							  <td width="300">
							    <table border="0" cellpadding="0" cellspacing="0" width="100%">
								 <tr>
                                    <td style="color: #333; font-family: Arial, sans-serif; font-size: 22px;">
                                        <b>TEAM DISTRIBUTORS</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px 0 15px 0; color: #153643; font-family: Arial, sans-serif; font-size: 13px; line-height: 5px;">
                                       <p>152 Baywood Ave</p>
					 				   <p>Longwood, FL 32750</p>
									   <p>+1 8337822697</p>
                                    </td>
                                </tr>
								
								</table>
							  </td>
							  <!-- <td valign="top"><img src="<?php //echo base_url()."/assets/user_img/".$user_results[0]['image'];?>" width="200" height="100" alt=""/></td> -->
							  <td valign="top"><img src="<?php echo base_url()."/assets/front_site_assets/images/logo_email.jpg" ;?>" width="200px" height="100px"></td>
							  <td valign="top" style="padding:0px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 13px; line-height:5px;">
							    <p style="margin-top:0;">team@teamcabinets.com</p>
							    <p>www.teamcabinets.com</p>
							  </td>
							</tr>
							
							
						    	 <tr>
                                    <td style="color: #333; font-family: Arial, sans-serif; font-size: 22px; padding-bottom:15px;" colspan="3">
                                        <b>PICK LIST</b>
                                    </td>
								</tr>
									<tr>
									<td colspan="3">
									 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color: #333; font-family: Arial, sans-serif; font-size:13px; line-height:20px;">
									    <tr>
										 <td style="color: #333; font-family: Arial, sans-serif; font-size:18px;">
										   <b>Bill To:</b>
										 </td>
										  <td style="color: #333; font-family: Arial, sans-serif; font-size:18px;">
										   <b>Ship To:</b>
										 </td>
										  <td style="color: #333; font-family: Arial, sans-serif; font-size:18px;">
										 
										 </td>
										</tr>
										<?php 
											$bill_address = json_decode($full_order_data['0']['bill_to_address']);
											$bill_city = json_decode($full_order_data['0']['bill_to_city']); 
											$bill_county = json_decode($full_order_data['0']['bill_to_county']); 
											$bill_state = json_decode($full_order_data['0']['bill_to_state']); 
											$bill_zipcode = json_decode($full_order_data['0']['bill_to_zipcode']); 
											$bill_country = json_decode($full_order_data['0']['bill_to_country']); 
											$ship_address = json_decode($full_order_data['0']['ship_to_address']);
											$ship_city = json_decode($full_order_data['0']['ship_to_city']); 
											$ship_county = json_decode($full_order_data['0']['ship_to_county']); 
											$ship_state = json_decode($full_order_data['0']['ship_to_state']); 
											$ship_zipcode = json_decode($full_order_data['0']['ship_to_zipcode']); 
											$ship_country = json_decode($full_order_data['0']['ship_to_country']); 

										?>
										<tr>
										    <td><b>Name:</b> <?php $bill_name = json_decode($full_order_data['0']['bill_to_name']); echo $bill_name['0'];  ?></td>
										    <td><b>Name:</b> <?php $ship_to_name = json_decode($full_order_data['0']['ship_to_name']); echo $ship_to_name['0'];  ?></td>
										    <td><b>Order #:</b> <?php echo $full_order_data['0']['id']; ?> </td>
										</tr>
										<tr>
										    <td style="line-height:15px;" valign="top"><b>Address:</b> <?php echo $bill_address[0].", ".$bill_city[0].", ".$bill_county[0].",<br> ".$bill_state[0].", ".$bill_zipcode[0].", ".$bill_country[0];  ?></td>
										    <td style="line-height:15px;" valign="top"><b>Address:</b> <?php echo $ship_address[0].", ".$ship_city[0].", ".$ship_county[0].",<br>  ".$ship_state[0].", ".$ship_zipcode[0].", ".$ship_country[0];  ?></td>
										    <td valign="top"><b>Date:</b> 
										    	<?php
													  $date = $full_order_data['0']['created_at'];
													  $date=substr($date, 0, strrpos($date, ' '));
													  $newDate = date("m-d-Y", strtotime($date));  
													  echo $newDate;  
													  ?> 
											</td>
										</tr>
										<tr>
										    <td><b>Email:</b> <?php $bill_email = json_decode($full_order_data['0']['bill_to_email']); echo $bill_email['0'];  ?> </td>
										    <td><b>Email:</b> <?php $ship_to_email = json_decode($full_order_data['0']['ship_to_email']); echo $ship_to_email['0'];  ?> </td>
										    <td></td>
										</tr>
										<tr>
										    <td><b>Phone:</b> <?php $bill_phone = json_decode($full_order_data['0']['bill_to_phone']); echo $bill_phone['0'];  ?> </td>
										    <td><b>Phone:</b> <?php $ship_to_phone = json_decode($full_order_data['0']['ship_to_phone']); echo $ship_to_phone['0'];  ?> </td>
										    <td></td>
										</tr>
									 </table>
									</td>
									</tr>
									
									<tr>
									  <td colspan="3" height="10">
									  
									  </td>
									 </tr>
									
									<tr>
									  <td colspan="3">
									    <table border="0" cellpadding="5" cellspacing="0" width="100%" style="color: #333; font-family: Arial, sans-serif; font-size:13px; line-height:20px;">
										  <tr style="background:#dedfde;">
										   <td><b>Double Check Work</b></td>
										   <td><b>Product</b></td>
										   <td><b>Description</b></td>
										   <td align="right"><b>Quantity</b></td>
										   <td align="right"><b>Unit Weight</b></td>
										   <td align="right"><b>Total Weight</b></td> 
										  </tr>	

							 <?php
								$all_weight_total =0;
								$all_total = "0";
								$replaceString = array('"',']','[','lbs');
								$finalCartWeight = str_replace($replaceString,'', $full_order_data['0']['cart_product_weight']);
								$room_data = json_decode($full_order_data['0']['room_data']);

								foreach($room_data as $key => $val)
								{
									?><!--<tr><th colspan="5"><?php //echo $key; ?></th></tr>--><?php
									$sku_val = $val->product_sku;
									$weight_val = $val->product_weight;
									$cost_val = $val->product_cost;
									$cabinets_id_val = $val->product_cabinets_id;
									$quantity = $val->product_quantity;
									$product_description = $val->product_cabinets_description;
									$checkbox_val1 = $val->checkbox_val1;
									$checkbox_val2 = $val->checkbox_val2;
									$cabinet_tot_price = $val->product_tot_price;
									$product_actual_price = $val->product_actual_price;
									$product_details = $val->product_details;
									$product_cabinets_color = $val->product_cabinets_color;
									
									$count_sku = is_array($sku_val) ? count($sku_val) : 0;
									$cart_product = array();
									for($i=0;$i<$count_sku;$i++)
									{
										$cart_product[$i]['sku'] = $sku_val[$i];
										$cart_product[$i]['weight'] = $weight_val[$i];
										$cart_product[$i]['cost'] = $cost_val[$i];
										$cart_product[$i]['cabinets_id'] = $cabinets_id_val[$i];
										$cart_product[$i]['quantity'] = $quantity[$i];
										$cart_product[$i]['product_description'] = $product_description[$i];
										$cart_product[$i]['cabinet_tot_price'] = $cabinet_tot_price[$i];
										$cart_product[$i]['product_actual_price'] = $product_actual_price[$i];
										$cart_product[$i]['product_details'] = $product_details[$i];
										$cart_product[$i]['checkbox_val1'] = $checkbox_val1[$i];
										$cart_product[$i]['checkbox_val2'] = $checkbox_val2[$i];
										$cart_product[$i]['product_cabinets_color'] = $product_cabinets_color[$i];

									}

									foreach($cart_product as $cart_product1)
									{
										$all_total = $all_total + $cart_product1['cost'] * $cart_product1['quantity'];
										$all_total_actual_cost = $all_total_actual_cost + $cart_product1['product_actual_price'] * $cart_product1['quantity'];
										$all_weight_total = $all_weight_total + $cart_product1['weight'] * $cart_product1['quantity'];
										$q1 = "SELECT * from cabinets_product where sku = '".$cart_product1['sku']."'";
										$query1 = $db->query($q1);
										$results = $query1->getResultArray();	
										$cab_name = "SELECT * FROM cabinets_name WHERE id = '" . $results[0]['cabinets_name'] . "'";
										$cab_name_query = $db->query($cab_name);
										$cab_results = $cab_name_query->getResultArray();
										?>
										<tr>
										  <td><label class='container_chk_lbl'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val1'] == 1) ? "checked" : "";?> disabled><span class='checkmark' ></span></label><label class='container_chk_lbl_01'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val2'] == 1) ? "checked" : "";?> disabled><span class='checkmark'></span></td>
										  <td><?php echo $cart_product1['sku']." - ".$cart_product1['product_cabinets_color']; ?></td>
										   <td><?php echo $cart_product1['product_details']; ?></td>
										    <td align="right"><?php echo $cart_product1['quantity']; ?></td>
											  <td align="right"><?php echo $cart_product1['weight']." lbs"; ?></td> 
											   <td align="right"><?php $total_weight = $cart_product1['weight'] * $cart_product1['quantity']; echo $total_weight." lbs"; ?></td> 
										</tr>
										<?php
									}		
								}	
							?>
										<!-- <tr>
										  <td>Sep900</td>
										   <td>Test</td>
										   <td align="right">1</td>
											 <td align="right">$900.00</td>
											  <td align="right">$900.00</td>
										</tr> -->
										<?php //$discount =  $all_total_actual_cost - $all_total; ?>
										<!-- <tr>
										  <td></td>	
										  <td>Discount Amount</td>
										   <td>Dealer Discount</td>
										    <td align="right">1</td>
											 <td align="right"><?php //echo "-$".number_format((float)$discount, 2, '.', ''); ?></td>
											  <td align="right"><?php //echo "-$".number_format((float)$discount, 2, '.', ''); ?></td>
										</tr> -->	

										<tr>
										  <td height="10" colspan="5"></td>
										</tr>
										
										<tr>
										  <td style="color:#d6d3de;" colspan="2" rowspan="2" valign="top">THANK YOU FOR YOUR <br/> BUSINESS!</td>
										  <td></td>
										    <td align="right"><b>TOTAL WEIGHT</b></td>
										    <td align="right"></td>
											<td align="right"><?php echo $all_weight_total." lbs"; ?></td> 
										</tr>

										<!--<tr>
											<td></td>
										    <td align="right"><b>SALES TAX (<?php //echo $full_order_data['0']['sales_tax']; ?>%)</b></td>
											 <td align="right"></td>
											  <td align="right"><?php
													//$sales_tax =  ( ($all_total * $full_order_data['0']['sales_tax']) / 100);

													//$sales_tax = number_format((float)$sales_tax, 2, '.', '');

													//echo "$".$sales_tax;
													 ?>
												</td>
										</tr> -->
										
<!-- 										<tr>
											<td></td>
											<td></td>
										    <td></td>
										    <td align="right"><b>SHIPPING</b></td>
											 <td align="right"></td>
											  <td align="right"><?php //if($full_order_data['0']['shipping_cost'] == "Provide me with shipping amount via email/phone") { echo "<b>TBD</b>"; } else { echo $full_order_data['0']['shipping_cost']; } ?></td>
										</tr> -->
										
										<!-- <tr>
											<td></td>
										  <td></td>
										   <td></td>
										    <td align="right"><b>TOTAL</b></td>
											 <td align="right"></td>
											  <td align="right"><?php 
														//$grand_total = $all_total + $sales_tax;

														//echo "$".number_format((float)$grand_total, 2, '.', '');
													?>
											   </td>
										</tr> -->
										
										
										<!-- <tr>
											<td></td>
										  <td></td>
										   <td></td>
										    <td align="right"><b>PAYMENT</b></td>
											 <td align="right"></td>
											  <td align="right"><?php //echo "$".number_format((float)$grand_total, 2, '.', ''); ?></td>
										</tr> -->
										
										<!-- <tr>
											<td></td>
										  <td></td>
										   <td></td>
										    <td align="right"><b>BALANCE DUE</b></td>
											 <td align="right"></td>
											  <td align="right">$0.00</td>
										</tr> -->
										
										<!-- <tr>

										  <td colspan="6" style="color:#008200; font-size:20px;" align="right"><b>PAID</b></td>										   
										</tr> -->
										
										</table>
									  </td>
									</tr>									
                            </table>
                        </td>
                    </tr>			
                  
                </table>
            </td>
        </tr>
    </table>
	<!-- <div style="width:100%;float:left; margin-left:15px;">
		<label><br>Regards,</label>
	</div>
	<div style="width:100%;float:left; margin-left:15px;">
		<label>Team Cabinets</label> 
	</div> -->
</div>	    
</body>
</html>