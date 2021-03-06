$(document).ready(function(){

    $('#topcart').mouseover(function(){
		loadcart();
	});
	$('#topcart').mouseleave(function(){
		hidecart();
	});
});

function loadcart()
{
	
	if($("#Shopping_Cart_info").css('display') == 'none' || $("#Shopping_Cart_info").css('display') == ''){
		$("#Shopping_Cart_info").css('display','block');
		$("#Shopping_Cart_info").load('cart.php?mt=load_cart');
	}
}

function hidecart()
{	
	if($("#Shopping_Cart_info").css('display') == 'block'){
		$("#Shopping_Cart_info").css('display','none');
	}
}

function Trim(str)
{ 
	return str.replace(/^\s*|\s*$/g,""); 
}

function jumptourl(tourl)
{
	jtime = 1000;
	setTimeout("window.location.href='"+tourl+"'",jtime)
}

function addtocart(pid,cstype)
{
	if(cstype=="N")
	{
		showinnumcart(pid);
		window.setTimeout("hideshow('shareit-box')",60000);
	}else{
		pid = pid.replace("n_",""); 
		$('#shareit-box').hide();
		window.setTimeout("showcartdiv("+pid+")",1);
	}	
}

function showinnumcart(pid)
{
	var cartid = $("#shareit_"+pid);
	pid = pid.replace("n_","");
	var height = cartid.height();
	var top = cartid.offset().top-120;
	var left = cartid.offset().left + (cartid.width() /2) - ($('#shareit-box').width() / 2);
	$('#shareit-box').show();
	$('#shareit-box').css({'top':top, 'left':left});	
	$('#shareit-field').focus();
	$('#togoodsid').val(pid);
	$('#shareit-field').val(1);
	$('#show_units_cart').html($('#show_units_cart_'+pid).html());
}

function saveonetocart()
{
		$.growlUI('正在操作，请稍候...');
		$.post("cart.php",
			{m:"addtocart", pid: $('#togoodsid').val(), pnum:$('#shareit-field').val(), pcolor: '', pspec: '' },
			function(data){
				if(data.backtype=='ok'){
					$.growlUI('该商品预订成功！您目前共订购 '+data.cartnum+' 种商品。<br />点击 <a href="cart.php" target="_parent">查看购物车</a> 浏览已预订的商品。');						
					carths(data.cartnum);						
				}else{
					$.growlUI(data.cartnum);
				}
			},"json");

		hideshow('shareit-box');
		window.setTimeout("hideshow('tip')",20000);
}

function showcartdiv(pid)
{
		$('#windowContent').html('<iframe src="tocart.php?ID='+pid+'" width="540" marginwidth="0" height="340" marginheight="0" align="middle" frameborder="0" scrolling="no"></iframe>');	
		$.blockUI({ 
			message: $('#windowForm'),
			css:{ 
					width: '540px',height:'350px',top:'15%'
				}			
			});
		$('.blockOverlay').attr('title','点击返回').click($.unblockUI);
}

function updatecartnumber()
{
		$.post("cart.php",
			{m:"get_cart_product_number"},
			function(data){
				data = Trim(data);
				if(data.length < 5){
					$.growlUI('该商品预订成功！您目前共订购 '+data+' 种商品。<br />点击 <a href="cart.php" target="_parent">查看购物车</a> 浏览已预订的商品。');
					carths(data);	
					closewindowui();
				}else{
					$.growlUI(data);
				}
			}
		);
}

function updatecartsub()
{
		$.growlUI('正在操作，请稍候...');
		$('#nextordercart').attr("disabled","disabled");
		$.post("cart.php?m=updatecartsubmit", $("#formcart").serialize(),
			function(data){
				data = Trim(data);
				if(data == "ok"){
					$.growlUI('执行成功，正在载入页面！');
					document.location='order.php';					
				}else{
					$.growlUI(data);
					$('#nextordercart').removeAttr('disabled');
				}
			}			
		);
}

function addtowishlist(pid)
{
		$.post("wishlist.php",
			{m:"addtowishlist", pid: pid},
			function(data){
				data = Trim(data);
				if(data == "ok"){
					$.growlUI('收藏成功！<br />点此可以 <a href="wishlist.php">查看</a> 我收蒧的商品...');
				}else{
					$.growlUI(data);
				}
			}			
		);
}

function removewishlist(pid)
{	
	if(confirm("您确定要从收藏夹移除该商品吗?"))
	{
			$.post("wishlist.php",
				{m:"removewishlist", pid: pid},
				function(data){
					data = Trim(data);
					if(data == "ok"){
						$("#linegoods_"+pid).animate({opacity: 'hide'}, 'slow');
						$.growlUI('移除成功！');
					}else{
						$.growlUI(data);
					}
				}			
			);
		window.setTimeout("hideshow('tip')",20000);
	}
}

