(function($) {

$(document).ready(function() {
    if($('.dx_widgetCurso').length==0) return;


    var el = $('.dx_widgetCurso');

	el.find("input[name='periodo']").change(function(){
		setOptions();
	})

    function setOptions(){
    	
    	el.find(".mensalidade").hide();
    	el.find(".group_periodo .field").removeClass("active");
    	var radio = el.find("input[name='periodo']:checked");
    	radio.parent().addClass("active");

    	var id_curso = radio.val()
    	var periodo = radio.attr("data-periodo");
    	el.find(".mensalidade.mensalidade-"+periodo).css("display","inline-block");
		el.find(".button.inscrever").attr("href", "http://vestibular.vemprafam.prod.novatela.com.br?id_curso="+id_curso);	

    }

	setOptions();



});


})(jQuery);