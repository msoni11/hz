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
 	if($resultarr["Status"]=="0" && $resultarr["ManagerRejected"]==0)//if request is not processed
        {
        if($_REQUEST["mapproved"]==1 )
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
                $req_id = $_REQUEST["request_id"];
            //if($_REQUEST["who_rejected"]=='HOD') {$status =1 ;$whoRejected="HodRejected"; }
            $status =0 ; $whoRejected="ManagerRejected";
           	$db1 = new cDB();
			$sql = "UPDATE hz_asset_requests SET Status=$status ,".$whoRejected."= 1  WHERE  requestID = ".$req_id;
    			if($db1->Query($sql))
                {
                    $rejected=1;
                    if(sendMailToEmp($resultarr["email"],"Adminstrator@hz.com",$resultarr["HardwareID"],"rejected"))//send mail to employee
                    {
                       $rejected++; 
                    } 
                }
                else
                {
                   $rejected=0;
                }
            }
        }
        else
        {
            if($resultarr["ManagerRejected"]==1)
            {
               $manager_already_rejected=1; 
            }
            elseif($resultarr["Status"]==1)
            {
                $manager_already_approved=1;
            }
        }
}


//HOD responce
if(isset($_REQUEST["happroved"]) && !empty($_REQUEST["request_id"]))
{
 	
    	if($resultarr["Status"]=="1" && $resultarr["HodRejected"]==0)//if request is not processed
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
                $req_id = $_REQUEST["request_id"];
                $status =1 ;$whoRejected="HodRejected";
           
               	$db1 = new cDB();
    			$sql = "UPDATE hz_asset_requests SET Status=$status ,".$whoRejected."= 1  WHERE  requestID = ".$req_id;
        			if($db1->Query($sql))
                    {
                        $rejected=1;
                        if(sendMailToEmp($resultarr["email"],"Adminstrator@hz.com",$resultarr["HardwareID"],"rejected"))//send mail to employee
                        {
                           $rejected++; 
                        } 
                    }
                    else
                    {
                       $rejected=0;
                    }
                }
        }
        else
        {
            if($resultarr["HodRejected"]==1)
            {
               $hod_already_rejected=1; 
            }
            elseif($resultarr["Status"]==2)
            {
                $hod_already_approved=1;
            }
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
   
   if($manager_already_rejected || $manager_already_approved)
   {
        if($manager_already_approved==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>APPROVED</strong></h2></div>"; 
        }
        if($manager_already_rejected==1)
        {
            echo "<div style='text-align:center;min-height:300px;'><h2>Request Has Been Already Processed As:<strong>REJECTED</strong></h2></div>"; 
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
   ?>
	</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>
