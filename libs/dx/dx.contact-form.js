(function($){


$.fn.contactForm = function(){

	var divContato = $(this);
	var sysmessage = divContato.find('.alert');
	var btSubmit = divContato.find('input[type="submit"]');
	var formContact = divContato.find('form');
		
	// formContact.find('input[type=text],input[type=email],textarea').on('change invalid', function() {
	//     var textfield = $(this).get(0);

	//     // 'setCustomValidity not only sets the message, but also marks
	//     // the field as invalid. In order to see whether the field really is
	//     // invalid, we have to remove the message first
	//     textfield.setCustomValidity('');

	//     if (!textfield.validity.valid) {
	//       textfield.setCustomValidity('Preencha o campo corretamente!');
	//     }
	// });
	
	
$("form").on('submit', (function (e) {
    e.preventDefault();
    divContato.addClass('busy');
    $.ajax({
    	// URL para o qual o pedido é enviado
        url: $("form").attr("action"),
		
		// Tipo de pedido a ser enviado, chamado como método
        type: "POST",
        
        // Dados enviados para o servidor, um conjunto de pares de chave / valor (ou seja, campos e valores de formulário)
        data: new FormData(this),
        
        // O tipo de conteúdo utilizado durante o envio de dados para o servidor.
        contentType: false,
        
        // Para requisitam páginas que não podem ser armazenadas em cache
        cache: false,
        
        // Para enviar DOMDocument ou dados não processados ficheiro é definida como falsasky
        processData: false,
        
        success: function (data) {
        	
            if (data.indexOf('error') >= 0) sysmessage.addClass('error');

            else if (data.indexOf('success') >= 0) sysmessage.addClass('success');
            sysmessage.html(data);
            divContato.removeClass('busy');
        }
    });
}));
};


$(document).on("ready", function(){
	$('#contact-form').each(function(){
		$(this).contactForm();
	});
});

})(jQuery);

// ========================================================================================//
// 																						   //
// 						Recaptha                                                           //
//	 																					   //
// 																						   //				
// ========================================================================================//           														

(function($){	
	(function () {		
	    if (!window['___grecaptcha_cfg']) {
	        window['___grecaptcha_cfg'] = {};
	        // console.log(___grecaptcha_cfg + '___grecaptcha_cfg');
	    };
	    if (!window['___grecaptcha_cfg']['render']) {
	        window['___grecaptcha_cfg']['render'] = 'onload';
	    };
	    window['__google_recaptcha_client'] = true;
	    var po = document.createElement('script');
	    // console.log(po + 'po');
	    po.type = 'text/javascript';
	    po.async = true;
	    po.src = 'https://www.gstatic.com/recaptcha/api2/r20150708165616/recaptcha__pt_br.js';
	    var s = document.getElementsByTagName('script')[0];	    
	    s.parentNode.insertBefore(po, s);
	    console.log(s + ' s');
	})();
})(jQuery);




