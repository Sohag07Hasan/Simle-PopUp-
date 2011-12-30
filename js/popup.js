/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function is_email(email){
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(filter.test(email)){
        return true;
    }
    else{
        return false;
    }
}

function is_name(name){
    if(name.length > 2){
        return true;
    }
    else{
        return false;
    }
}

function is_phone(phone){
     if(phone.length >= 10){
        return true;
    }
    else{
        return false;
    }
}

jQuery(document).ready(function($) {    
        var this_obj = this;
        var id = '#popup-content';

        //Get the screen height and width
        var blanketHeight = $(document).height();
        var blanketWidth = $(window).width();

        //Set heigth and width to blanket to fill up the whole screen
        $('#blanket').css({'width':blanketWidth,'height':blanketHeight});

        //transition effect        
        $('#blanket').fadeIn(1000);    
        $('#blanket').fadeTo("slow",0.8);    

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        $(id).css('top',  winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);

        //transition effect
        $(id).show(1000);     

    //if close button is clicked
    $('.window .close').click(function (e) {
        //Cancel the link behavior
         $.ajax({				
            async: true,
            type: 'post',
            url: ajax_url,
            dataType: "html",
            cache: false,
            timeout: 100000,
            data:{
                'action' : 'popup_email_close'                
            },

            success:function(result){
                $('#blanket').fadeOut();
                $('.window').slideUp();                
            },

            error: function(jqXHR, textStatus, errorThrown){               
                $('#blanket').fadeOut();
                $('.window').slideUp();              
            }
       });
       
    });        

  
    //if the form is submitted
    $('#popup-info-submit').click(function(){
        
        var name = $('#popup-name').val();
        var email = $('#popup-email').val();
        var phone = $('#popup-phone').val();
       
     
     if(!is_name(name)){
           alert('Please check your name!');
           return false;
       }
       
        if(!is_email(email)){
           alert('Please check your email!');
           return false;
       }
       
        if(!is_phone(phone)){
           alert('Please check your phone!');
           return false;
       }
       
       //now ajax
       
       $.ajax({				
            async: true,
            type: 'post',
            url: ajax_url,
            dataType: "html",
            cache: false,
            timeout: 100000,
            data:{
                'action' : 'popup_email_send',
                'name' : name,
                'email' : email,
                'phone' : phone
            },

            success:function(result){
              
                alert('Thank you for your Email !');                 
               
                $('#blanket').fadeOut();
                $('.window').slideUp();
                
            },

            error: function(jqXHR, textStatus, errorThrown){
                alert('Email can\'t be sent ! Please check your email and try again');
                $('#blanket').fadeOut();
                $('.window').slideUp();              
            }
       });
      
       
    });

});

