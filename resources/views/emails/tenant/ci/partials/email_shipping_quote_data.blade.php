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
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc; border-top:3px solid #398ebd; border-collapse: collapse;">
                  
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
							  <td valign="top" style="margin-right: 0px; text-align:center; width:30%;"><img src="<?php echo base_url()."/assets/front_site_assets/images/logo_email.jpg" ;?>" width="200px" height="100px" ></td>
							  <td valign="top" style="width:35%;padding:0px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 15px; line-height:20px;">
							    <p style="margin-top:0;margin-bottom:10px; text-align:right;"><a href="mailto:team@teamcabinets.com" style="color:#222;">team@teamcabinets.com</a></p>
							    <p style="margin-top:0; margin-bottom:10px; text-align:right;"><a style="color:#222;" href="https://teamcabinets.com/">www.teamcabinets.com</a></p>
							  </td>
							</tr>
							
							
						    	 <tr>
                                    <td style="color: #000; font-family: Arial, sans-serif; font-size:18px; padding-bottom:5px;padding-top:5px;" colspan="3">
                                        <b>Shipping Quote</b>
                                    </td>
								</tr>
									<tr>
									<td colspan="3">
									 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#f5f5f5;color: #333; font-family: Arial, sans-serif; font-size:13px; line-height:20px;">
									    <tr>
										 <td style="color: #000; font-family: Arial, sans-serif; font-size:16px; padding: 8px 10px;">
										   <b>Bill To:</b>
										 </td>
										  <td style="color: #000; font-family: Arial, sans-serif; font-size:16px; padding: 8px 10px;">
										   <b>Ship To:</b>
										 </td>
										  <td style="color: #000; font-family: Arial, sans-serif; font-size:16px; padding: 8px 10px;">
										 
										 </td>
										</tr>
										<tr>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Name:</b> <?php echo $email_data['bill_to_name'];  ?></td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Name:</b> <?php echo $email_data['ship_to_name'];  ?></td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Shipping Quote ID #:</b> <?php echo $email_data['ship_quote_id']; ?> </td>
										</tr>
										<tr>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;" style="line-height:15px;" valign="top"><b>Address:</b> <?php echo $email_data['bill_to_address'].", ".$email_data['bill_to_city'].", <br>".$email_data['bill_to_county'].", ".$email_data['bill_to_state'].", ".$email_data['bill_to_zipcode'].", ".$email_data['bill_to_country'];  ?></td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;" valign="top"><b>Address:</b> <?php echo $email_data['ship_to_address'].", ".$email_data['ship_to_city'].", <br>".$email_data['ship_to_county'].",  ".$email_data['ship_to_state'].", ".$email_data['ship_to_zipcode'].", ".$email_data['ship_to_country'];  ?></td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;" valign="top"><b>Date:</b> 
										    	<?php
										    	    if($email_data['order_shipping_cost'] > 0){
										    	     	$date = $email_data['created_at'];
													  	$date=substr($date, 0, strrpos($date, ' '));
													  	$newDate = date("m-d-Y", strtotime($date));
										    	    } else {
														$newDate = date("m-d-Y");  
										    	    }
													  echo $newDate;  
												?> 
											</td>
										</tr>
										<tr>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Email:</b> <?php echo $email_data['bill_to_email'];  ?> </td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Email:</b> <?php echo $email_data['ship_to_email'];  ?> </td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"></td>
										</tr>
										<tr>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Phone:</b> <?php echo $email_data['bill_to_phone'];  ?> </td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"><b>Phone:</b> <?php echo $email_data['ship_to_phone'];  ?> </td>
										    <td style="padding: 3px 10px;color:#000;font-size:14px;"></td>
										</tr>
										    <tr>
											  <td colspan="3" height="10" style="padding: 3px 10px;color:#000;font-size:14px;">
											  <b>Company Name</b> : <?php $userCompanyName = !empty(getUserCompanyName($email_data['user_id'])) ? getUserCompanyName($email_data['user_id']) : "N/A"; echo $userCompanyName;?>
											  </td>
											 </tr>
									 </table>
									</td>
									</tr>
									
									 
									 
									 <tr>
									  
									  <td colspan="3" height="10" style="font-size:16px; padding-bottom:10px; padding-top:15px;">
									  <b>Job Name</b> : <?php echo $email_data['job_name'];  ?>
									  </td>
									 </tr>
									
									<tr>
									  <td colspan="3">
									    <table border="0" cellpadding="5" cellspacing="0" width="100%" style="color: #333; font-family: Arial, sans-serif; font-size:14px; line-height:20px;">
										  <tr style="background:#f5f5f5;">
										   <td style="padding: 5px 10px;color:#000;font-size:14px; white-space:nowrap;" valign="middle"><b>Double Check Work</b></td>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; white-space:nowrap;" valign="middle"><b>Product</b></td>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; " valign="middle"><b>Description</b></td>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; " valign="middle" align="right"><b>Quantity</b></td>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; " valign="middle" align="right"><b>Unit Price</b></td>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; " valign="middle" align="right"><b>Amount</b></td>
										   <?php 
											if($email_data['is_assemble'] == 1) 
											{	$extra_row ="<td style='border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;'></td>";
											?>
										   <td style="padding: 5px 10px;color:#000;font-size:14px; " valign="middle" align="right"align="right"><b>Assemble Cost</b></td>
											<?php } else { $extra_row =""; } ?>
										  </tr>	

							 <?php
								$all_weight_total =0;
								$all_total = "0";
								$replaceString = array('"',']','[','lbs');
								$finalCartWeight = str_replace($replaceString,'', $email_data['cart_product_weight']);
								$room_data = json_decode($email_data['room_data']);

								foreach($room_data as $key => $val)
								{
									?><!--<tr><th colspan="5" ><?php //echo $key; ?></th></tr>--><?php
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
										$q1 = $db->table('cabinets_product')
										   ->where('sku', $cart_product1['sku'])
										   ->get();
										$results = $q1->getRowArray();										
										$cab_name = $db->table('cabinets_name')
												   ->where('id', $results['0']['cabinets_name'])
												   ->get();
										$cab_results = $cab_name->getRowArray();
										
                    					$total_assemble_price = $total_assemble_price + $cart_product1['product_assemble_cost'];
										?>
										<tr>
										  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><label class='container_chk_lbl'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val1'] == 1) ? "checked" : "";?> disabled><span class='checkmark' ></span></label><label class='container_chk_lbl_01'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val2'] == 1) ? "checked" : "";?> disabled><span class='checkmark'></span></td>
										  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['sku']." - ".$cart_product1['product_cabinets_color']; ?></td>
										   <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"><?php echo $cart_product1['product_details']; ?></td>
										    <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo $cart_product1['quantity']; ?></td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".$cart_product1['cost']; ?></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php $total_amt = $cart_product1['cost'] * $cart_product1['quantity']; echo "$".number_format((float)$total_amt, 2, '.', ''); ?></td>
											  <?php 
												if($email_data['is_assemble'] == 1) 
												{	
												?>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php 
												if($cart_product1['product_assemble_cost'] != ""){
													echo "$". number_format($cart_product1['product_assemble_cost'],2);
												} else {
													echo "N/A";
												} 
												?></td>
											  <?php } ?>
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

										
										<tr>
										  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										  <?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>SUB TOTAL</b></td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$all_total, 2, '.', ''); ?></td>
										</tr>

										<?php 
											if($email_data['is_assemble'] == 1) 
											{
												$assembly_charges = $total_assemble_price;	
											?>
												<tr> 
													<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
													<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
													
													<?php echo $extra_row; ?>
													<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>CABINETRY ASSEMBLY COST</b></td>
													<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
													<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right">
														<?php
														echo "$".number_format((float)$assembly_charges, 2, '.', '');
														?>
													</td>

												</tr>
											<?php 
												} else {
													$assembly_charges = 0;
												}	
										?>
										<?php 
										if($email_data['is_shipping_updated'] != 1){
											$pallets =  ceil($all_weight_total / 800);
											$pallets_cost = $pallets * PALLET_COST;
											$miscellneous_charges = $email_data['delivery_cost'] + $email_data['liftgate_cost'] + $email_data['unload_cost'] + $pallets_cost;
											
											if($email_data['unload_type'] == 1){
												$unload_type = "By Hand"; 
											} else {
												$unload_type = "By Forklift";
											}
											
											if($email_data['delivery_type'] == 1){
												$delivery_type = "Commercial"; 
											} else {
												$delivery_type = "Residential";
											}
											
											
										?>
										<tr>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" ></td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" ></td>
											<?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>PALLETS CHARGES</b>(TOTAL PALLETS =<?php echo $pallets; ?>)</td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$pallets_cost, 2, '.', '');  ?></td>
										</tr>
										<tr>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" ></td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										   
											<?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>DELIVERY CHARGES</b>(<?php echo $delivery_type; ?>)</td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$email_data['delivery_cost'], 2, '.', '');  ?></td>
										</tr>
										<tr>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										   
											<?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>LIFTGATE CHARGES</b></td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$email_data['liftgate_cost'], 2, '.', '');  ?></td>
										</tr>
										<tr>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
											<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										    
											<?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>UNLOAD CHARGES</b>(<?php echo $unload_type; ?>)</td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$email_data['unload_cost'], 2, '.', '');  ?></td>
										</tr>
										
										<?php		
										} else {
											$miscellneous_charges =0;
										}
										?>
										<?php 
										if($email_data['is_shipping_updated'] == 1){
											$pallets_cost = $email_data['total_pallets'] * PALLET_COST;
											$shipping_charges = $email_data['delivery_cost'] + $email_data['liftgate_cost'] + $email_data['unload_cost'] + $pallets_cost + $email_data['miscellneous_charges'];
											
											if($email_data['unload_type'] == 1){
												$unload_type = "By Hand"; 
											} else {
												$unload_type = "By Forklift";
											}
											
											if($email_data['delivery_type'] == 1){
												$delivery_type = "Commercial"; 
											} else {
												$delivery_type = "Residential";
											}
										?>
										<?php if($pallets_cost > 0){?>
											<tr>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<?php echo $extra_row; ?>
												<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>PALLETS CHARGES</b>(TOTAL PALLETS =<?php echo $email_data['total_pallets']; ?>)</td>
												 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
												  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$pallets_cost, 2, '.', '');  ?></td>
											</tr>
										<?php } if($email_data['delivery_cost'] > 0){?>
											<tr>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												
												<?php echo $extra_row; ?>
												<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"><b>DELIVERY CHARGES</b>(<?php echo $delivery_type; ?>)</td>
												 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
												  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"><?php echo "$".number_format((float)$email_data['delivery_cost'], 2, '.', '');  ?></td>
											</tr>
										<?php } if($email_data['liftgate_cost'] > 0){?>
											<tr>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												
												<?php echo $extra_row; ?>
												<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"><b>LIFTGATE CHARGES</b></td>
												 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"></td>
												  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"><?php echo "$".number_format((float)$email_data['liftgate_cost'], 2, '.', '');  ?></td>
											</tr>
										<?php } if($email_data['unload_cost'] > 0){?>
											<tr>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												
												<?php echo $extra_row; ?>
												<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>UNLOAD CHARGES</b>(<?php echo $unload_type; ?>)</td>
												 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
												  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php echo "$".number_format((float)$email_data['unload_cost'], 2, '.', '');  ?></td>
											</tr>
										<?php } if($email_data['miscellneous_charges'] > 0){
										?>	
											<tr>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
												
												<?php echo $extra_row; ?>
												<td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>MISCELLNEOUS CHARGES</b></td>
												 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"></td>
												  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"align="right"><?php echo "$".number_format((float)$email_data['miscellneous_charges'], 2, '.', '');  ?></td>
											</tr>										
										<?php 
										}
										} else {
											$shipping_charges =0;
										}
										?>										
										
										<tr style="background:#f5f5f5;">
										<td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;"></td>
										  
										   <?php echo $extra_row; ?>
										    <td colspan="2" style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><b>TOTAL</b></td>
											 <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"></td>
											  <td style="border-bottom:1px solid #ddd;padding: 5px 10px;color:#000;font-size:14px;" align="right"><?php 
														$grand_total = $all_total +$assembly_charges  + $shipping_charges + $miscellneous_charges;

														echo "$".number_format((float)$grand_total, 2, '.', '');
													?>
											   </td>
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