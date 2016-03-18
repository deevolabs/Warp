(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: PT (Portuguese; português)
 * Region: BR (Brazil)
 */
$.extend($.validator.messages, {
	required: "Obrigatório",
	remote: "corrija este campo.",
	email: "digite um endere&ccedil;o de email v&aacute;lido.",
	url: "digite uma URL v&aacute;lida.",
	date: "data inválida",
	dateISO: "digite uma data v&aacute;lida (ISO).",
	number: "digite um n&uacute;mero v&aacute;lido.",
	digits: "digite somente d&iacute;gitos.",
	creditcard: "digite um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "digite o mesmo valor novamente.",
	extension: "digite um valor com uma extens&atilde;o v&aacute;lida.",
	maxlength: $.validator.format("máximo de {0} caracteres."),
	minlength: $.validator.format("mínimo {0} caracteres."),
	rangelength: $.validator.format("digite um valor entre {0} e {1} caracteres de comprimento."),
	range: $.validator.format("digite um valor entre {0} e {1}."),
	max: $.validator.format("digite um valor menor ou igual a {0}."),
	min: $.validator.format("digite um valor maior ou igual a {0}."),
	nifES: "digite um NIF v&aacute;lido.",
	nieES: "digite um NIE v&aacute;lido.",
	cifEE: "digite um CIF v&aacute;lido.",
	postalcodeBR: "digite um CEP v&aacute;lido.",
	cpfBR: "digite um CPF v&aacute;lido."
});

}));