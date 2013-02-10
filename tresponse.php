<?php
include 'includes/_incHeader.php';
include 'includes/mail_sender.php';


$db = new cDB();
$db1 = new cDB();
 	$resultarr = array();
    $getSql = $db->Query("SELECT * FROM hz_transfer_requests,hz_employees WHERE requestID=".$_REQUEST["request_id"]." AND hz_employees.empid = hz_transfer_requests.EmployeeID ");
		if ($db->RowCount) {
		 $db->ReadRow();
         $resultarr = $db->RowData;
			}


	$requestor_details = array();
    $getSql = $db1->Query("SELECT * FROM hz_transfer_requests,hz_employees WHERE requestID=".$_REQUEST["request_id"]." AND hz_employees.empid = hz_transfer_requests.RequestorID ");
		if ($db1->RowCount) {
		 $db1->ReadRow();
         $requestor_details = $db1->RowData;
			}
//echo "<pre>";
//print_r($resultarr);
//print_r($requestor_details);
//echo "</pre>";

//first manager responce
if(isset($_REQUEST["mapproved"]) && !empty($_REQUEST["request_id"]))
{
 	
    if($resultarr["Status"]=="0" && $resultarr["FirstManagerRejected"]==0)//if request is not processed
        {
            if($_REQUEST["mapproved"]==1)
                {
                    $req_id = $_REQUEST["request_id"];
                   	$db1 = new cDB();
        			$sql = "UPDATE hz_transfer_requests SET Status = 1 WHERE  requestID = ".$req_id;
        			if($db1->Query($sql))
                    {
                        $approved=1;
                        if(sendMailToReceiver($resultarr["Email"],"Adminstrator@hz.com","New Asset Transfer Request",$resultarr,$requestor_details))
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
                    $who = "fm";
        
                }
                
         }
        else
        {
            if($resultarr["FirstManagerRejected"]==1)
            {
               $fmanager_already_rejected=1; 
            }
            elseif($resultarr["Status"]==1)
            {
                $fmanager_already_approved=1;
            }
        }
}


//receivers responce
if(isset($_REQUEST["reapproved"]) && !empty($_REQUEST["request_id"]))
{
 	
    if($resultarr["Status"]=="1" && $resultarr["ReceiverRejected"]==0)//if request is not processed
        {
            if($_REQUEST["reapproved"]==1)
                {
                    $req_id = $_REQUEST["request_id"];
                   	$db1 = new cDB();
        			$sql = "UPDATE hz_transfer_requests SET Status = 2 WHERE  requestID = ".$req_id;
        			if($db1->Query($sql))
                    {
                        $reapproved=1;
                        if(sendMailToSecondManager($resultarr["Email"],"Adminstrator@hz.com","New Asset Transfer Request",$resultarr,$requestor_details))
                        {
                            $reapproved++;
                        }//send email to HOD
                    }
                    else
                    {
                        $reapproved=0;
                    }
                    
                }
                elseif($_REQUEST["reapproved"]==0)
                {
                    $ask_reason = 1;
                    $who = "re";
        
                }
                
         }
        else
        {
            if($resultarr["ReceiverRejected"]==1)
            {
               $re_already_rejected=1; 
            }
            elseif($resultarr["Status"]==2)
            {
                $re_already_approved=1;
            }
        }
}



//second manager responce
if(isset($_REQUEST["smapproved"]) && !empty($_REQUEST["request_id"]))
{
 	if($resultarr["Status"]=="2" && $resultarr["SecondManagerRejected"]==0)//if request is not processed
        {
        if($_REQUEST["smapproved"]==1 )
            {
                $req_id = $_REQUEST["request_id"];
               	$db1 = new cDB();
    			$sql = "UPDATE hz_asset_requests SET Status = 3 WHERE  requestID = ".$req_id;
    			if($db1->Query($sql))
                {
                    $smapproved=1;
                    if(sendMailToHOD2("Adminstrator@hz.com","New Asset Transfer Request",$resultarr,$requestor_details))
                    {
                        $smapproved++;
                    }//send email to HOD
                }
                else
                {
                    $smapproved=0;
                }
                
            }
            elseif($_REQUEST["smapproved"]==0)
            {
                $ask_reason = 1;
                $who = "sm";
    
            }
        }
        else
        {
            if($resultarr["SecondManagerRejected"]==1)
            {
               $smanager_already_rejected=1; 
            }
            elseif($resultarr["Status"]==3)
            {
                $smanager_already_approved=1;
            }
        }
}

//HOD responce
if(isset($_REQUEST["happroved"]) && !empty($_REQUEST["request_id"]))
{
 	
    	if($resultarr["Status"]=="3" && $resultarr["HodRejected"]==0)//if request is not processed
        {
            if($_REQUEST["happroved"]==1)
                {
                    $req_id = $_REQUEST["request_id"];
                   	$db1 = new cDB();
        			$sql = "UPDATE hz_transfer_requests SET Status = 4 WHERE  requestID = ".$req_id;
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
         else
        {
            if($resultarr["HodRejected"]==1)
            {
               $hod_already_rejected=1; 
            }
            elseif($resultarr["Status"]==4)
            {
                $hod_already_approved=1;
            }
        }
}


if(isset($_REQUEST["txtreason"]))
{
            $req_id = $_REQUEST["request_id"];
            
            if($_REQUEST["who_rejected"]=='fm') {$status =0 ;$who_rejected="FirstManagerRejected";$to=$requestor_details["email"];$whos_reason="FirstManagerRejectMsg"; $by=" by Manager"; }
            if($_REQUEST["who_rejected"]=='re') {$status =1 ;$who_rejected="ReceiverRejected";$to=$requestor_details["email"];$whos_reason="ReceiverRejectMsg";$by="by Receiver";}
            if($_REQUEST["who_rejected"]=='sm') {$status =2 ;$who_rejected="SecondManagerRejected";$to=$requestor_details["email"]." , ".$resultarr["email"];$whos_reason="SecondManagerRejectMsg";$by="by Receivers Manager";}
             if($_REQUEST["who_rejected"]=='hod') {$status =3 ;$who_rejected="HodRejected";$to=$requestor_details["email"]." , ".$resultarr["email"];$whos_reason="HodRejectMsg"; $by=" HOD";}
           	$db1 = new cDB();
			$sql = "UPDATE hz_transfer_requests SET ".$whos_reason." = '".mysql_real_escape_string($_REQUEST["txtreason"])."',Status=$status,".$who_rejected."=1 WHERE  requestID = ".$req_id;
			if($db1->Query($sql))
            {
                $rejected=1;
                if(sendMailToEmp($to,"Adminstrator@hz.com",$resultarr["HardwareID"],"rejected ".$by,$_REQUEST["txtreason"]))//send mail to employee
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
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Request has been forwarded to Receiver</p></div>";
        }
        elseif($approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Error forwarding request to Receiver</p></div>";
        
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Occured approving request, Please try again later!</h2></div>";
        }
   }
    if($fmanager_already_rejected || $fmanager_already_approved)
   {
        if($fmanager_already_approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>APPROVED</strong></h2></div>"; 
        }
        if($fmanager_already_rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>REJECTED</strong></h2></div>"; 
        }
   }
   //Receivers responce result
   if($reapproved)
   {
        if($reapproved==2)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Request has been forwarded to Manager</p></div>";
        }
        elseif($reapproved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Error forwarding request to Manager</p></div>";
        
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Occured approving request, Please try again later!</h2></div>";
        }
   }
    if($re_already_rejected || $re_already_approved)
   {
        if($re_already_approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>APPROVED</strong></h2></div>"; 
        }
        if($re_already_rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>REJECTED</strong></h2></div>"; 
        }
   }
   
   
   //Second manager responce result
   if($smapproved)
   {
        if($smapproved==2)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Request has been forwarded to HOD</p></div>";
        }
        elseif($smapproved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Approved</h2><p>Error forwarding request to HOD</p></div>";
        
        }
        else
        {
            echo "<div style='text-align:center;'><h2>Error Occured approving request, Please try again later!</h2></div>";
        }
   }
    if($smanager_already_rejected || $smanager_already_approved)
   {
        if($smanager_already_approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>APPROVED</strong></h2></div>"; 
        }
        if($smanager_already_rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>REJECTED</strong></h2></div>"; 
        }
   }
   
   // HOD responce result
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
   if($hod_already_rejected || $hod_already_approved)
   {
        if($hod_already_approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>APPROVED</strong></h2></div>"; 
        }
        if($hod_already_rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>REJECTED</strong></h2></div>"; 
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
