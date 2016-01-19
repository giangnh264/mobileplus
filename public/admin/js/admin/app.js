!function (window, $, App) {
    //App.Angular = new AngularBooter('clipvn');

    // App.ModalLink = [App.Url.api + '/popup'];

    //App.Angular.controllers.ClipVn = ['$scope', '$http', function ($scope, $http) {
    //    for (i = 0; i < App.ModalLink.length; i++) {
    //        $http.get(App.ModalLink[i]).success(function (data) {
    //            $scope.modals = data;
    //        });
    //    }
    //}];
    //
    //App.Angular.boot();

    App.PopupModalShow = function (title, content, callback) {
        var element = $('#popup_blank');

        element.modal().on('shown.bs.modal', function () {
            element.find('.modal-title').text(title);
            element.find('.modal-body').html(content);
        }).on('hidden.bs.modal', function () {
            element.find('.modal-body').html(element.find('.modal-loading').html());
        }).on('click', '.modal-submit', callback);
    };

    App.PopupModalClose = function () {
        $('#popup_blank').modal('hide');
    };
    App.onFileSelectedThumb = function (event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (event) {
            $('#avatar-thumb-change').attr('src', event.target.result);
        };

        reader.readAsDataURL(selectedFile);
    };
    App.onFileSelected = function (event) {
        alert('1');
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (event) {
            $('#thumb-change').attr('src', event.target.result);
        };

        reader.readAsDataURL(selectedFile);
    };


    // DOM ready
    $(function () {
        $('.modal-angular').addClass('modal');

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('body').on('click', ".check_all", function () {
            var checked = $('.check_all').is(':checked');
            $(this).closest('table').find('.check_item').each(function () {
                if ($(this).is(':checked') != checked)
                    $(this).click();
            });
        });

        $('._delete_item').click(function () {
            var __this = $(this);

            if (confirm('Bạn muốn thực hiện hành động này?')) {
                App.ajax({
                    url: __this.attr('href'),
                    type: 'DELETE',
                    success: function () {
                        App.refresh();
                    }
                });
            }

            return false;
        });
    }); // End DOM ready
}(window, window.jQuery, window.App); // put semicolon to prevent error when minify script