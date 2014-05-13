/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    $('form.ajax').on('submit',function(){
        var that=$(this),
        url=that.attr('action'),
        type=that.attr('method'),
        data={}; //aqui metere valores como nombre, ciudad y categoria, mas abajo
        that.find('[name]').each(function(index,value){
           var that=$(this),
           name=that.attr('name'),
           value=that.val();
           data[name]=value;
        });
        
        var res = url.split("/");
        //alert(res[3]);
        if(res[3]=="cercar_hotels"){
            $.ajax({
                url:url, 
                type:type,
                data:data,
                success: function(output){ //output és la sortida de la funció cercar_hotels del HotelController
                   console.log(output);
                   console.log(output.redirect);
                  $("#con_hotels").html(output);
                 }
            });            
        }else if(res[3]=="cercar_vols"){
            $.ajax({
                url:url, 
                type:type,
                data:data,
                success: function(output){ //output és la sortida de la funció cercar_hotels del HotelController
                   console.log(output);
                   console.log(output.redirect);
                  $("#con_vols").html(output);
                 }
            });            
        }else if(res[3]=="cercar_plans"){
            $.ajax({
                url:url, 
                type:type,
                data:data,
                success: function(output){ //output és la sortida de la funció cercar_hotels del HotelController
                   console.log(output);
                   console.log(output.redirect);
                  $("#con_plans").html(output);
                 }
            });
        }             

return false;
});



});




