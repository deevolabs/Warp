/**
 * ...
 * @author Dex
    on-screen debugger
 */

if (!debug) var debug = "console"; //"console",screen" ou "none"

(function($) {
    $.log = function(msg) {
        if (debug == "console") {
            console.log(msg);
        }
        if (debug == "screen") {
            if ($('#debugger').length == 0) {
                $('body').append('<div id="debugger"><div id="debugger_title">debug info</div><div id="debugger_content"></div></div>');
                $('#debugger').css({
                    "color": "white",
                    "position": "absolute",
                    "width": "100%",
                    "overflow": "auto",
                    "top": 0,
                    "left": 0,
                    "font-size": ".8em",
                    "pointer-events": "none"
                });
                $('#debugger #debugger_title').css({
                    "font-size": "1em",
                    "font-weight": "bold"
                });
                //$('#debugger #debugger_content').css({});
            }
            var debuggerObj = $('#debugger #debugger_content');
            var html = debuggerObj.html();
            html = html + '<div class="debugger_msg">' + msg + '</div>';
            debuggerObj.html(html);
            console.log(msg);
        }
        return this;
    };
})(jQuery);