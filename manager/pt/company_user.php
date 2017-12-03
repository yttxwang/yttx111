<?php 
include_once ("header.php");
$menu_flag = "manager";

if(!intval($in['ID']))
{
	exit('非法操作!');
}else{	 
    $info   = $db->get_row("SELECT CompanyID,CompanyName FROM ".DATABASEU.DATATABLE."_order_company where CompanyID=".intval($in['ID'])." limit 0,1");
    $infou = $db->get_row("SELECT * FROM ".DATABASEU.DATATABLE."_order_user where UserCompany=".intval($in['ID'])." and UserFlag='9' limit 0,1");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo SITE_NAME;?> - 管理平台</title>
<link href="css/main.css?v=<? echo VERID;?>" rel="stylesheet" type="text/css" />

<script src="../scripts/jquery.min.js" type="text/javascript"></script>
<script src="../scripts/jquery.blockUI.js" type="text/javascript"></script>

<script src="js/manager.js?v=<? echo VERID;?>" type="text/javascript"></script>
</head>

<body>
<?php include_once ("top.php");?>
<?php include_once ("inc/son_menu_bar.php");?>
        
    <div id="bodycontent">
    	<div class="lineblank"></div>
         <form id="MainForm" name="MainForm" enctype="multipart/form-data" method="post" target="exe_iframe"  action="">
			<input name="CompanyID" type="hidden" id="CompanyID" value="<? echo $info['CompanyID'];?>"  />
			<input name="UserID" type="hidden" id="UserID" value="<? if(!empty($infou['UserID'])) echo $infou['UserID'];?>"  />
			<div id="searchline">
        	<div class="leftdiv width300">
        	 <div class="locationl"><strong>&nbsp;&nbsp;当前位置：</strong><a href="manager.php">客户管理</a> &#8250;&#8250; <a href="company_user_add.php">客户管理员帐号</a></div>
   	        </div>            
			
            <div class="rightdiv sublink" style="padding-right:20px; padding-top:4px;"><ul><li><a href="javascript:void(0);" onclick="do_save_company_user();" >保 存</a></li><li><a href="company_user_add.php">重 置</a></li><li><a href="manager.php">返 回</a></li></ul></div>            
        </div>
    	
        <div class="line2"></div>
        <div class="bline" >
			<fieldset title="“*”为必填项！" class="fieldsetstyle">      
			<legend>(<? echo $info['CompanyName'];?>) 登陆信息 [<? if(empty($infou)) echo '<font color=red>新增</font>'; else echo '<font color=red>修改</font>';?>]</legend>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF"  class="inputstyle">        
			    <tr>
                  <td width="16%" bgcolor="#F0F0F0"><div align="right">登陆帐号：</div></td>
                  <td width="55%"><label>
                    <input name="data_UserName" type="text" id="data_UserName" value="<? if(!empty($infou['UserName'])) echo $infou['UserName']; ?>"  maxlength="18" />
                    <span class="red">*</span></label></td>
                  <td width="29%">可以是数字、字母、下划线(3-18位)</td>
                </tr>
                <tr>
                  <td bgcolor="#F0F0F0"><div align="right">登陆密码：</div></td>
                  <td><input name="data_UserPass" type="text" id="data_UserPass" value=""  maxlength="18" />
                  </td>
                  <td>注：不修改密码时请不要填写</td>
                </tr>
            </table>
           </fieldset>  
            
            <br style="clear:both;" />
            <fieldset class="fieldsetstyle">
		    <legend>基本资料</legend>
              <table width="98%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="inputstyle">
             
                <tr>
                  <td width="16%" bgcolor="#F0F0F0"><div align="right">姓名：</div></td>
                  <td width="55%" bgcolor="#FFFFFF"><label>
                    <input type="text" name="data_UserTrueName" id="data_UserTrueName"  value="<? if(!empty($infou['UserTrueName'])) echo $infou['UserTrueName']; ?>" />
                    <span class="red">*</span></label></td>
                  <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#F0F0F0"><div align="right">部门职务：</div></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="data_UserPhone" id="data_UserPhone"  value="<? if(!empty($infou['UserPhone'])) echo $infou['UserPhone']; ?>" /></td>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>

                <tr>
                  <td bgcolor="#F0F0F0"><div align="right">备 注：</div></td>
                  <td bgcolor="#FFFFFF"><textarea name="data_UserRemark" rows="5" id="data_UserRemark"><? echo $infou['UserRemark'];?></textarea>
                  &nbsp;</td>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </table>
			</fieldset>

			<br style="clear:both;" />

          <div class="rightdiv sublink" style="padding-right:20px;"><ul><li><a href="javascript:void(0);" onclick="do_save_company_user();" >保 存</a></li><li><a href="company_user_add.php">重 置</a></li><li><a href="manager.php">返 回</a></li></ul></div>
            
        	</div>
              <INPUT TYPE="hidden" name="referer" value ="" >
              </form>
			<br style="clear:both;" />
    </div>
    
<? include_once ("bottom.php");?>	
<iframe name="exe_iframe" style="width:0; height:0;" frameborder="0" scrolling="no"></iframe> 
</body>
</html>