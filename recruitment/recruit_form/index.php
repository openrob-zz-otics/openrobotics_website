<?php
	if(!(isset($_GET["level"]))) {
		header("Location: ../../recruitment");
	}
	$level = htmlspecialchars($_GET["level"]);
	if($level==="Beginner") {
		$qualities_1_text = "Describe any hands on experience or applicable skills you have.";
		$qualities_2_text = "Give an example of a time you taught yourself how to do something new.";
		$qualities_3_text = "Give an example of a time you showed initiative or leadership.";
		
		$academics_1_text = "What was your average from your last academic year?";
		$academics_2_text = "Rank the quality of your study habits from 1-10 explain.";
		$academics_3_text = "What Engineering discipline do you want to take next year/ why did you choose your current discipline?";
		
		$commitment_1_text = "What is your availability on Saturdays?";
		$commitment_2_text = "How many hours do you expect to spend working on a team per week?";
		$commitment_3_text = "Other Things Worth Noting";
		
		$interest_1_text = "Explain why you want to be part of the team.";
		$interest_2_text = "Do you have any hobbies, interests, or special talents?";
		$interest_3_text = "Where do you want to be in 5 years?";
	} elseif($level==="Intermediate") {
		$qualities_1_text = "Describe any hands on experience or applicable skills you have.";
		$qualities_2_text = "Give an example of a time you taught yourself how to do something new.";
		$qualities_3_text = "Give an example of a time you showed initiative or leadership.";
		
		$academics_1_text = "Are you confident in your academic performance?";
		$academics_2_text = "What Engineering discipline do you want to take next year/ why did you choose your current discipline?";
		$academics_3_text = "Other Things Worth Noting";
		
		$commitment_1_text = "What is your availability on Saturdays?";
		$commitment_2_text = "How many hours do you expect to spend working on a team per week?";
		$commitment_3_text = "Other Things Worth Noting";
		
		$interest_1_text = "Explain why you want to be part of the team.";
		$interest_2_text = "Do you have any hobbies, interests, or special talents?";
		$interest_3_text = "Where do you want to be in 5 years?";
	} elseif($level==="Advanced") {
		$qualities_1_text = "Describe any hands on experience or applicable skills you have.";
		$qualities_2_text = "Give an example of a time you taught yourself how to do something new.";
		$qualities_3_text = "Give an example of a time you showed initiative or leadership.";
		
		$academics_1_text = "What are your credentials or level of study?";
		$academics_2_text = "What is your current work, project, or occupation?";
		$academics_3_text = "Other Things Worth Noting";
		
		$commitment_1_text = "Would you be interested in acting as a mentor or advisor?";
		$commitment_2_text = "Would you be interested in leading a project?";
		$commitment_3_text = "How many hours would you expect to give the team per week?";
		
		$interest_1_text = "Explain why you want to be part of the team.";
		$interest_2_text = "Do you have any hobbies, interests, or special talents?";
		$interest_3_text = "Where do you want to be in 5 years?";
	} else {
		header("Location: ../../recruitment");
	}
