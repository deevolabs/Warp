(function($){

preloader = function(_minimumTime){
    if(!_minimumTime) _minimumTime = 10;
    var loaded = false;
    var min_time_elapsed = false;
    var eventStack = [];
    var queue = [];
    var q = 0;
    var qfinished = false;
    var debug = true;

    var JSONObj = {};

    function log(msg){
        $.log(msg);
    }

    this.data = function(_label){return JSONObj[_label];}


    this.addEventListener = function(_e,_callback){
        eventStack.push({e:_e,callback:_callback})
    }


    this.start = function() {

        log('dx>starting preloader')
        processQueue();

        //minimo de tempo pra executar a animação
        setTimeout(function(){
            min_time_elapsed = true;
            finished();
        },_minimumTime);
    }

    this.addJSON = function (_label,_path,_vars,_type){
        queue.push({data:{label:_label,path:_path,vars:_vars,type:_type},type:'json',status:'waiting'});
    }

    this.addImage = function(_path){
        //TODO: check if already exists
        queue.push({data:{path:_path},type:'image',status:'waiting'});
    }



    this.addFont = function(_families,_from,_typekitID){

        hasFonts = true;
        if($.type(_families)==='string') _families = [_families];
        if(_from!='typekit' && _from!='google'){
            if($.type(_from)==='string') _from = [_from];
        }

        queue.push({data:{families:_families,from:_from,typekitID:_typekitID},type:'font',status:'waiting'});

    }

    function processQueue(){

        if(queue.length<1) {
            qfinished = true;
            finished();
            return;
        }

        for (var i = 0; i < queue.length; i++) {
            if(queue[i].status=='waiting'){

                switch(queue[i].type){
                    case 'image':
                        loadImage(queue[i].data,i);
                        break;
                    case 'font':
                        loadFont(queue[i].data,i);
                        break;
                    case 'json':
                        loadJSON(queue[i].data,i);
                        break;
                }
                return;
            }
        };

        //finished
        qfinished = true;
        finished();
    }


    function loadImage(_data,_id){

        _path = _data.path;
        var img = new Image();

        function imageloaded(){
            log('dx>image ' + _path + ' loaded!');
            queue[_id].status='loaded';
            processQueue();
        };

        function imageloadError(){
            log('dx>image ' + _path + ' NOT loaded - ERROR');
            queue[_id].status='error';
            processQueue();
        };

        img.addEventListener('load',imageloaded)
        img.addEventListener('error',imageloadError)
        img.src = _path + '?flush=' + Math.random();
    }




    function loadFont(_data,_id){

        var _from = _data.from;
        var _families = _data.families;
        var _typekitID = _data.typekitID;


        switch(_from){
            case 'google':
                WebFont.load({
                    google: {
                       families: _families
                    },
                    loading: function() {
                        log('dx>loading ' + _families + ' from google fonts');
                    },
                    active: function() {
                        log('dx>fonts ' + _families + ' from google fonts loaded!');
                        queue[_id].status='loaded';
                        processQueue();
                    },
                    inactive: function() {
                        log('dx>error downloading fonts')
                        queue[_id].status='error';
                        processQueue();
                    }
                });
                break;
            case 'typekit':
                WebFont.load({
                    typekit: {
                        id: _typekitID
                    },
                    loading: function() {
                        log('dx>loading fonts from typekit...');
                    },
                    active: function() {
                        log('dx>typekit fonts loaded!');
                        queue[_id].status='loaded';
                        processQueue();
                    },
                    inactive: function() {
                        log('dx>error downloading fonts from typekit')
                        queue[_id].status='error';
                        processQueue();
                    }
                });
                break;
            default:
                WebFont.load({
                    custom: {
                        families: _families,
                        urls: _from
                    },
                    loading: function() {
                        log('dx>loading ' + _families + ' from ' + _from);
                    },
                    active: function() {
                        log('dx>fonts ' + _families + ' from ' + _from + ' loaded!');
                        queue[_id].status='loaded';
                        processQueue();
                    },
                    inactive: function() {
                        log('dx>error downloading fonts')
                        queue[_id].status='error';
                        processQueue();
                    }
                });
                break;
        }

    }


    function loadJSON(_data,_id){
        log('dx>loading JSON file "' + _data.path + '"');
        $.ajax({
            url: _data.path,
            dataType: "json",
            type: _data.type,
            data: _data.vars,
            cache: false,
            success:function(parsedData) {
                log('dx>JSON file "' + _data.path + '" loaded!');
                log(parsedData);
                JSONObj[_data.label] = parsedData;
                queue[_id].status='loaded';
                processQueue();
            },
            error:function(){
                log('dx>error downloading JSON file "' + _data.path + '"')
                queue[_id].status='error';
                processQueue();
            }

        })

    }


    function triggerEvent(e){
        for(i=0;i<eventStack.length;i++){
            if(eventStack[i].e==e){
                eventStack[i].callback();
            }
        }
    }




    function finished(){
        if(!min_time_elapsed) return;
        if(!qfinished) return;
        if(loaded) return;
        loaded = true;
        log('dx>preload complete!');
        triggerEvent('complete');

    }

    return this;

}

})(jQuery);