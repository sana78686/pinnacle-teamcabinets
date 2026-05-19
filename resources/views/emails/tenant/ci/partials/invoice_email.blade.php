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
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" style="border: 1px solid #cccccc; border-top:3px solid #398ebd; border-collapse: collapse;">
                  
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px 20px 20px 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">							
							<tr>
							  <td style="width:35%" valign="top">
							    <table border="0" cellpadding="0" cellspacing="0" width="100%">
								 <tr>
                                    <td style="color: #000; font-family: Arial, sans-serif; font-size: 20px;margin-top:0px;">
                                        <b>TEAM DISTRIBUTORS</b>
                                    </td>
                                </tr>
                                <tr style="padding: 0px;">
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 15px; line-height:22px;">
                                       <p style="margin-top:5px;">152 Baywood Ave<br>
					 				   Longwood, FL 32750<br>
									   +1 8337822697</p>
                                    </td>
                                </tr>
								
								</table>
							  </td>
							  <!-- <td valign="top"><img src="<?php //echo base_url()."/assets/user_img/".$user_results[0]['image'];?>" width="200" height="100" alt=""/></td> -->
							  <td  valign="top" style="margin-right: 0px; text-align:center; width:30%;"><img src="<?php echo base_url()."/assets/front_site_assets/images/logo_email.jpg" ;?>" width="130" height="auto">
							  </td>
							  <td valign="top" style="width:35%;padding:0px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 15px; line-height:20px;">
							    <p style="margin-top:0;margin-bottom:10px; text-align:right;"><a href="mailto:team@teamcabinets.com" style="color:#222;">team@teamcabinets.com</a></p>
							    <p style="margin-top:0; margin-bottom:10px; text-align:right;"><a style="color:#222;" href="https://teamcabinets.com/">www.teamcabinets.com</a></p>
							  </td>
							</tr>
							
							
						    	 <tr>
                                    <td style="color: #000; font-family: Arial, sans-serif; font-size:18px; padding-bottom:5px;padding-top:5px;" colspan="3">
                                        <b>INVOICE</b>
                                    </td>
								</tr>
									<tr>
									<td colspan="3">
									 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5f5;color: #333; font-family: Arial, sans-serif; font-size:13px; line-height:20px;">
									    <tr>
										 <td style="color: #000; font-family: Arial, sans-serif; font-size:16px; padding: 8px 10px;">
										   <b>Bill To:</b>
										 </td>
										  <td style="color: #000; font-family: Arial, sans-serif; font-size:16px;padding: 8px 10px;">
										   <b>Ship To:</b>
										 </td>
										  <td style="color: #000; font-family: Arial, sans-serif; font-size:16px;padding: 8px 10px;">
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
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Name:</b> <?php $bill_name = json_decode($full_order_data['0']['bill_to_name']); echo $bill_name['0'];  ?></td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Name:</b> <?php $ship_to_name = json_decode($full_order_data['0']['ship_to_name']); echo $ship_to_name['0'];  ?></td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Order #:</b> <?php echo $full_order_data['0']['id']; ?> </td>
										</tr>
										<tr>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;" valign="top"><b>Address:</b> <?php echo $bill_address[0].", ".$bill_city[0].", ".$bill_county[0].",<br> ".$bill_state[0].", ".$bill_zipcode[0].", ".$bill_country[0];  ?></td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;" valign="top"><b>Address:</b> <?php echo $ship_address[0].", ".$ship_city[0].", ".$ship_county[0].",<br>  ".$ship_state[0].", ".$ship_zipcode[0].", ".$ship_country[0];  ?></td>
											<?php 
											$invoice_id = isset($full_order_data[0]['quickbook_invoice_id']) && !empty($full_order_data[0]['quickbook_invoice_id']) ? $full_order_data[0]['quickbook_invoice_id']: 'N/A';?>
											<td style="padding: 5px 10px;color:#000;font-size:14px;"><b>QuickBooks #:</b> <?php echo $invoice_id; ?> </td>

										</tr>
										<tr>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Email:</b> <?php $bill_email = json_decode($full_order_data['0']['bill_to_email']); echo getFirstEmail($bill_email['0']);  ?> </td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Email:</b> <?php $ship_to_email = json_decode($full_order_data['0']['ship_to_email']); echo getFirstEmail($ship_to_email['0']);  ?> </td>
										    <td valign="top" style="padding: 5px 10px;color:#000;font-size:14px;"><b>Date:</b> 
										    	<?php
													  $date = $full_order_data['0']['created_at'];
													  $date=substr($date, 0, strrpos($date, ' '));
													  $newDate = date("m-d-Y", strtotime($date));  
													  echo $newDate;  
													  ?> 
											</td>
										</tr>
										<tr>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Phone:</b> <?php $bill_phone = json_decode($full_order_data['0']['bill_to_phone']); echo $bill_phone['0'];  ?> </td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"><b>Phone:</b> <?php $ship_to_phone = json_decode($full_order_data['0']['ship_to_phone']); echo $ship_to_phone['0'];  ?> </td>
										    <td style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr>
										    <td colspan="3" style="padding: 5px 10px;color:#000;font-size:14px;"><b>Company Name:</b> <?php $userCompanyName = !empty(getUserCompanyName($full_order_data['0']['user_id'])) ? getUserCompanyName($full_order_data['0']['user_id']) : "N/A"; echo $userCompanyName;?></td>
										</tr>
									 </table>
									</td>
									</tr>									
									<tr>
									  <td colspan="3" height="10" style="font-size:16px; padding-bottom:10px; padding-top:15px;">
										<b>Job Name</b> : <?php $job_name = json_decode($full_order_data['0']['job_name']); echo $job_name[0];  ?>
									  </td>
									</tr>
									
									<tr>
									  <td colspan="3">
									    <table border="0" cellpadding="5" cellspacing="0" width="100%" style="color: #333; font-family: Arial, sans-serif; font-size:14px; line-height:20px;">
											<tr style="background:#f5f5f5;">
												<td style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Double Check Work</b>
												</td>
												<td style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Product</b>
												</td>
												<td style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Description</b>
												</td>
												<td style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Weight</b>
												</td>
												<td style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Quantity</b>
												</td>
												<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Unit Price</b>
												</td>
												<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Amount</b>
												</td>
											   <?php if($full_order_data['0']['assemble_cabinetry_charged'] > 0) 
												{ 
												$extra_row ="<td></td>"; 
												?>
												<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;" valign="middle">
													<b>Assemble Cost</b>
												</td>
												<?php } 
												else { $extra_row =""; } ?>
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
											$product_assemble_cost = $val->product_assemble_cost;

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
											$cart_product[$i]['product_assemble_cost'] = $product_assemble_cost[$i];

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
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">
												<label class='container_chk_lbl'>
													<input type='checkbox' <?php echo  ($cart_product1['checkbox_val1'] == 1) ? "checked" : "";?> disabled>
													<span class='checkmark' ></span>
												</label>
												<label class='container_chk_lbl_01'>
													<input type='checkbox' <?php echo  ($cart_product1['checkbox_val2'] == 1) ? "checked" : "";?> disabled>
													<span class='checkmark'></span>
												</label>
											</td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['sku']." - ".$cart_product1['product_cabinets_color']; ?></td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['product_details']; ?></td>
										    <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['weight']." lbs"; ?></td>
										    <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['quantity']; ?></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo "$".$cart_product1['cost']; ?></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php $total_amt = $cart_product1['cost'] * $cart_product1['quantity']; echo "$".number_format((float)$total_amt, 2, '.', ''); ?></td>
											<?php if($full_order_data['0']['assemble_cabinetry_charged'] > 0) 
											   { ?>
												<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php 
													if($cart_product1['product_assemble_cost'] != ""){
													echo "$". number_format($cart_product1['product_assemble_cost'],2);
													} else {
													echo "N/A";
													}?>
												</td>
											<?php } ?>
										</tr>
										<?php } } ?>									
										<?php $discount =  $all_total_actual_cost - $all_total; ?>
										<tr>
											<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">Discount Amount</td>
											<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">Dealer Discount</td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">1</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo "-$".number_format((float)$discount, 2, '.', ''); ?></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo "-$".number_format((float)$discount, 2, '.', ''); ?></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>

										<tr>											
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>TOTAL WEIGHT</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo number_format((float)$all_weight_total, 2, '.', '')." lbs"; ?></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr> 
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>SUB TOTAL</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">
												<?php
												echo "$".number_format((float)$all_total, 2, '.', '');
												?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>										
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>Fuel Charges (<?php echo $full_order_data['0']['fuel_charges_pertcentage'] ?>%)</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">
												<?php

												    $fuel_charges = number_format((float)$full_order_data['0']['fuel_charges'], 2, '.', '');

													if($fuel_charges > 0){
														echo "$".$fuel_charges;
													} else {
														echo "N/A";
													}
													?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>

										<?php 
											if($full_order_data['0']['assemble_cabinetry_charged'] > 0) 
											{
												$assembly_charges = $full_order_data['0']['assemble_cabinetry_charged'];	
											?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>CABINETRY ASSEMBLY COST</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">
												<?php
													echo "$".number_format((float)$assembly_charges, 2, '.', '');
												?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>												
										<?php } else { $assembly_charges = 0; }	?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>SALES TAX (<?php echo $full_order_data['0']['sales_tax']; ?>%)</b></td style="padding-bottom:0px;">
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">
												<?php
													$sales_tax_tot = (float)$all_total + (float)$fuel_charges + (float)$full_order_data['0']['shipping_cost'] + (float)$assembly_charges;
													$sales_tax =  ( ($all_total * (float)$full_order_data['0']['sales_tax']) / 100);
													$sales_tax = number_format((float)$sales_tax, 2, '.', '');
													echo "$".$sales_tax;
													 ?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<?php if($full_order_data['0']['is_shipping_quote'] == 1){  ?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>SHIPPING CHARGES</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">												
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>										
										<?php
											$shipping_cost_order = $full_order_data['0']['shipping_cost'];
											$shipping_charges_arr = json_decode($full_order_data['0']['shipping_charges_arr']);
											foreach($shipping_charges_arr as $kk => $vv){
												if($vv > 0){
										?>
										<tr>
											<td colspan="5" align="right"><b><?php echo $kk ?></b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">	
												<?php echo $vv;?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<?php } } ?>	
										<?php } else { $shipping_cost_order =0;?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>SHIPPING CHARGES</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">	
												<?php if($full_order_data['0']['shipping_cost'] == "Provide me with shipping amount via email/phone") { echo "<b>TBD</b>"; } else { echo '$'.$full_order_data['0']['shipping_cost']; $shipping_cost_order =$full_order_data['0']['shipping_cost'];} ?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<?php } ?>										
										<?php
											$credit_charges = getCreditCardCharges();
											if($full_order_data['0']['order_payment_type'] == "Credit Card"){	
										?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>CREDIT CARD CHARGES(<?php echo $full_order_data['0']['credit_card_charges_pertcentage']."%"; ?>)</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">	
												<?php
													echo "$".number_format((float)$full_order_data['0']['credit_card_charges'], 2, '.', '');
												?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<?php } ?>
										<?php
											if($full_order_data['0']['order_payment_type'] == "ACH"){	
										?>
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>ACH CHARGES</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">	
												<?php
													echo "$".number_format((float)$full_order_data['0']['ach_charges'], 2, '.', '');
												?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>										
										<?php } ?>
										
										<?php
											if($full_order_data['0']['order_payment_type'] == "Debit Card"){	
										?> 
										<tr>
											<td colspan="5" align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><b>DEBIT CARD CHARGES</b></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;">	
												<?php
													echo "$".number_format((float)$full_order_data['0']['debit_card_charges'], 2, '.', '');
												?>
											</td>
											<td align="right" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>										
										<?php } ?>
										<tr style="background:#f5f5f5;">
											<td colspan="5" align="right" style="padding: 5px 10px;color:#000;font-size:14px;"><b>TOTAL</b></td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;">	
												<?php 
												$grand_total = $all_total + $sales_tax + $shipping_cost_order + $assembly_charges + $full_order_data['0']['credit_card_charges'] + $full_order_data['0']['ach_charges'] + $full_order_data['0']['debit_card_charges'] + $fuel_charges;
												echo "$".number_format((float)$grand_total, 2, '.', '');
												?>
											</td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr>
											<td colspan="5" align="right" style="padding-bottom:0px;" style="padding: 5px 10px;color:#000;font-size:14px;"><b>PAYMENT</b></td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;">	
												<?php echo "$".number_format((float)$grand_total, 2, '.', ''); ?>
											</td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr>
											<td colspan="5" align="right" style="padding: 5px 10px;color:#000;font-size:14px;"><b>PAYMENT METHOD</b></td>
											<td align="right"></td>
											<td align="right">	
												<?php echo ucwords($full_order_data['0']['order_payment_type']); ?>
											</td>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr>
											<td colspan="5" align="right" style="padding: 5px 10px;color:#000;font-size:14px;"><b>BALANCE DUE</b></td>
											<td align="right"></td>
											<?php
												if($full_order_data['0']['order_payment_type'] == "Credit Card" || $full_order_data['0']['order_payment_type'] == "Debit Card"){	
											 ?>
											  <td align="right" style="padding: 5px 10px;color:#000;font-size:14px;">$0.00</td>
											 <?php } else {?>  
											  <td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"><?php echo "$".number_format((float)$grand_total, 2, '.', ''); ?></td>
											 <?php }?>
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr style="background:#f5f5f5;">
											<td colspan="5" align="center" style="padding: 10px 10px;color:#000;font-size:18px;"><b>THANK YOU FOR YOUR BUSINESS!</b></td>
											<td align="right"></td>
											<?php
											if($full_order_data['0']['order_payment_type'] == "Credit Card" || $full_order_data['0']['order_payment_type'] == "Debit Card"){	
											?>
											  <td style="padding: 10px 10px;color:#000;font-size:14px;" align="right"><b>PAID</b></td>
											<?php } else {?>  
											  <td style="padding: 10px 10px;color:#000;font-size:14px;" align="right"><b>PENDING</b></td>
											<?php }?> 
											<td align="right" style="padding: 5px 10px;color:#000;font-size:14px;"></td>
										</tr>										
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
</body>
</html>