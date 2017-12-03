<?php 
$menu_flag = "order";
$pope	       = "pope_form";
include_once ("header.php");

if(empty($in['oid']))
{
	exit('参数错误!');
}else{
	$oinfo = $db->get_row("SELECT OrderID,OrderSN,OrderUserID,OrderStatus FROM ".DATATABLE."_order_orderinfo where OrderCompany = ".$_SESSION['uinfo']['ucompany']." and OrderID=".intval($in['oid'])." limit 0,1");

	if($oinfo['OrderStatus'] > 1) exit('错误地址!');
	$cinfo = $db->get_row("SELECT ClientID,ClientLevel,ClientName,ClientCompanyName,ClientTrueName,ClientPhone,ClientSetPrice FROM ".DATATABLE."_order_client where ClientCompany = ".$_SESSION['uinfo']['ucompany']." and ClientID=".$oinfo['OrderUserID']." limit 0,1");

		if(!strpos($cinfo['ClientLevel'],",") && substr($cinfo['ClientLevel'],0,1)==="l")
		{
			$cinfo['ClientLevel'] = "A_".$cinfo['ClientLevel'];
		}
}

if(empty($in['sid']))
{
	$sortinfo = null;
	$in['sid'] = 0;
}else{	 
	$sortinfo = $db->get_row("SELECT SiteID,ParentID,SiteName FROM ".DATATABLE."_order_site where CompanyID=".$_SESSION['uinfo']['ucompany']." and SiteID=".intval($in['sid'])." limit 0,1");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='robots' content='noindex,nofollow' />
<title><? echo SITE_NAME;?> - 管理平台</title>
<link rel="stylesheet" href="css/showpage.css" />
<script src="../scripts/jquery.min.js" type="text/javascript"></script>
<script src="../scripts/jquery.blockUI.js" type="text/javascript"></script>

<script src="js/order.js?v=<? echo VERID;?>" type="text/javascript"></script>
<style type="text/css">
<!--
a{text-decoration:none; color:#277DB7; }
a:hover{text-decoration:underline; color:#cc0000}
td,div,p{color:#333333; font-size:12px; line-height:150%;}
body { margin:0; padding:0; font-size:12px; background-color:#ffffff; font-family: "微软雅黑", Arial, Helvetica, sans-serif, "宋体"; color:#333;}
thead tr td{font-weight:bold;}
.redbtn {
     background:url(./img/f1.jpg);  color: #FFF;  border:#f45c0d 1px solid;  font-weight: bold;    font-size: 12px;  margin:0 8px 0 5px;  line-height:20px;  cursor: pointer;	height:24px;
}
.redbtn:hover {color:#f0f0f0; background:url(./img/f1s.jpg); }

.bluebtn {
   background:url(./img/f2.jpg);  color: #FFF;  border:#0774bc 1px solid;  font-weight: bold;    font-size: 12px;  margin:0 8px 0 5px;  line-height:20px;  cursor: pointer;	height:24px;
}
.bluebtn:hover {  color:#f0f0f0;  background:url(./img/f2s.jpg);}
.TitleNUM{font-size:12px; font-family: 'Lucida Grande', Verdana, sans-serif; color:#000}
.blockUI p{margin:4px; padding:8px 20px; font-size:14px; font-weight:bold}
.growlUI {  }
.growlUI h1, div.growlUI h2 {
	color: white; padding: 5px 5px 5px 15px; text-align: left; font-size:14px;
}
-->
</style>
</head>

<body> 

	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <form id="forms" name="forms" method="post" action="">
		  <input name="oid" id="oid" type="hidden" value="<? echo $in['oid'];?>"  />
		  <tr>
            <td width="7%" nowrap="nowrap"><strong>&nbsp;快速查询：</strong></td>
            <td width="17%" height="24" nowrap="nowrap">
              <label>
                <input type="text" name="kw" id="kw" size="20" value="<? if(!empty($in['kw'])) echo $in['kw'];?>" onfocus="this.select();" />
              </label>           
            </td>
            <td width="30%" nowrap="nowrap">            
				 <select name="sid" id="sid" style="width:185px; height:22px; margin:1px 2px;">
                    <option value="">⊙ 所有商品分类</option>
                    <? 
					$sortarr = $db->get_results("SELECT SiteID,ParentID,SiteName,SitePinyi FROM ".DATATABLE."_order_site where CompanyID=".$_SESSION['uinfo']['ucompany']." ORDER BY SiteOrder DESC,SiteID ASC ");
					echo ShowTreeMenu($sortarr,0,$in['sid'],1);
					?>
                  </select>                  
            </td>
            <td width="46%"><label>
              <input name="button3" type="submit" class="bluebtn" id="button3" value=" 查询 " />
            </label></td>            
          </tr>
		  </form>
        </table>
	<div style="width:100%; height:400px; overflow:auto;">
          <form id="MainForm" name="MainForm" method="post" action="" target="" >
			  <input type="hidden" name="selectid" id="selectid" value="<? if(!empty($in['selectid'])) echo $in['selectid'];?>" />
        	  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">               
               <thead>
                <tr>
                  <td width="5%" bgcolor="#efefef" align="center" height="22" >序号</td>
                  <td bgcolor="#efefef" >名称</td>
                  <td width="18%" bgcolor="#efefef" >编号/货号</td>				  
                  <td width="14%" align="right" bgcolor="#efefef" >价格(元)</td>
                    <td width="8%" align="right" bgcolor="#efefef">包装</td>
                  <td width="10%" align="center" bgcolor="#efefef" >颜色</td>
                  <td width="10%" align="center" bgcolor="#efefef" >规格</td>				  
				  <td width="8%" align="center" bgcolor="#efefef" >订购</td>
                </tr>
     		 </thead>      		
      		<tbody>
<?
		$sqlmsg = '';
		if(!empty($in['sid']))
		{
			$sarray = $db->get_col("select SiteID from ".DATATABLE."_order_site where ParentID=".$in['sid']." and CompanyID=".$_SESSION['uinfo']['ucompany']." order by SiteID asc");
			if(!empty($sarray))
			{
				$sinid      = implode(",", $sarray);
				$sitesdata = $db->get_col("select SiteID from ".DATATABLE."_order_site where CompanyID=".$_SESSION['uinfo']['ucompany']." and ParentID IN (".$sinid.")");
				if(!empty($sitesdata))  $sinid = $sinid.",".implode(",",$sitesdata);
				$sinid  = $in['sid'].",".$sinid;
				$sqlmsg  .= " and SiteID in ( ".$sinid." ) ";
			}else{
				$sqlmsg  .= " and SiteID = ".$in['sid']." ";
			}
		}
	//if(!empty($in['sid'])) $sqlmsg .= ' and SiteID='.$in['sid'].' ';
	if(!empty($in['kw']))
	{
	    $kwn = str_replace(' ','%',$in['kw']);
	    if(strpos($kwn,'%'))
	    {
	        $temsql = array();
	        $kwnarr = explode('%',$kwn);
	        foreach($kwnarr as $v)
	        {
	            $temsql[] = " Name like '%".$v."%' ";
	        }
	        $sqlmsg  .= " AND ((".implode(" AND ",$temsql).") OR (Pinyi like '%".$kwn."%' OR Coding like '%".$kwn."%' OR Barcode like '%".$kwn."%'))";
	    }else{
	        $sqlmsg  .= " and (Name like '%".$kwn."%' or Pinyi like '%".$kwn."%' OR Coding like '%".$kwn."%' OR Barcode like '%".$kwn."%') ";
	    }
	}
	$InfoDataNum = $db->get_row("SELECT count(*) AS allrow FROM ".DATATABLE."_order_content_index where CompanyID = ".$_SESSION['uinfo']['ucompany']." ".$sqlmsg." and FlagID=0 ");
	$page = new ShowPage;
    $page->PageSize = 12;
    $page->Total = $InfoDataNum['allrow'];
    $page->LinkAry = array("kw"=>$in['kw'],"sid"=>$in['sid'],"oid"=>$in['oid']);        
	
	$datasql   = "SELECT ID,SiteID,Name,Coding,Price1,Price2,Price3,Units,Casing,Color,Specification,CommendID FROM ".DATATABLE."_order_content_index where CompanyID = ".$_SESSION['uinfo']['ucompany']." ".$sqlmsg." and FlagID=0 ORDER BY OrderID DESC, ID DESC";
	$list_data = $db->get_results($datasql." ".$page->OffSet());
	$n=1;
	if(!empty($list_data))
	{
		if(!empty($in['page'])) $n = ($in['page']-1)*$page->PageSize+1;
		foreach($list_data as $lsv)
		 {
?>
                <tr id="line_<? echo $lsv['ID'];?>"  >
                  <td height="22" align="center" bgcolor="#FFFFFF" > <? echo $n++;?></td>
                  <td bgcolor="#FFFFFF" ><a href="product_content.php?ID=<? echo $lsv['ID'];?>" target="_blank" title="<? echo $lsv['Name'];?>" > <? echo $lsv['Name'];?></a></td>
                  <td bgcolor="#FFFFFF" ><? echo $lsv['Coding'];?>&nbsp;</td>
                  <td title="包装：<? echo $lsv['Casing'];?>" class="TitleNUM" bgcolor="#FFFFFF" align="right">¥ <? 
						if(empty($lsv['Price3']))
						{
							echo $lsv[$cinfo['ClientSetPrice']];
						}else{
							$price3 = setprice3($lsv['Price3'],$cinfo);
							if(!empty($price3))
							{
								echo $price3;
							}else{
								echo $lsv[$cinfo['ClientSetPrice']];
							}
						}				  
				  ?>&nbsp;/ <? echo $lsv['Units'];?>&nbsp;</td>
                    <td align="center" bgcolor="#ffffff"> <?php echo $lsv['Casing']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" >
				  <?
				  echo '<select name="color_'.$lsv['ID'].'" id="color_'.$lsv['ID'].'" style="width:98%;">';	
				  if(!empty($lsv['Color']))
					{
						$colorarr = @explode(",", $lsv['Color']);
						
						foreach($colorarr as $cvar)
						{
							echo '<option value="'.$cvar.'">'.$cvar.'</option>';
						}
					}
					echo '</select>';
				  ?>
				</td>
				  <td align="right" bgcolor="#FFFFFF">
				  <?
				  echo '<select name="spec_'.$lsv['ID'].'" id="spec_'.$lsv['ID'].'" style="width:98%;">';	
				  if(!empty($lsv['Specification']))
					{
						$specarr = @explode(",", $lsv['Specification']);
						
						foreach($specarr as $svar)
						{
							echo '<option value="'.$svar.'">'.$svar.'</option>';
						}					
					}
					echo '</select>';
				  ?>
				  </td>
                    <?php if($lsv['CommendID'] == 9){ ?>
                        <td align="center" bgcolor="#FFFFFF">
                            &#8250; 缺货
                        </td>
                    <?php }else{ ?>
                        <td align="center" bgcolor="#FFFFFF"><a onclick="javascript:addtocart_select('<? echo $lsv['ID'];?>','<? echo $oinfo ['OrderID'];?>','<? echo $cinfo['ClientID'];?>');" href="javascript:void(0);"><strong>&#8250; 订购</strong></a>&nbsp;</td>
                    <?php } ?>

              </tr>
			<? } }else{?>
						  <tr>
								 <td height="30" colspan="7" align="center" bgcolor="#FFFFFF">无符合条件的商品!</td>
						  </tr>
			<? }?>
 				</tbody>                
              </table>
                 <table width="96%" border="0" cellspacing="0" cellpadding="0">
     			 <tr>
					 <td width="60"><input type="button" value=" 返 回 " class="bluebtn" name="confirmbtn" id="confirmbtn" onclick="parent.closewindowui2()" /></td>
       			     <td align="right" height="30"><? echo $page->ShowLink('order_select_product.php');?></td>
     			 </tr>
              </table>
              <INPUT TYPE="hidden" name="referer" value ="" >
              </form>
       	  </div>

</body>
</html>
<?
 	function ShowTreeMenu($resultdata,$p_id=0,$s_id=0,$layer=1) 
	{
		$frontMsg  = "";
		$frontTitleMsg = "┠";
		$selectmsg = "";
		
		if($var['ParentID']=="0") $layer = 1; else $layer++;
					
		foreach($resultdata as $key => $var)
		{
			if($var['ParentID'] == $p_id)
			{
				$repeatMsg = str_repeat("-+-", $layer-1);
				if($var['SiteID'] == $s_id) $selectmsg = "selected"; else $selectmsg = "";
				
				$frontMsg  .= "<option value='".$var['SiteID']."' ".$selectmsg." > ".$frontTitleMsg.$repeatMsg.$var['SiteName']."</option>";	

				$frontMsg2  = "";
				$frontMsg2 .= ShowTreeMenu($resultdata,$var['SiteID'],$s_id,$layer);
				$frontMsg  .= $frontMsg2;
			}
		}		
		return $frontMsg;
	}

	function setprice3($p3,$cinfo)
	{
		$rp3 = '';
		$lkey = '';

		if(!empty($p3))
		{
			$pricearr = unserialize(urldecode($p3));
			//单个指定
			if(!empty($pricearr['clientprice'][$cinfo['ClientID']]))
			{
				$rp3 = $pricearr['clientprice'][$cinfo['ClientID']];
			}else{
				if(empty($pricearr['typeid'])) $pricearr['typeid'] = 'A';

				if(!empty($cinfo['ClientLevel']))
				{
					if(!strpos($cinfo['ClientLevel'],",") && substr($cinfo['ClientLevel'],0,1)==="l")
					{
						$cinfo['ClientLevel'] = "A_".$cinfo['ClientLevel'];
					}
					$clientlevelarr = explode(",", $cinfo['ClientLevel']);
					foreach($clientlevelarr as $cvar)
					{
						if($pricearr['typeid']==substr($cvar,0,1))
						{
							$lkey = substr($cvar,2);
							break;
						}
					}
				}
				if(!empty($pricearr[$lkey])) $rp3 = $pricearr[$lkey];
			}
		}
		return $rp3;
	}
?>
