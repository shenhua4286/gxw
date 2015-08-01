/**
 * Created by Oven on 2015/4/20.
 */
$(function(){






    $("input").each(function(){
        var value=$(this).val();
        var parentObj=$(this).parent();
         $(parentObj).html("<span>"+value+"</span>");

    });


    $("select").each(function(){

        var value=$(this).find("option:selected").text();
        var parentObj=$(this).parent();
        $(parentObj).html("<span>"+value+"</span>");

    });


    $("textarea").each(function(){

        var value=$(this).text();
        var parentObj=$(this).parent();
        $(parentObj).html("<span>"+value+"</span>");

    });








});