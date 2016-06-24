
$('a.thumbnail').on('click', function() {
    var $this = $(this);
    var uploader = new PicUploader({
        success: function(obj) {
            $this.find('img').attr('src', obj['data']);
            $this.next('input').val(obj['data']);
        }
    });
    uploader.start();
});

function video_ding(id) {
    var obj = $("#video_ding_"+id);
    $.post("index.php?r=video/ding&id=" + id, function(e) {
        obj.addClass("selected");
        obj.html(e.data);
        obj.on('click', function(evt) {
            evt.preventDefault();
        });
    });
}

function video_cai(id) {
    var obj = $("#video_cai_"+id);
    $.post("index.php?r=video/cai", {id: id}, function(e) {
        obj.addClass("selected");
        obj.html(e.data);
        obj.on('click', function(evt) {
            evt.preventDefault();
        });
    });
}
