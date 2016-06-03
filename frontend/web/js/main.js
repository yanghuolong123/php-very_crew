
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
    $.post("index.php?r=video/ding&id=" + id, function(e) {
        $("a.abtn-digg").addClass("selected");
        $("a.abtn-digg").html(e.data);
        $("a.abtn-digg").on('click', function(evt) {
            evt.preventDefault();
        });
    });
}

function video_cai(id) {
    $.post("index.php?r=video/cai", {id:id}, function(e) {
        $("a.abtn-bury").addClass("selected");
        $("a.abtn-bury").html(e.data);
        $("a.abtn-bury").on('click', function(evt) {
            evt.preventDefault();
        });
    });
}


