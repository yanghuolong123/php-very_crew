/*
 * 操作确认 modal
 */
var actionConfirm = function(settings) {
    var modalId = 'fcjz-confirm-modal';
    var modalTplHtml = '<div id="' + modalId + '" class="modal modal-default fade "> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">提示</h4> </div> <div class="modal-body"> <p>One fine body…</p> </div> <div class="modal-footer"> <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button> <button type="button" class="btn btn-warning confirm-btn" data-dismiss="modal">确定</button> </div> </div></div></div>';
    var modalEle = null;
    if ($('#' + modalId).length == 0) {
        $('body').append($(modalTplHtml));
        modalEle = $('#' + modalId);
        modalEle.modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
    } else {
        modalEle = $('#' + modalId);
    }
    $('.modal-body', modalEle).html(settings.msg);
    $('.confirm-btn', modalEle).off('click').on('click', function() {
        settings['confirm']();
        modalEle.modal('hide');
    });
    modalEle.modal('show');
}

/*
 * 操作成功提示 modal
 */
var greeting = function(settings) {
    var modalId = 'fcjz-greeting-modal';
    var modalTplHtml = '<div id="' + modalId + '" class="modal modal-default fade "> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h4 class="modal-title">操作成功</h4> </div> <div class="modal-body"> <p>One fine body…</p> </div> <div class="modal-footer">  <button type="button" class="btn btn-success confirm-btn" data-dismiss="modal">知道了</button> </div> </div></div></div>';
    var modalEle = null;
    if ($('#' + modalId).length == 0) {
        $('body').append($(modalTplHtml));
        modalEle = $('#' + modalId);
        modalEle.modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
    } else {
        modalEle = $('#' + modalId);
    }
    $('.modal-body', modalEle).html(settings.msg);
    $('.modal-title', modalEle).html(settings['title'] ? settings['title'] : '操作成功');
    if (settings['confirm']) {
        $('.confirm-btn', modalEle).off('click').on('click', function() {
            settings['confirm']();
            modalEle.modal('hide');
        });
    }
    modalEle.modal('show');
}

/*
 * 操作警告
 */
var alerting = function(settings) {
    var modalId = 'fcjz-alerting-modal';
    var modalTplHtml = '<div id="' + modalId + '" class="modal modal-default fade "> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header  alert-warning"> <h4 class="modal-title">警告</h4> </div> <div class="modal-body"> <p>One fine body…</p> </div> <div class="modal-footer">  <button type="button" class="btn btn-warning confirm-btn" data-dismiss="modal">知道了</button> </div> </div></div></div>';
    var modalEle = null;
    if ($('#' + modalId).length == 0) {
        $('body').append($(modalTplHtml));
        modalEle = $('#' + modalId);
        modalEle.modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
    } else {
        modalEle = $('#' + modalId);
    }
    $('.modal-body', modalEle).html(settings.msg);
    $('.modal-title', modalEle).html(settings['title'] ? settings['title'] : '警告');
    if (settings['confirm']) {
        $('.confirm-btn', modalEle).off('click').on('click', function() {
            settings['confirm']();
            modalEle.modal('hide');
        });
    }
    modalEle.modal('show');
}


/*
 * 图片 upload 
 */
/*
 * settting字段
 * before: 上传前调用的函数
 * sucess: 上传成功后调用的函数
 */
function PicUploader(settings) {
    var inputId = 'picupload-' + Math.random().toString().slice(2);
    var self = this;
    this.settings = settings;
    //this.$fileInput = $('<input type="file" accept=".jpg,.png,.jpeg,.gif" id="' + inputId + '" style="display:none;">');
    this.$fileInput = $('<input type="file" accept="image/*" id="' + inputId + '" style="display:none;">');
    this.$fileInput.on('change', function() {
        self._onChange(self);
    });
    $('body').append(this.$fileInput);
}

PicUploader.prototype = {
    consotructor: PicUploader,
    $fileInput: null,
    settings: {},
    /*
     * 开始上传操作
     */
    start: function() {
        this.$fileInput.click();
    },
    _onChange: function(self) {
        var picFormData = new FormData();
        picFormData.append('file', this.$fileInput.get(0).files[0]);
        /*
         * 上传前
         */
        self.settings['before'] && self.settings['before']();

        $.ajax({
            url: '/upload/upload-file',
            type: 'post',
            data: picFormData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(obj) {
                if (obj.success) {
                    /*
                     * 上传成功
                     */
                    self.settings['success'] && self.settings['success'](obj);
                } else {
                }
            }
        });
    }
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
