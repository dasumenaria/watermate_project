<?php

if(empty($active))
{ $active="";
}
?>


<div role="alert" aria-live="polite" class="toast-top-right" id="toast-container" style="display:none; padding-top:40px"><div style="" class="toast " id="hide"><button role="button"class="toast-close-button"></button><div class="toast-title">Create Account</div><div class="toast-message"> </div></div></div>


 <div id="message"></div>
  <div ng-spinner-bar="" class="page-spinner-bar hide">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
		<div class="bounce3"></div>
	</div>
<div class="row">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom tabbable-border">
            <ul class="nav nav-tabs">
                <li <?php if(empty($active) || $active==1){?> class="active"<?php } else {?>class=""<?php }?>  >
                    <a aria-expanded="true" href="#tab_1_1" data-toggle="tab">Profile

                    </a>
                </li>
               
            </ul>
            <div class="tab-content">
                <div <?php if(empty($active) || $active=='1'){?> class="tab-pane fade active in"<?php } else {?>class="tab-pane fade"<?php }?>  id="tab_1_1">
                                  
                                <div class="portlet box" style="background-color:#E26A6A">
                                <div class="portlet-title">
                                <div class="caption">
                                <i class="fa fa-check" style="color:#FFF"></i> User Rights
                                </div>
                                </div>
                                <div class="portlet-body form">
                            
                                <form  class="form-horizontal" role="form" method="post">    
								<?php
                                @$fetch_user_right=$this->requestAction(array('controller' => 'Handler', 'action' => 'user_rights'), array());
                                foreach($fetch_user_right as $data)
                                {
                                	$user_right[]=$data['user_right']['module_id'];
                                }
                                ?>
                                <div class="form-body">
                                
                                
                                      <div class="form-group">
                                                <label class="control-label col-md-3">Login ID</label>
                                                <div class="col-md-4">
                                                    <select class="form-control input-medium select2me  user_id"  name="user_id" id="user_id" placeholder="Select ID...">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach($fetch_login as $data)
                                                    {
														?>
														<option value="<?php echo $data['login']['id']; ?>"><?php echo $data['login']['login_id']; ?> </option>
														<?php
                                                    }
                                                    ?>
                                                    </select>
                                                    <span class="help-block">
                                                    Provide your login id to assign rights</span>
                                                </div>
                                            </div>
                                        
                                    <div class="form-group" >
                                    <div style="width:85%; margin-left:50px">
                                        <div class="" id="user_data">
                                        </div>
                                        </div>
                                    </div>
                                    
                                            
                                </div>
                                </form>
                               
                                </div>
                                </div></div></div></div></div></div>
<script src="<?php echo $this->webroot; ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#user_id').live('change',function(){
		$(".page-spinner-bar").removeClass("hide");
		var id=$(this).val();
		$.ajax({
		url: "ajax_php_file?user_rights=1&q="+user_id,
		type: "POST",         
		success: function(data)
		{
			$("#user_data").html(data);
			$(".page-spinner-bar").addClass(" hide"); 
		}
		})
		
	});
	
	$('#check_all').live('click',function(){
		if($('#check_all').is(":checked"))
		{
			$(".check").prop('checked', true);
		}
		else
		{
			$(".check").removeAttr('checked');
		}
		
	});
		
});		
</script>