
<style>
.success{
height: 175px;
display: none;

margin-top: 35px;
}
.success>p{
height: 60px;

text-align: center;
padding-top: 35px;
}
.icon-chenggong{
height: 95px;
width: 95px;

font-size: 95px;
color: #01A157;
}

.succ_notice{
text-align: center;

margin-top: 20px;
color: #666;
font-size: 14px;
}
</style>
<div class="success" id="success">
<p>
<i class="iconfont icon-chenggong"></i>
</p>
<i class="iconfont icon-weibiaoti101 close"></i>
<div class="succ_notice">恭喜您密码重置成功！</div>
</div>

<script type="text/javascript">
$(".close").click(function(){
layer.closeAll();
})
</script>