?>
<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	require_once('../../php_include/recaptchalib.php');
	$page_name = "recruit_form";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		

			<h2>Register as <?php echo $level?></h2>
			
					
			<?php 
			
				$recaptcha_enabled = false;
							
				$public_key = "6LfNF_kSAAAAANXBwd3gJ7qqbJ1NLgRFx5jCi9Gz";
				$private_key = "6LfNF_kSAAAAAIVGRvYWR7FX2SyLRZpi_lnkZMYf";
				if(isset($_POST["submit"])) {
				
					//echo var_dump($_POST);
				
					if ($recaptcha_enabled) {
						$resp = recaptcha_check_answer ($private_key,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
					}
					
					if (!$recaptcha_enabled || @$resp->is_valid) {
					
						$first_name = @$_POST["first_name"];
						$middle_name = @$_POST["middle_name"];
						$last_name = @$_POST["last_name"];
						$email = @$_POST["email"];
						$phone_number = @$_POST["phone_number"];
						$year = @$_POST['year'];
						$major = @$_POST['major'];
						$student_number = @$_POST['student_number'];
						
						$qualities_1 = @$_POST["qualities_1"];
						$qualities_2 = @$_POST["qualities_2"];
						$qualities_3 = @$_POST["qualities_3"];
						
						$academics_1 = @$_POST["academics_1"];
						$academics_2 = @$_POST["academics_2"];
						$academics_3 = @$_POST["academics_3"];
						
						$commitment_1 = @$_POST["commitment_1"];
						$commitment_2 = @$_POST["commitment_2"];
						$commitment_3 = @$_POST["commitment_3"];
						
						$interest_1 = @$_POST["interest_1"];
						$interest_2 = @$_POST["interest_2"];
						$interest_3 = @$_POST["interest_3"];
						
						$messageBody = 
							"Applying for level: $level.\r\r\n".
							"Name: ".$first_name." ".$middle_name." ".$last_name."\r\n".
							"Email: ".$email."\r\n".
							"Phone: ".$phone_number."\r\n".
							"Student Number: ".$student_number."\r\n\r\n".
							"Qualities: \r\n".
							$qualities_1_text."\r\n".$qualities_1."\r\n\r\n".
							$qualities_2_text."\r\n".$qualities_2."\r\n\r\n".
							$qualities_3_text."\r\n".$qualities_3."\r\n\r\n".
							"Academics: \r\n".
							$academics_1_text."\r\n".$academics_1."\r\n\r\n".
							$academics_2_text."\r\n".$academics_2."\r\n\r\n".
							$academics_3_text."\r\n".$academics_3."\r\n\r\n".
							"Commitment: \r\n".
							$commitment_1_text."\r\n".$commitment_1."\r\n\r\n".
							$commitment_2_text."\r\n".$commitment_2."\r\n\r\n".
							$commitment_3_text."\r\n".$commitment_3."\r\n\r\n".
							"Interest: \r\n".
							$interest_1_text."\r\n".$interest_1."\r\n\r\n".
							$interest_2_text."\r\n".$interest_2."\r\n\r\n".
							$interest_3_text."\r\n".$interest_3;
						
						if(myMail("intelligence@openrobotics.ca", "New Registration", $messageBody)) {
							$success = "Submission Successful! Will be processed within 24 hours.";

								//Put into the db, :)
							$query = "INSERT INTO `roster` (`name`, `email`, `phone`, `year`, `major`, `student_number`) VALUES ('$first_name $middle_name $last_name', '$email', '$phone_number', '$year', '$major', '$student_number');";
							$db = get_db();
							//echo $query;
							if($db->query($query)) {
							} else {
								$error = "Uh oh, submission was unsuccessful. Please try again. If the problem persists, contact admin directly.";
							}
						} else {
							$error = "Uh oh, submission was unsuccessful. Please try again. If the problem persists, contact admin directly.";
						}
						


						//Also write to file as backup
						/*
						if (!file_exists($_SERVER['DOCUMENT_ROOT']."/../recruit_submit/")) {
							mkdir($_SERVER['DOCUMENT_ROOT']."/../recruit_submit/");
						}
						$out = fopen($_SERVER['DOCUMENT_ROOT']."/../recruit_submit/".$email.time(), "w");
						fwrite($out, $messageBody);
						fclose($out);
						*/
					} else {
						if ($recaptcha_enabled) {
							$errors = "Invalid CAPTCHA";// . $resp->error;
						}
					}
				}
			?>
			
			<?php 
				if(isset($errors)) {
					echo "<p class=\"bg-danger\">".$errors."</p>";
				}
				if(isset($success)) {
					echo "<p class=\"bg-success\">".$success."</p>";
				}
			?>

			<form action=".?level=<?php echo $level ?>" method="post" <?php if(isset($success)) echo "style='display:none;'"; ?>>
				<p>
					Answers can be 1-2 sentences. Longer is fine. Point form is fine. 
					All Applications will receive a personal response. This isn't a test, 
					it's just for our interest. If we don't accept you we will give advice 
					on how to change our minds next time.
				</p>
				<hr>
				<h4>Basic Information</h4>
				
				<div class="form-group" id="control_first_name">
					<label for="form_first_name" class="control-label">First Name</label>
					<input type="text" name="first_name" class="form-control" placeholder="John" id="form_first_name" value="<?php echo @$first_name;?>">
					<span class="help-block with-errors"></span>
				</div>		
				
				<div class="form-group" id="control_middle_name">
					<label for="form_middle_name">(Optional) Middle Name</label>
					<input type="text" name="middle_name" class="form-control" placeholder="Paul" id="form_middle_name" value="<?php echo @$middle_name;?>">
				</div>	
				
				<div class="form-group" id="control_last_name">
					<label for="form_last_name">Last Name</label>
					<input type="text" name="last_name" class="form-control" placeholder="Smith" id="form_last_name" value="<?php echo @$last_name;?>">
					<span class="help-block with-errors"></span>
				</div>
				
				<div class="form-group" id="control_email">
					<label for="form_contact_email">Email</label>
					<input type="email" name="email" class="form-control" placeholder="example@theworld.com" id="form_email" value="<?php echo @$email;?>">
					<span class="help-block with-errors"></span>
				</div>	
				
				<div class="form-group" id="control_phone_number">
					<label for="form_phone_number">Phone Number</label>
					<input type="tel" name="phone_number" class="form-control" placeholder="0000000000" id="form_phone_number" value="<?php echo @$phone_number;?>">
					<span class="help-block with-errors"></span>
				</div> 

				<div class="form-group" id="control_year">
					<lavel for="form_year">Year</label>
					<input type="number" name="year" class="form-control" placeholer="2" id="form_year" value="<?php echo @$year;?>">
				</div>

				<div class="form-group" id="control_major">
					<lavel for="form_major">Major</label>
					<input type="text" name="major" class="form-control" placeholer="Electrial Engineering" id="form_major" value="<?php echo @$major;?>">
				</div>

				<div class="form-group" id="control_student_number">
					<label for="form_student_number">Student Number</label>
					<input type="text" name="student_number" class="form-control" placeholder="" id="form_student_number" value="<?php echo @$student_number;?>">
				</div>
				

				<br />
				<p class="text-warning">Click on the headings below to reveal more parts of the form. Neglecting to complete these parts of the form will reflect poorly on your applications.</p>
				<br />
				
				<h4 class="expand_tr" data-id="Qualities" data-down="0" id="Qualities_Control">Qualities<span id="Qualities_Icon" style="float:right;" class="glyphicon glyphicon-chevron-down"></span><br/><br/></h4>
				
				<div id="Qualities" style="display:none;">
					<div class="form-group" id="qualities_1">
						<label for="form_qualities_1" class="control-label"><?php echo $qualities_1_text?></label>
						<textarea class="form-control" name="qualities_1" rows="3" id="form_qualities_1"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="qualities_2">
						<label for="form_qualities_2" class="control-label"><?php echo $qualities_2_text?></label>
						<textarea class="form-control" name="qualities_2" rows="3" id="form_qualities_2"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="qualities_3">
						<label for="form_qualities_3" class="control-label"><?php echo $qualities_3_text?></label>
						<textarea class="form-control" name="qualities_3" rows="3" id="form_qualities_3"></textarea>
						<span class="help-block with-errors"></span>
					</div>
				</div><br/>
				
				<h4 class="expand_tr" data-id="Academics" data-down="0" id="Academics_Control">Academics<span id="Academics_Icon" style="float:right;" class="glyphicon glyphicon-chevron-down"></span><br/><br/></h4>
				
				<div id="Academics" style="display:none;">
					<div class="form-group" id="academics_1">
						<label for="form_academics_1" class="control-label"><?php echo $academics_1_text?></label>
						<textarea class="form-control" name="academics_1" rows="3" id="form_academics_1"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="academics_2">
						<label for="form_academics_2" class="control-label"><?php echo $academics_2_text?></label>
						<textarea class="form-control" name="academics_2" rows="3" id="form_academics_2"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="academics_3">
						<label for="form_academics_3" class="control-label"><?php echo $academics_3_text?></label>
						<textarea class="form-control" name="academics_3" rows="3" id="form_academics_3"></textarea>
						<span class="help-block with-errors"></span>
					</div>
				</div><br/>
				
				<h4 class="expand_tr" data-id="Commitment" data-down="0" id="Commitment_Control">Commitment<span id="Commitment_Icon" style="float:right;" class="glyphicon glyphicon-chevron-down"></span><br/><br/></h4>
				
				<div id="Commitment" style="display:none;">
					<div class="form-group" id="commitment_1">
						<label for="form_commitment_1" class="control-label"><?php echo $commitment_1_text?></label>
						<textarea class="form-control" name="commitment_1" rows="3" id="form_commitment_1"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="commitment_2">
						<label for="form_commitment_2" class="control-label"><?php echo $commitment_2_text?></label>
						<textarea class="form-control" name="commitment_2" rows="3" id="form_commitment_2"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="commitment_3">
						<label for="form_commitment_3" class="control-label"><?php echo $commitment_3_text?></label>
						<textarea class="form-control" name="commitment_3" rows="3" id="form_commitment_3"></textarea>
						<span class="help-block with-errors"></span>
					</div>
				</div><br/>
				
				<h4 class="expand_tr" data-id="Interest" data-down="0" id="Interest_Control">Interest<span id="Interest_Icon" style="float:right;" class="glyphicon glyphicon-chevron-down"></span><br/><br/></h4>
				
				<div id="Interest" style="display:none;">
					<div class="form-group" id="interest_1">
						<label for="form_interest_1" class="control-label"><?php echo $interest_1_text?></label>
						<textarea class="form-control" name="interest_1" rows="3" id="form_interest_1"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="interest_2">
						<label for="form_interest_2" class="control-label"><?php echo $interest_2_text?></label>
						<textarea class="form-control" name="interest_2" rows="3" id="form_interest_2"></textarea>
						<span class="help-block with-errors"></span>
					</div>
					
					<div class="form-group" id="interest_3">
						<label for="form_interest_3" class="control-label"><?php echo $interest_3_text?></label>
						<textarea class="form-control" name="interest_3" rows="3" id="form_interest_3"></textarea>
						<span class="help-block with-errors"></span>
					</div>
				</div><br/>
				
				<?php 
					if ($recaptcha_enabled) {
						echo recaptcha_get_html($public_key, NULL, true);
					}
				?><br />
				
				<div class="form-group">
					<button type="submit" class="btn btn-default" id="form_submit" name="submit" disabled>Submit</button>
				</div>
			</form>	
		</div>
		
		<div class="col-md-3"></div>
	</div>
	
	<?php
		print_footnote();
	?>

</div><!--container-->

<?php 
	//print the footer	
	print_footer();
?>
