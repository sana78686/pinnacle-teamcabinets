	<?php 
	$db = \Config\Database::connect();
	$user_name = "SELECT * FROM user_register WHERE id = '" . $claims_data['claims_order_user_id'] . "'";
	$user_name_query = $db->query($user_name);
	$user_results = $user_name_query->getResultArray();


	/*Start code by RS for job name (14-05-20)*/

	$order_id = $claims_data['claims_order_id'];;
	$builder = $db->table('my_orders');
	$builder->select('job_name');
	$builder->where('id', $order_id);
	$query = $builder->get();
	$data['term_data'] = $query->getRow()->job_name;
	$sort_job_name = json_decode($data['term_data']);

	$job_name = $sort_job_name[0];

	/*End code by RS for job name (14-05-20)*/

	?>
<style>
.container_chk_lbl {
   display: block;
   position: relative;
   padding-left: 35px;
   margin-bottom: 12px;
   cursor: not-allowed;
   font-size: 22px;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   }
   .container_chk_lbl input {
   position: absolute;
   opacity: 0;
   cursor: not-allowed;
   height: 0;
   width: 0;
   }
   .checkmark {
   position: absolute;
   top: 0;
   left: 0;
   height: 25px;
   width: 25px;
   background-color: yellow;
   }
   .container_chk_lbl:hover input ~ .checkmark {
   background-color: yellow;
   }
   .container_chk_lbl input:checked ~ .checkmark {
   background-color: yellow;
   }
   .checkmark:after {
   content: "";
   position: absolute;
   display: none;
   }
   .container_chk_lbl input:checked ~ .checkmark:after {
   display: block;
   }
   .container_chk_lbl .checkmark:after {
   left: 9px;
   top: 5px;
   width: 5px;
   height: 10px;
   border: solid #000;
   border-width: 0 3px 3px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   }
   .container_chk_lbl {
   display: block;
   position: relative;
   padding-left: 35px;
   margin-bottom: 12px;
   cursor: not-allowed;
   font-size: 22px;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   }
   /*yellow check box*/
   .container_chk_lbl_01 {
   display: block;
   position: relative;
   padding-left: 35px;
   margin-bottom: 12px;
   cursor: not-allowed;
   font-size: 22px;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
   }
   .container_chk_lbl_01 input {
   position: absolute;
   opacity: 0;
   cursor: not-allowed;
   height: 0;
   width: 0;
   }
   .container_chk_lbl_01 .checkmark {
   position: absolute;
   top: 0;
   left: 0;
   height: 25px;
   width: 25px;
   background-color: green;
   }
   .container_chk_lbl_01:hover input ~ .checkmark {
   background-color: green;
   }
   .container_chk_lbl_01 input:checked ~ .checkmark {
   background-color: green;
   }
   .container_chk_lbl_01 .checkmark:after {
   content: "";
   position: absolute;
   display: none;
   }
   .container_chk_lbl_01 input:checked ~ .checkmark:after {
   display: block;
   }
   .container_chk_lbl_01 .checkmark:after {
   left: 9px;
   top: 5px;
   width: 5px;
   height: 10px;
   border: solid #000;
   border-width: 0 3px 3px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   }
   .container_chk_lbl, .container_chk_lbl_01{margin-bottom:0px; height:30px; width:25px;}
</style>	
<div class="box box-primary">
	<div style="width:100%;float:left;">
		<label>Hello Admin, 
	</div>
	<div style="width:100%;float:left;">
		<?php $username =  $user_results['0']['username'] .'('. ucwords($user_results['0']['user_type']).')';?> 
		<br>
		<label>New claim request has been submitted by <?php echo $username;?>. Please find below the product details:</label>  
		<br>
	</div>
	 
	<div style="width:100%;float:left;">
		<div class="job_name_cls" style="">
			<b>Job Name</b> - <?php  echo $job_name; ?>
		</div>
		<label><b>Product :</b></label>
		<table class="table table-bordered custom_cart_cls" style="border: 1px solid #d2d6de;margin-bottom: 20px;">
			<thead>
				<tr>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Room</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Double Check Work</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Cabinet Section</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Cabinet Name</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Cabinet Description</th>
					<!-- <th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Cabinets Color</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">SKU</th> -->
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Weight</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Price</th>
					<th style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">Image</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($claims_data['claims_product_val'] as $val)
					{
						$all_val = $val;
						//$all_val = json_decode($val);
						$cab_name = "SELECT * FROM cabinets_name WHERE id = '" . $all_val['cabinets_id'] . "'";
						$cab_name_query = $db->query($cab_name);
						$cab_results = $cab_name_query->getResultArray();
						
						$all_val['product_description'] = str_replace("%39%","'",$all_val['product_description']);
                  		$all_val['product_description'] = str_replace('%34%','"',$all_val['product_description']);
						?>
							<tr>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo $all_val['room']; ?></td>	
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><label class='container_chk_lbl'><input type='checkbox' <?php echo  ($all_val->checkbox_val1 == 1) ? "checked" : "";?> disabled><span class='checkmark' ></span></label><label class='container_chk_lbl_01'><input type='checkbox' <?php echo  ($$all_val->checkbox_val2 == 1) ? "checked" : "";?> disabled><span class='checkmark'></span></td>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo $cab_results['0']['cabinets_name']; ?></td>
							  <!-- <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php //echo $all_val['product_name'];; ?></td>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php //echo $all_val['product_color'];; ?></td> -->
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo $all_val['sku']; ?></td>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo $all_val['product_description']; ?></td>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo $all_val['weight']." lbs"; ?></td>
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;"><?php echo "$".$all_val['cost']; ?></td>
							  
							  <td style="border: 1px solid #d2d6de;padding: 8px;text-align: left;">
								<?php
									$email = service('email');
									$img_arr = explode(",",$all_val['image']);
									foreach($img_arr as $img_arr1)
									{
										$filename = 'assets/admin/cabinet_img/'.$img_arr1.'';
										$email->attach($filename);
										$cid = $email->setAttachmentCID($filename);
										
										?>
										<img style="width:50px;height:50px;margin:15px;float:left;" style="" src="cid:<?php echo $cid; ?>" alt="photo1" />
										<?php	
									}
								?>
							  </td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<?php /* ?><div style="width:100%;float:left;">
		<label><b>Image :</b></label>
		<div>
		<?php
			$img = json_decode($claims_data['claims_order_image']);
			foreach($img as $img_name)
			{
				$filename = 'assets/claims_img/'.$img_name.'';
				$this->email->attach($filename);
				$cid = $this->email->attachment_cid($filename);
				?>
				<img style="width:50px;height:50px;margin:15px;float:left;" style="" src="cid:<?php echo $cid; ?>" alt="photo1" />
				<?php
			}	
		?>
		</div>
	</div><?php */ ?>
	<div style="width:100%;float:left;">
		<label><b>Message :</b></label> <?php echo $claims_data['claims_order_message']; ?>
	</div>
	<div style="width:100%;float:left;">
		<label><b>Order Id :</b></label> <?php echo $claims_data['claims_order_id']; ?>
	</div>
	<div style="width:100%;float:left;">
		<label><b>User Name :</b></label> <?php 
		
			echo $user_results['0']['username']; 
		?>
	</div>
	<div style="width:100%;float:left;">
		<label><b>Representative Name :</b></label> <?php 
		
			echo getParentDetail($claims_data['claims_order_user_id']); 
		?>
	</div>
	<br><br>
	<div style="width:100%;float:left;">
		<label>Regards,</label>
	</div>
	<div style="width:100%;float:left;">
		<label>Team Cabinets</label> 
	</div>
</div>