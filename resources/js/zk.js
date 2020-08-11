var ZkClass = function(){};
ZkClass.prototype = {};
var zk = new ZkClass();

ZkClass.prototype.open_dialog = function (modalid, modalurl, modal_size='modal-xl',modal_bg='bg-light', title=null) {
	$("#"+modalid).remove(); 
	$("body").append('<div class="modal fade" id="'+modalid+'"><div class="modal-dialog '+modal_size+'"><form id="form'+modalid+'" action="" method="POST" enctype="multipart/form-data"><div class="modal-content '+modal_bg+'"> <div class="modal-header"><h4 class="modal-title">'+title+'</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div><div class="modal-footer justify-content-between"><button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button><button type="submit" class="btn">Сохранить</button></div></div></form></div></div>');  
	$("#"+modalid).modal('show'); 
	$.ajax({type:'GET', url:modalurl, dataType: "json", contentType: "application/json; charset=utf-8", data:'_token='+$('meta[name="csrf-token"]').attr('content'), success:function(data) {
		if(typeof data.title!=='undefined'){$("#"+modalid+" h4").html(data.title);}
		if(typeof data.html!=='undefined'){$("#"+modalid+" .modal-body").html(data.html);}
		if(typeof data.form!=='undefined'){$.each(data.form,function(attr, val){$("#form"+modalid).attr(attr,val);});}
		if(typeof data.button.text!=='undefined'){$("#form"+modalid+" button[type=submit]").html(data.button.text);}
		if(typeof data.button.class!=='undefined'){$("#form"+modalid+" button[type=submit]").addClass(data.button.class);}
		$(document).ready(function (){bsCustomFileInput.init();});
    }, error:function(xhr, textStatus, errorThrown){console.log(xhr, textStatus, errorThrown);}});
};

ZkClass.prototype.onLoad = function (elementHtml, UrlLoad) {
	$.ajax({type:'GET', url:UrlLoad, dataType: "json", contentType: "application/json; charset=utf-8", data:'_token='+$('meta[name="csrf-token"]').attr('content'), success:function(data) {
		if(typeof data.form!=='undefined'){$.each(data.form,function(attr, val){$("#"+elementHtml).attr(attr,val);});}
		if(typeof data.html!=='undefined'){$("#"+elementHtml).html(data.html);}
		$("#"+elementHtml).append('<center><button type="submit" class="btn" id="btn'+elementHtml+'" >Сохранить</button></center>');
		if(typeof data.button.text!=='undefined'){$("#btn"+elementHtml).html(data.button.text);}
		if(typeof data.button.class!=='undefined'){$("#btn"+elementHtml).addClass(data.button.class);}
		$(document).ready(function (){bsCustomFileInput.init();});
    }, error:function(xhr, textStatus, errorThrown){console.log(xhr, textStatus, errorThrown);}});
};

$(document).on("click", ".zk-confirm", function() {
	var uniqueSelector = generateUUID();
	$("#"+uniqueSelector).remove(); 
    var link = $(this).attr("href");
    var text = $(this).attr("data-confirm-text");
	if(text.length==0){text="Подтвердите свое действие...";}
	$("body").append('<div class="modal fade" id="'+uniqueSelector+'"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Подтвердите действие</h4><button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+text+'</div><div class="modal-footer justify-content-between"><button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button><a href="'+link+'" class="btn btn-success">Подтверждаю</button></div></div></div></div>'); 
	$("#"+uniqueSelector).modal('show'); 
	return false;
});

function generateUUID(){
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
};

$(document).ready(function(){ 
	$('[data-zkonload]').each(function(){
		zk.onLoad($(this).attr("id"),$(this).attr("data-zkonload"));
	});
	if(window.location.hash&&$(window.location.hash).length!=='undefined'){ 
		$("html,body").scrollTop($(window.location.hash).offset().top); 
	}
});
 