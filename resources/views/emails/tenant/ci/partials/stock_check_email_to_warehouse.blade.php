<?php
	$db = \Config\Database::connect();
    $full_order_data = json_decode(json_encode($quote_data), true);
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
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 		
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: 1px solid #cccccc; border-top:3px solid #398ebd; border-collapse: collapse;">
                  
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px 20px 20px 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">							
						       <tr>
                                    <td style="color: #333; font-family: Arial, sans-serif; font-size: 22px; padding-bottom:15px;" colspan="3">
                                        <b>STOCK CHECK REQUEST</b>
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
										   <td align="right"><b>Item Line</b></td> 		</tr>	

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
									$product_note = $val->product_note;
									
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
										$cart_product[$i]['product_note'] = $product_note[$i];

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
										?>
										<tr>
										  <td><label class='container_chk_lbl'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val1'] == 1) ? "checked" : "";?> disabled><span class='checkmark' ></span></label><label class='container_chk_lbl_01'><input type='checkbox' <?php echo  ($cart_product1['checkbox_val2'] == 1) ? "checked" : "";?> disabled><span class='checkmark'></span></td>
										  <td><?php echo $cart_product1['sku']." - ".$cart_product1['product_cabinets_color']; ?></td>
										   <td><?php echo $cart_product1['product_details']; ?></td>
									   <td align="right"><?php echo $cart_product1['quantity']; ?></td>
									   <td align="right"><?php echo $cart_product1['weight']." lbs"; ?></td> 
									   <td align="right"><?php $total_weight = $cart_product1['weight'] * $cart_product1['quantity']; echo $total_weight." lbs"; ?></td>
										<td align="right"><?php echo $cart_product1['product_note']; ?></td>											   
										</tr>
										<?php
									}		
								}	
							?>
											

										<tr>
										  <td height="10" colspan="5"></td>
										</tr>
										
										<tr>
										  <td style="color:#d6d3de;" colspan="2" rowspan="2" valign="top"></td>
										  <td></td>
										    <td align="right"><b>TOTAL WEIGHT</b></td>
										    <td align="right"></td>
											<td align="right"><?php echo $all_weight_total." lbs"; ?></td> 
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
</div>	    
</body>
</html>