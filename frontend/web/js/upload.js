
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

$('.upload_img').on('click', function() {
    var $this = $(this);
    var uploader = new PicUploader({
        success: function(obj) {
            $this.prev('div').find('img').attr('src', obj['data']).css({width:'350px',height:'210px'}).show();
            $this.next('input').val(obj['data']);
        }
    });
    uploader.start();
});