function cancelorder(oid)
{
	if(confirm("您确定要作废此订单吗?"))
	{	
			$.post("my.php",
				{m:"cancelorder", oid: oid},
				function(data){
					data = Trim(data);
					if(data == "ok"){
						$("#ajaxstart").animate({opacity: 'hide'}, 'slow');
						$("#statustext_"+oid).html('客户作废');
						$("#allertidtext").html('操作成功...');
						$("#allertid").animate({opacity: 'show'}, 'slow');
					
						window.setTimeout("hideshow('allertid')",10000);
					}else{
						$("#ajaxstart").animate({opacity: 'hide'}, 'slow');
						$("#allertidtext").html(data);
						$("#allertid").animate({opacity: 'show'}, 'slow');
					}
				}			
			);
	}
}

function carths(numgoods)
{
	$("#cartnumber").html(numgoods);
	$("#cartnumber_2").html(numgoods);
	$('.right-slide .slide-cart .slide-cart-num').remove();
	if(numgoods>0){
		$('.right-slide .slide-cart').append('<span class="slide-cart-num">'+numgoods+'</span>');
	}
}

function guestorderadd()
{	
	$.growlUI('正在操作，请稍候......');
	if($("#AddressContact").val()=="" || $("#AddressPhone").val()=="" || $("#AddressAddress").val()=="")
	{
		$.growlUI('收货人 / 联系电话 / 详细地址 不能为空,为保证商品准确送达，请填写完整收货信息!');

	}else if( ($("input[name='invoicetype']:checked").val() == 'P' || $("input[name='invoicetype']:checked").val() == 'Z') && $('#InvoiceHeader').val() == ''){
		$.growlUI('提示：请填写开票抬头!');

	}else if($('#delivery_time').val()=="B" && $('#DeliveryDate').val()==""){
		$.growlUI('提示：请选择交货日期!');
	}else{

		$('#addorder').attr("disabled","disabled");
		$.post("order.php?m=guestadd",$("#formorder").serialize(),
			function(data){

				if(data.backtype == "ok")
				{
					$.growlUI('提交成功，正在载入页面...');
					var jumpurl = 'order.php?id='+data.sn;
					jumptourl(jumpurl);
				}else if(data.backtype == "empty"){
					$.growlUI('库存数量不够，请先返回购物车调整数量，再提交!');
					var jumpurl = 'cart.php';
					jumptourl(jumpurl);
				}else{
					$.growlUI(data.sn);
				}
		},"json");
	}
}

function noticegoods(gid)
{
	window.setTimeout("shownoticediv("+gid+")",1);
}

function shownoticediv(gid)
{
		$('#windowContent').html('<iframe src="notice.php?gid='+gid+'" width="340" marginwidth="0" height="210" marginheight="0" align="middle" frameborder="0" scrolling="no"></iframe>');	
		$.blockUI({ 
			message: $('#windowForm'),
			css:{ 
					width: '340px',height:'220px',top:'15%'
				}			
			});
		$('#windowForm').css("width","340px");
		$('.blockOverlay').attr('title','点击返回').click($.unblockUI);
}

function changeupnumber(sspec,hcolor,packagenum)
{
	var iputid = "inputn_"+sspec+"_"+hcolor;
	var inum = document.getElementById(iputid).value;
	inum = parseInt(inum);
	if(packagenum==0 || inum%packagenum == 0 )
	{
		$.post("cart.php?m=change_input_number&color="+hcolor+"&spec="+sspec+"", $("#MainFormNumber").serialize(),
			function(data){
				if(data.backtype == "ok")
				{					
					//$("#inputn_"+sspec+"_hj").val(data.hjvalue);
					//$("#inputn_"+hcolor+"_sj").val(data.sjvalue);
					//$("#inputn_total").val(data.totalvalue);
					document.getElementById("inputn_"+sspec+"_hj").value = data.hjvalue;
					document.getElementById("inputn_"+hcolor+"_sj").value = data.sjvalue;
					document.getElementById("inputn_total").value = data.totalvalue;
				}
			},"json");
	}else{
		alert('订购数量必需为 “'+packagenum+'”的整倍数！');	
		document.getElementById(iputid).value = packagenum;
	}
}

function do_change_cart_number(pid,packagenum)
{
	var allnumber = document.getElementById("inputall_cart_number").value;
	allnumber = parseInt(allnumber);
	if(packagenum==0 || allnumber%packagenum == 0 )
	{
		window.location.href = 'tocart.php?ID='+pid+'&allnumber='+$('#inputall_cart_number').val()+'';
	}else{
		alert('订购数量必需为 “'+packagenum+'”的整倍数！');		
	}
}

