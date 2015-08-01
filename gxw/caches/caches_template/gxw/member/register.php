<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header-bf'); ?>

  
    <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>member_common.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>

    <link href="<?php echo CSS_PATH;?>dialog_simp.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CSS_PATH;?>/gxw/css/base.css" rel="stylesheet" type="text/css" />
    <style>
        .onError,.onCorrect,.onFocus,.onShow,.onLoad{
            width: 170px;
            display: inline;
            margin-left: 10px;
            font-size: 14px;;
        }

        .x-content{
            margin:0 auto;
        }
        .input-focus{
            height: 18px;
            border: 1px solid #ccc;
            padding: 8px;
            width: 200px;
            margin-left: -5px;
        }
        #content{
            background:transparent;
            border:0;
        }
        .input{
            margin:12px 0;
        }
        .input-text{
            width: 200px;
            height: 18px;
            border: 1px solid #ccc;
            padding: 8px;
            margin-left: -5px;
        }
        .form{
            display: inline-block;
        }
        label{

            display: inline-block;
            width: 130px;
            text-align: right;
            line-height: 26px;
        }
        .reg-widget{
            width: 640px;
            padding: 38px 10px 10px 69px ;
            display:none;
            margin: 39px 0 0;
            border: 0;
           /* border-right: 1px solid #ddd;*/
        }
        .login-input{
            width: 100%;
            margin:16px 0;
        }
        .next-bt{
            margin-left: 180px;
        }
        .tijiao-bt{
            width: 150px;
            margin-left: 20px;
        }

        .back_pre{
            background: #55acef;
            color: #fff;
            font-size: 16px;
            line-height: 36px;
            box-shadow: none;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            margin-left: 130px;
        }
        #protocol{
            margin-left: 135px;
        }
        .add{
            margin-left: -5px;
        }
        label{
            vertical-align: middle;
        }
       .onFocus,.onShow{
        	color:#aaa;
        }
        .x-content{
            height:656px;
            background:rgba(255,255,255,0.95);
        }
        .h38,.input-text{
            border:1px solid #ddd;
            border-radius: 2px;
            height:14px;
            width:240px;
            margin-left:10px;
        }
        .reg-liucheng {
            margin:0 0 0 90px;
            width:980px;
        }
        .step-line{
            width:320px;
        }
        .liji-denglu{
            position: absolute;
            top: 168px;
            left: 722px;
            height: 311px;
            border-left: 1px solid #ccc;
            padding: 30px 43px 30px;
        }
        .liji-denglu a{
            font-weight: 700;
            color:#02a1d0;
        }
        .input{
            position: relative;
            height:130px;
        }
        .input label{
              padding-top: 20px;
        }
        .input .form{
            position: absolute;
           top: -32px;
             left: 137px;
        }
        .input .form .upload-pic img{
            width:192px !important;
            height:124px !important;
        }
        .x-content{
            height:666px;
        }
    </style>
    <script language="JavaScript">
    $(function(){
    	$(":text").attr("class","h38 w200");
    	  $(".next-bt").click(next);
          $(".prev-bt").click(prev);
          
          var nowIndex=0,prevObj=null;
          function prev(){
        	
            $(".step").eq(nowIndex).removeClass("step-active");
          	nowIndex--;
          	if(prevObj != null){
          		$(prevObj).css("display","none");
          	}
          	prevObj=$(".reg-widget").eq(nowIndex);
          	$(".step").eq(nowIndex).addClass("step-active");
          	$(prevObj).eq(nowIndex).css("display","block");
          }
          function next(){
        	  
        	if($(".onCorrect").length >=5){
        		$(".reg-widget").eq(nowIndex).css("display","none");
              	nowIndex++;
              	if(prevObj != null){
              		$(prevObj).css("display","none");
              	}
              	prevObj=$(".reg-widget")[nowIndex];
              	$(".step").eq(nowIndex).addClass("step-active");
              	$(prevObj).css("display","block");
        	}else{
        	}
          	
          }
          

          /*检查第二页是否全部填写数据*/

          $("#tijiao_btn").click(function(){
              var sumtemp="";
              $(".reg-widget").eq(1).find("input").each(function () {
                  if($(this).val()==""){
                      sumtemp= sumtemp+$(this).parent().parent().parent().find("label").text() +" ";
                      $(this).addClass("checkerror");
                  }else{
                      $(this).removeClass("checkerror");
                  }
              });

              if($(".checkerror").length>0){
            	  sumtemp=sumtemp.replace(new RegExp("：",'gm'),"、");
             	  alert("请上传"+sumtemp+"再提交");
                  return false;
              }else{
                  return true;
              }

          });
    })
        $(function ($member_setting){
            $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
            $("#username").formValidator({onshow:"<?php echo L('input').L('username');?>",onfocus:"<?php echo L('username').L('between_2_to_20');?>(请勿使用中文)"}).inputValidator({min:2,max:20,onerror:"<?php echo L('username').L('between_2_to_20');?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('username').L('format_incorrect');?>"}).ajaxValidator({
                type : "get",
                url : "",
                data :"m=member&c=index&a=public_checkname_ajax",
                datatype : "html",
                async:'false',
                success : function(data){
                    if( data == "1" ) {
                        return true;
                    } else {
                        return false;
                    }
                },
                buttons: $("#dosubmit"),
                onerror : "<?php echo L('deny_register').L('or').L('user_already_exist');?>",
                onwait : "<?php echo L('connecting_please_wait');?>"
            });
            $("#password").formValidator({onshow:"<?php echo L('input').L('password');?>",onfocus:"<?php echo L('password').L('between_6_to_20');?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20');?>"});
            $("#pwdconfirm").formValidator({onshow:"<?php echo L('input').L('cofirmpwd');?>",onfocus:"<?php echo L('passwords_not_match');?>",oncorrect:"<?php echo L('passwords_match');?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('passwords_not_match');?>"});
            $("#email").formValidator({onshow:"<?php echo L('input').L('email');?>",onfocus:"<?php echo L('email').L('format_incorrect');?>",oncorrect:"<?php echo L('email').L('format_right');?>"}).inputValidator({min:2,max:32,onerror:"<?php echo L('email').L('between_2_to_32');?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo L('email').L('format_incorrect');?>"}).ajaxValidator({
                type : "get",
                url : "",
                data :"m=member&c=index&a=public_checkemail_ajax",
                datatype : "html",
                async:'false',
                success : function(data){
                    if( data == "1" ) {
                        return true;
                    } else {
                        return false;
                    }
                },
                buttons: $("#dosubmit"),
                onerror : "<?php echo L('deny_register').L('or').L('email_already_exist');?>",
                onwait : "<?php echo L('connecting_please_wait');?>"
            });


            $(":checkbox[name='protocol']").formValidator({tipid:"protocoltip",onshow:"<?php echo L('read_protocol');?>",onfocus:"<?php echo L('read_protocol');?>"}).inputValidator({min:1,onerror:"<?php echo L('read_protocol');?>"});
		  	 <?php echo $formValidator;?>
            });
              function show_protocol() {
                   art.dialog({lock:false,title:'<?php echo L('register_protocol');?>',id:'protocoliframe', iframe:'?m=member&c=index&a=register&protocol=1',width:'500',height:'310',yesText:'<?php echo L('agree');?>'}, function(){
                       $("#protocol").attr("checked",true);
                   });
               }




    </script>
