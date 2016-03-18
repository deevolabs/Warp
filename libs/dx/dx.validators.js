/* 
=========================================================================
dx.validators
Author:dex
=========================================================================
*/



// validate email
// -------------------------------------------------------------------------------------------

function isEmail(str) { 
    var re =/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
    return re.test(str);
} 

$.validator.methods.email = function( value, element ) {
    var r = false;
    if(isEmail(value)) r=true;
    return r;
}


// validate CEP
// -------------------------------------------------------------------------------------------


function isCEP(str)
{
    var objER = /^[0-9]{5}-[0-9]{3}$/;
    return(objER.test(str));
}


$.validator.addMethod("cep", function(value, element) {
    var r = false;
    if(isCEP(value)) r=true;
    return r;
}, "CEP inválido");




// validate Name
// -------------------------------------------------------------------------------------------

function isName(str){
    if(str.length<5 ){
        return false;
    }else{
        return true;
    }
}
$.validator.addMethod("nome_completo", function(value, element) {
    var test = false;
    var objER = /[a-z]* [a-z]*/;
    test = objER.test(value)
    return test;
}, "nome inválido");




// Validate telefone
// -------------------------------------------------------------------------------------------

function isDDD(str){
    if(!getUFFromDDD(str)) return false;
    else return true;
}


function isTelefone(str){
    var objER1 = /^\([1-9]{2}\) [0-9]{5}-[0-9]{4}$/;
    var objER2 = /^\([1-9]{2}\) [0-9]{4}-[0-9]{4}$/;
    var test1 = objER1.test(str); 
    var test2 = objER2.test(str);
    if(test1 || test2){
        return true;
    } else return false;
}

$.validator.addMethod("telefone", function(value, element) {
    var r = false;
    if(isTelefone(value)) r=true;
    return r;
}, "telefone inválido");



// get UF from DDD
function getUFFromDDD(_ddd){
    _ddd = parseInt(_ddd);
    if(isNaN(_ddd)) return false;
    if(_ddd>10 && _ddd<20) return "SP";
    if(_ddd==21 || _ddd==22 || _ddd==24) return "RJ";
    if(_ddd==27 || _ddd==28) return "ES";
    if(_ddd>30 && _ddd<40) return "MG";
    if(_ddd>=41 && _ddd<=46) return "PR";
    if(_ddd>=47 && _ddd<=49) return "SC";
    if(_ddd>=51 && _ddd<=55) return "RS";
    if(_ddd==61) return "DF";
    if(_ddd==62 || _ddd==64) return "GO";
    if(_ddd==63) return "TO";
    if(_ddd==65 || _ddd==66) return "MT";
    if(_ddd==67) return "MS";
    if(_ddd==68) return "AC";
    if(_ddd==69) return "RO";
    if(_ddd>=71 && _ddd<=77) return "BA";
    if(_ddd==79) return "SE";
    if(_ddd==81 || _ddd==87) return "PE";
    if(_ddd==82) return "AL";
    if(_ddd==83) return "PB";
    if(_ddd==84) return "RN";
    if(_ddd==85 || _ddd==88) return "CE";
    if(_ddd==86 || _ddd==89) return "PI";
    if(_ddd==98 || _ddd==99) return "MA";
    if(_ddd==91 || _ddd==93 || _ddd==94) return "PA";
    if(_ddd==96) return "AP";
    if(_ddd==92 || _ddd==97) return "AM";
    if(_ddd==95) return "RR";
    return false;
}






// validate data
// -------------------------------------------------------------------------------------------



jQuery.validator.addMethod("dxDate", function(value, element) {
    var r = false;

    // First check for the pattern
    if(!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(value))
        return false;

    // Parse the date parts to integers
    var parts = value.split("-");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 2014 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    r = day > 0 && day <= monthLength[month - 1];



    return r;
}, "Data inválida");








// validate CPF/CNPJ
// -------------------------------------------------------------------------------------------

function unformatNumber(pNum)
{
    var n = String(pNum).replace(/\D/g, "").replace(/^0+/, "");
    var o = "00"+n;
    var l = o.slice(-11);
    return l;
}



function isCpf(number) {

var cpf = unformatNumber(number);
var soma;
var resto;
var i;
 
if ( (cpf.length != 11) ||
    (cpf == "00000000000") || (cpf == "11111111111") ||
    (cpf == "22222222222") || (cpf == "33333333333") ||
    (cpf == "44444444444") || (cpf == "55555555555") ||
    (cpf == "66666666666") || (cpf == "77777777777") ||
    (cpf == "88888888888") || (cpf == "99999999999") ) {
    return false;
}
 
 soma = 0;
 
 for (i = 1; i <= 9; i++) {
    soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
 }
 
 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
 
 if ( (resto == 10) || (resto == 11) ) {
 resto = 0;
 }
 
 if ( resto != Math.floor(cpf.charAt(9)) ) {
 return false;
 }
 
 soma = 0;
 
 for (i = 1; i<=10; i++) {
 soma += cpf.charAt(i-1) * (12 - i);
 }
 
 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
 
 if ( (resto == 10) || (resto == 11) ) {
 resto = 0;
 }
 
 if (resto != Math.floor(cpf.charAt(10)) ) {
 return false;
 }
 
 return true;
}
 
function isCnpj(s){
var i;
var c = s.substr(0,12);
var dv = s.substr(12,2);
var d1 = 0;
 
 for (i = 0; i < 12; i++){
 d1 += c.charAt(11-i)*(2+(i % 8));
 }
 
 if (d1 == 0) return false;
 
 d1 = 11 - (d1 % 11);
 
 if (d1 > 9) d1 = 0;
 if (dv.charAt(0) != d1){
 return false;
 }
 
 d1 *= 2;
 
 for (i = 0; i < 12; i++){
 d1 += c.charAt(11-i)*(2+((i+1) % 8));
 }
 
 d1 = 11 - (d1 % 11);
 
 if (d1 > 9) d1 = 0;
 if (dv.charAt(1) != d1){
 return false;
 }
 
 return true;
}
 
function isCpfCnpj(valor) {
 var retorno = false;
 var numero  = valor;
 
 numero = unformatNumber(numero);
 if (numero.length > 11){
 if (isCnpj(numero)) {
 retorno = true;
 }
 } else {
 if (isCpf(numero)) {
 retorno = true;
 }
 }
 
 return retorno;
}


$.validator.addMethod("cpf", function(value, element) {
    var r = false;
    if(isCpf(value)) r=true;
    return r;
}, "CPF inválido");

