  		/**
         * Created by Oven on 2015/4/20.
         */
        $(function(){
        	$(".pad-10").each(function(){
        		var html="";
        		$(this).find("div").find("input").each(function(i,n){
            		if(i%2==0){
            			html+="<a href='"+$(n).val()+"' title='点击查看大图'>"
            			html+="<img src='"+$(n).val()+"' style='margin-right:5px;width:50px;height:50px;'/>"
            			html+="</a>"
            		}
            	});
        		$(this).parent().html(html);
        	})
        	
        	
            $(".colselect span").each(function(){
                var value=$(this).text();
                var parentObj=$(this).parent().parent().parent();
                $(parentObj).html("<span>"+value+"</span>");
            });

            /**
             * 修改模板，替换成span
             * */
            $("input:text").each(function(){
                var value=$(this).val();
                var parentObj=$(this).parent();
                if(value.indexOf('http') ==0 && value.indexOf('jpg') ==value.length-3){
                	$(parentObj).html("<a href="+value+"> <img src="+value+" style='width:50px;height:50px'/></a>");
                }else{
                	$(parentObj).html("<span>"+value+"</span>");
                }
                
            });
            
            $("input:submit").each(function(){
            	if($(this).data('submit') != 'submit'){
            		$(this).parent().parent().remove();
            	}
            });
            
            $("input:button").each(function(){
            	$(this).parent().parent().remove();
            });
            
            $("select").each(function(){
               /*var option=$(this).find("option:selected");
               var value=$(option).text();
               var parentObj=$(this).parent();
               $(parentObj).html("<span>"+value+"</span>");*/
            	//$(this).parent().parent().remove();
            });
            
            $("select").each(function(){
            	$(this).attr("disabled",'');
            });
            
            $("input:checked").each(function(){
            	var value=$(this).parent().text();
            	var parentObj=$(this).parent().parent();
            	$(parentObj).html("<span>"+value+"</span>");
            });
            
            $("input:radio").each(function(){
            	$(this).parent().parent().remove();
            });
            $("textarea").each(function(){
                var value=$(this).text();
                var parentObj=$(this).parent();
                $(parentObj).html("<span>"+value+"</span>");
            });
            
            setTimeout("selectFormart()",1000);
        });
        
        function selectFormart(){
        	 $("select").parent().each(function(){
        		 	var value=$(this).find(":selected").text();
        		 	value=value.replace("请选择菜单",'');
        		 	$(this).html("<span>"+value+"</span>");
             });
        }