function checkcartnumber(kid,packagenum,tf='')
{
	var allnumber = document.getElementById(kid).value;
	allnumber = parseInt(allnumber);
	if(packagenum!=0 && allnumber%packagenum != 0 )
	{
		alert('订购数量必需为 “'+packagenum+'”的整倍数！');	
		document.getElementById(kid).value = packagenum;
	}
	else{
		if(tf=='cart'){
			$.growlUI('正在操作，请稍候...');
			$.post("cart.php?m=updatecart", $("#formcart").serialize(),
				function(data){
					data = Trim(data);
					if(data.length < 5){
						carths(data);	
						$.growlUI('更新成功，正在载入页面！');
					}else{
						$.growlUI(data);
					}
				}			
			);
		}
		else if(tf=='load_cart'){
			$.growlUI('正在操作，请稍候...');
			$.post("cart.php?m=updatecart&n=load_cart", $("#formloadcart").serialize(),
				function(data){
					data = Trim(data);
					if(data.length < 5){
						carths(data);	
						$.growlUI('更新成功，正在载入页面！');
						$("#Shopping_Cart_info").load('cart.php?mt=load_cart');
					}else{
						$.growlUI(data);
					}
				}			
			);
		}
	}
}

function add_input_number()
{
	$.blockUI({ message: "<p>正在执行，请稍后...</p>" });
	$('#addtocart').attr("disabled","disabled");
	$.post("cart.php?m=add_input_number_save", $("#MainFormNumber").serialize(),
		function(data){
			data = Trim(data);
			if(data == "ok")
			{					
				parent.updatecartnumber();
			}else{
				alert(data);
				$('#addtocart').removeAttr('disabled');
			}
		});
		closewindowui();
}

function closewindowui()
{
	$.unblockUI();
	//window.setTimeout($.unblockUI, 2000);
}

function select_product()
{
	$("#windowtitle").html('快速订购');
	$('#windowContent').html('<iframe src="list.php?m=select&kw='+$('#inputsp').val()+'&selectid='+$('#selectid_storage').val()+'" width="100%" marginwidth="0" height="440" marginheight="0" align="middle" frameborder="0" scrolling="no"></iframe>');
	$.blockUI({ 
		message: $('#windowForm6'),
		css:{ 
                width: '720px',height:'480px',top:'8%'
            }			
		});
	$('#inputsp').val('');
	$('.blockOverlay').attr('title','点击返回').click($.unblockUI); 
}


function backtocart()
{
		$.growlUI('正在操作，请稍候...');
		parent.document.location='cart.php';					
}

function quicktocart(pid,cstype)
{
	if(cstype=="N")
	{
			showinnumcartquick(pid);
			window.setTimeout("hideshow('shareit-box')",60000);
	}else{
			$('#shareit-box').hide();
			window.setTimeout("showcartdivquick("+pid+")",1);
	}
}

function showinnumcartquick(pid)
{
	var cartid = $("#shareit_"+pid);
	var height = cartid.height();
	var top = cartid.offset().top-40;
	var left = cartid.offset().left + (cartid.width() /2) - ($('#shareit-box').width() / 2)-100;		
	$('#shareit-box').show();
	$('#shareit-box').css({'top':top, 'left':left});	
	$('#shareit-field').focus();
	$('#togoodsid').val(pid);
	$('#shareit-field').val(1);
}

function showcartdivquick(pid)
{
		$('#windowContent').html('<iframe src="tocart.php?ID='+pid+'" width="540" marginwidth="0" height="340" marginheight="0" align="middle" frameborder="0" scrolling="no"></iframe>');	
		$.blockUI({ 
			message: $('#windowForm'),
			css:{ 
					width: '540px',height:'350px',top:'5%',left:'75px'
				}			
			});
		$('.blockOverlay').attr('title','点击返回').click($.unblockUI);
}

function update_load_cart(tf)
{
		$.growlUI('正在操作，请稍候...');
		$.post("cart.php?m=update_load_cart", $("#formloadcart").serialize(),
			function(data){
				data = Trim(data);
				if(data.length < 5){
					carths(data);
					$.growlUI('更新成功，正在载入页面！');
					if(tf=="sub")  window.location.href = 'cart.php';	else $("#Shopping_Cart_info").load('cart.php?mt=load_cart');
				}else{
					$.growlUI(data);
				}
			}			
		);
}

function remove_load_cart(kid)
{
		$.growlUI('正在操作，请稍候...');
		$.post("cart.php?m=removecart", {kid:kid},
			function(data){
				data = Trim(data);
				if(data.length < 5){
					carths(data);	
					$.growlUI('更新成功，正在载入页面！');
					$("#Shopping_Cart_info").load('cart.php?mt=load_cart');
				}else{
					$.growlUI(data);
				}
			}			
		);
}

function delete_cart(kid)
{
	$("#kiddel_"+kid).val('del');
	$.growlUI('正在操作，请稍候...');
		$.post("cart.php?m=updatecart", $("#formcart").serialize(),
			function(data){
				data = Trim(data);
				if(data.length < 5){
					carths(data);	
					$.growlUI('更新成功，正在载入页面！');
					window.location.href = 'cart.php';
				}else{
					$.growlUI(data);
				}
			}			
		);
}