



// -------------------------------------------------------------------------------------------

// Facebook SDK Load

// -------------------------------------------------------------------------------------------



window.fbAsyncInit = function() {

    FB.init({

      appId      : '1436137780027491',

      xfbml      : true,

      version    : 'v2.3'

    });

 };



(function(d, s, id){

 var js, fjs = d.getElementsByTagName(s)[0];

 if (d.getElementById(id)) {return;}

 js = d.createElement(s); js.id = id;

 js.src = "//connect.facebook.net/en_US/sdk.js";

 fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));









// -------------------------------------------------------------------------------------------

// Share Facebook

// -------------------------------------------------------------------------------------------



(function($) {



    $(document).ready(function() {



        $('.button-share.facebook').tap(function (){

           

            var url = $(this).attr('data-url');               

            

            FB.ui({

                method: 'share',

                href: url                

            });



            return false; 

        });

    });



})(jQuery);









// -------------------------------------------------------------------------------------------

// Share Google Plus

// -------------------------------------------------------------------------------------------

(function($) {

    $(document).ready(function() {



        $('.button-share.googleplus').tap(

                function (){

                var current_url = window.location.href;

                var share_url = 'https://plus.google.com/share?url='+current_url;

                window.open(share_url,'Compartilhamento Google Plus','toolbar=no, location=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=500, height=750');

           }

        );



    });

})(jQuery);





// -------------------------------------------------------------------------------------------

// Buton Share Mail

// -------------------------------------------------------------------------------------------

(function($) {    

    $(document).ready(function() {

        if ($('.share-tab').length == 0) return;



        $('.button-share.mail').tap(
            function (){
                // aqui aplica a maquina de estado                                         
                var shareTab = $(this).parents(".share-tab");
                shareTab.addClass('mail');
                $(this).hide();
                // Limpa o timeout da ocultação da mensagem
                if(timeClearShareTab) clearTimeout(timeClearShareTab);
           }
        );

        var timeClearShareTab = 0;

        function sendEmail(){

            var var_email_amigo = $('.share-tab .email-friend-share-mail').val();
            if(!var_email_amigo.match(/@/)){
                return $('.share-tab .email-friend-share-mail').focus();
            }
            var var_titulo = $('.share-tab .titulo-share-mail').val();
            var var_link_post =  window.location.href;

            // Para o carregamento se estiver carregando
            if($('.share-tab .btn-enviar-share').hasClass("load")) return false;
            $('.share-tab .btn-enviar-share').addClass("load");

            $.ajax({                
                type: "POST",
                data: {email_amigo: var_email_amigo, titulo_post: var_titulo, link_post: var_link_post},                
                url: "/send_mail/index.php",
                dataType: "html",
                success: function(data){
                    // show messages
                    if (data == '1') {
                        $(".share-tab .result-message .success").show();
                        $('.share-tab .email-friend-share-mail').val('');
                        timeClearShareTab = setTimeout(dismiss, 5000);
                    } else {
                        $(".share-tab .result-message .error").show();
                    }
                },
                complete: function(msg){
                    $('.share-tab .btn-enviar-share').removeClass("load");
                }

            });

        }

        function dismiss(){
            if($('.share-tab').length < 1) return;
            if($('.share-tab .email-friend-share-mail').val() != '') return;
            $('.share-tab .button-share.mail').show();
            $(".share-tab").removeClass('mail');
            $(".share-tab .result-message div").hide();
        }

        $(window).scroll(function(){
            dismiss();
        });

        $('.share-tab .result-message div').tap(function(){
            dismiss();
        })

        $('.share-tab .btn-enviar-share').tap(function (){
            sendEmail();
        });

        $('.share-tab .email-friend-share-mail').keydown(function(e){
            if(e.keyCode == 13) sendEmail();
        });

        $('body').tap(function(e){
            if($(e.target).closest(".share-tab").length == 0 && !$(e.target).hasClass("share-tab")){
                dismiss();
            }
        });

    });

})(jQuery);

// -------------------------------------------------------------------------------------------

// Share Twitter

// -------------------------------------------------------------------------------------------

(function($) {

    $(document).ready(function() {
 
        $('.button-share.twitter').tap(            

            function(e){         

            e.preventDefault();



            var loc = $(this).attr('href');              

            //encodeURIComponent Varre o lixo

            var title  = encodeURIComponent($(this).attr('title'));

            //var title  = escape($(this).attr('title'));

            var var_url =  window.location.href;              

            window.open('http://twitter.com/share?url=' + loc + '&text=' + title + '&', 'twitterwindow', 'height=450, width=550, top='+($(window).height()/2 - 225) +', left='+$(window).width()/2 +', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');

        });

    });

})(jQuery);

// -------------------------------------------------------------------------------------------

// Share Linkdin

// -------------------------------------------------------------------------------------------

(function($) {

     $(document).ready(function() {

        $('.linkdin').click(

        function(e){         

        // console.log('testeShareLinkdin')   

        e.preventDefault();



         // console.log(document.URL);

         window.open("http://www.linkedin.com/shareArticle?url=" + document.URL, height="450", width="550");



        });          

     });

 })(jQuery);









