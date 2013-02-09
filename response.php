<?php
include 'includes/_incHeader.php';
include 'includes/mail_sender.php';


$db = new cDB();
 	$resultarr = array();
    $getSql = $db->Query("SELECT * FROM hz_asset_requests,hz_employees WHERE requestID=".$_REQUEST["request_id"]." AND hz_employees.empid = hz_asset_requests.EmployeeID ");
		if ($db->RowCount) {
		 $db->ReadRow();
         $resultarr = $db->RowData;
			}

//manager responce
if(isset($_REQUEST["mapproved"]) && !empty($_REQUEST["request_id"]))
{
 	
    
    if($_REQUEST["mapproved"]==1)
        {
            $req_id = $_REQUEST["request_id"];
           	$db1 = new cDB();
			$sql = "UPDATE hz_asset_requests SET Status = 1 WHERE  requestID = ".$req_id;
			if($db1->Query($sql))
            {
                $approved=1;
                if(sendMailToHOD("Adminstrator@hz.com","New Asset Request",$resultarr))
                {
                    $approved++;
                }//send email to HOD
            }
            else
            {
                $approved=0;
            }
            
        }
        elseif($_REQUEST["mapproved"]==0)
        {
            $ask_reason = 1;
            $who = "MAN";

        }
}


//HOD responce
if(isset($_REQUEST["happroved"]) && !empty($_REQUEST["request_id"]))
{
 	
    
    if($_REQUEST["happroved"]==1)
        {
            $req_id = $_REQUEST["request_id"];
           	$db1 = new cDB();
			$sql = "UPDATE hz_asset_requests SET Status = 2 WHERE  requestID = ".$req_id;
			if($db1->Query($sql))
            {
                $happroved=1;
                 if(sendMailToEmp($resultarr["email"],"Adminstrator@hz.com",$resultarr["HardwareID"],"Approved"," "))//send mail to employee
                {
                   $happroved++;
                } 
            }
            else
            {
                $happroved=0;
            }
            
        }
        elseif($_REQUEST["happroved"]==0)
        {
            $ask_reason = 1;
            $who = "HOD";
            
        }
}


if(isset($_REQUEST["txtreason"]))
{
            $req_id = $_REQUEST["request_id"];
            if($_REQUEST["who_rejected"]=='HOD') {$status =1 ;}
            if($_REQUEST["who_rejected"]=='MAN') {$status =0 ;}
           	$db1 = new cDB();
			$sql = "UPDATE hz_asset_requests SET RejectionReason = '".mysql_real_escape_string($_REQUEST["txtreason"])."',Status=$status WHERE  requestID = ".$req_id;
			if($db1->Query($sql))
            {
                $rejected=1;
                if(sendMailToEmp($resultarr["email"],"Adminstrator@hz.com",$resultarr["HardwareID"],"rejected",$_REQUEST["txtreason"]))//send mail to employee
                {
                   $rejected++; 
                } 
            }
            else
            {
               $rejected=0;
            }
    
    
}



?>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
	<div id="center">
   <?php
   if($approved)
   {
        if($approved==2)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Request has been forwarded to Head Of Department</p></div>";
        }
        elseif($approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Error forwarding request to HOD</p></div>";
        
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Occured approving request, Please try again later!</h2></div>";
        }
   }
   if($happroved)
   {
        if($happroved==2)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Email sent to Employee</p></div>";
        }
        elseif($happroved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Error sending email to  Employee</p></div>";
        
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Occured approving request, Please try again later!</h2></div>";
        }
   }
   
   if($rejected)
   {
        if($rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Rejected</h2><p>Error Sending Email to Employee</p></div>";
        }
        elseif($rejected==2)
        {
           echo "<div style='text-align:center;min-height:300px;'><h2>Request Rejected</h2><p>Mail Sent To Employee</p></div>"; 
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Rejecting Request, Please try again later!</h2></div>";
        }
   }
   
   if($ask_reason==1)
   {
   ?>
   	<form name="rejectform" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" >
				<fieldset><legend>Reject Request</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
                <div class="text-box-name">Reason for Rejection:</div>
				<div class="textarea-box-field" >
					<textarea name="txtreason" id="txtreason"  class="form-text" rows="4" ></textarea> 				
				</div>
				<div class="text-box-field"></div>
                <div style="clear: both;">
                <input type="hidden" name="request_id" value="<?php echo $_REQUEST["request_id"] ?>" />
                <input type="hidden" name="who_rejected" value="<?php echo $who; ?>" />
				<input type="submit" name="newTrequest" id="newTrequest" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				</div>
                </fieldset>
   
   </form>
   <?php 
   }
   ?>
	</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>