</div>

<div id="content">


    <div class="x-content">
        <div class="reg-liucheng ">
            <div class="step step-active">
                <div class="step-quan ">1</div>
                <p>创建账号</p>
            </div>
            <span class="step-line"></span>
            <div class="step">
                <div class="step-quan">2</div>
                <p>完善企业信息</p>
            </div>
            <span class="step-line"></span>
            <div class="step">
                <div class="step-quan"> ✔</div>
                <p>注册成功</p>
            </div>
        </div>

        <?php if(!isset($_GET['t'])) { ?>

        <form method="post" action="" id="myform">
           
            <div id="form1" class="reg-widget" style="display:block">

                <input name="modelid" type="hidden" value="<?php echo $modelid;?>"/>
                <input type="hidden" name="siteid" value="<?php echo $siteid;?>" />
                <input type="hidden" id="groupid" name="groupid" value="12"/>
                <input type="hidden" id="status" name="status" value="0"/>
				
				<div class="login-input"><label><font color=red>*</font>单位名称：</label>
                <input type="text" id="nickname" name="nickname" size="36" class="h38 w200"/></div>
               

                <div class="login-input"><label><font color=red>*</font>用&nbsp&nbsp户&nbsp&nbsp名：</label>
                <input type="text" id="username" name="username" size="36" class="h38 w200"/>

                </div>
               
                <div class="login-input"><label><font color=red>*</font>密&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp码：</label>
                <input type="password" id="password" name="password" size="36" class="h38 w200"/></div>
               
                <div class="login-input">
                	<label><font color=red>*</font><?php echo L('cofirmpwd');?>：</label>
                	<input type="password" name="pwdconfirm" id="pwdconfirm" size="36" class="h38 w200"/>
                </div>
               
                <div class="login-input">
                	<label><font color=red>*</font>邮&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp箱：</label>
                	<input type="text" id="email" name="email" size="36" class="h38 w200"/>
                </div>
                
           
                   <?php $v=$forminfos['basic_mobile']?>
                 <div class="login-input">
                	<label><font color=red>*</font><?php echo $v['name'];?>：</label>
                		<?php echo $v['form'];?>
                </div>
                <div class="liji-denglu">   
                    已经有项目库账号? <a href="index.php?m=member&c=index&a=login">立即登录</a>
                </div>        



                <div class="login-input"><input type="button" style="background: #55acef;color:#fff" value="下一步" class="next-bt"/></div>
            </div>


            <div class="reg-widget" style="display:">
                <script type="text/javascript" src="statics/js/swfupload/swf2ckeditor.js"></script>
                <div class="zhengjian">
                    <h2>证件范例（仅供参考，实际以用户原件图为准）：</h2>
                    <div class="zhengjian-fb">
                        <img src="<?php echo IMG_PATH;?>denglu/zj1.png" alt="">
                        <p>营业执照范本</p>
                    </div>
                    <div class="zhengjian-fb">
                        <img src="<?php echo IMG_PATH;?>denglu/zj2.png" alt="">
                        <p>组织机构代码证范本</p>
                    </div>
                    <div class="zhengjian-fb">
                        <img src="<?php echo IMG_PATH;?>denglu/zj3.png" alt="">
                        <p>税务登记证范本</p>
                    </div>
                    <h3><img src="<?php echo IMG_PATH;?>denglu/lampRed.png" alt="">请保证所传证件照对应示例红框区域内文字清晰可识别</h3>
                </div>
                <?php $v=$forminfos['basic_zhiz']?>
                <div class="input"><label style="height:;display:block;text-align:left;"><?php if($v['isbase']) { ?><font color=red>*</font><?php } ?> <?php echo $v['name'];?>：<?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></label><div class="form"><?php echo $v['form'];?></div></div>
                <?php $v=$forminfos['basic_zuzz']?>
                <div class="input"><label style="height:;display:block;text-align:left;"><?php if($v['isbase']) { ?><font color=red>*</font><?php } ?> <?php echo $v['name'];?>：<?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></label><div class="form"><?php echo $v['form'];?></div></div>
                <?php $v=$forminfos['basic_suiw']?>
                <div class="input"><label style="height:;display:block;text-align:left;"><?php if($v['isbase']) { ?><font color=red>*</font><?php } ?> <?php echo $v['name'];?>：<?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></label><div class="form"><?php echo $v['form'];?></div></div>
             
             <?php if($member_setting['enablcodecheck']=='1' && $sms_setting['sms_enable']!='1') { ?>
           		 <div class="input"><label><?php echo L('checkcode');?>：</label><input type="text" id="code" name="code" size="10" class="input-text"><?php echo form::checkcode('code_img', '5', '14', 120, 26);?></div>
              <?php } ?>


            <div class="reg">

                <div class="submit"> 
                	<input type="button" value="上一步" class="tijiao-bt prev-bt" style="color:#fff;padding:0px" />
                	<input type="submit" name="dosubmit" value="提交" class="tijiao-bt" id="tijiao_btn" /></div><br />
	              
	                <div style="display:none;">
	                <input type="checkbox" name="protocol" id="protocol" value="protocol" checked/>
	             <!--   <a   href="javascript:void(0);" onclick="show_protocol();return false;" class="blue"><?php echo L('click_read_protocol');?>
	                </a>
	                 --> 
	                </div>
            </div>
    	</div>
        </form>

        <?php } ?>
    </div><!--第二步end-->

    <div class="reg-widget" style="display:">
        <div class="tijiao-suc">
            <h4>信息提交成功！</h4>
            <p>我们将在三个工作日内完成帐号认证申请的审核，请留意注册时填写的邮箱和注意接听注册时填写的电话通知。</p>
            <a href="" class="qiye-home">企业主页</a>
        </div>
    </div>
</div>

