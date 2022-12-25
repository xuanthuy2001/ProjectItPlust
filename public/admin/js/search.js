$(function(){
    $('.js-delete-brand').click(function()
    {
        // can biet xoa  thong qua id
        // lay gia tri id tuong ung khi click vao button
        let self = $(this);
        let id = self.attr('id');
        if($.isNumeric(id)){
            $.ajax({
                type: "POST",
                url: "index.php?c=nha_cung_cap&m=delete",
                data: {
                    idNcc: id,
                },
                beforeSend: function(){
                    // truoc khi gui du lieu di xu ly
                    // thong bao hieu ung loading - cho xu ly
                    self.text('Loading...');
                },
                success: function(result){
                    // nhan ket qua tu ben phia backend server tra ve thong qua bien result ma minh da khai bao
                    result = $.trim(result); // xoa khoang trang 2 dau
                    if(result === 'FAIL'){
                        alert('Co loi xay ra vui long thu lai');
                    } else if(result === 'SUCCESS') {
                        // thanh cong
                        alert('Xoa thanh cong');
                        // an dong vua click xoa
                    }
                    return false;
                }
            });
        }else {
            alert('Co loi xay ra vui long thu lai');
        }
    });


    $('#js-search').click(function(){
        //var url = "http://localhost/ItPlustProject/admin/index.php?c=nha_cung_cap";
        var url = window.location.href;
        var idx = url.indexOf("?");
        var idx2 = url.indexOf("&");
        var c = idx != -1 ? url.substring(idx+3, idx2) : "";
        // lay tu khoa nguoi dung tim kiem
        let keyword = $('#js-nameBranch').val().trim();
       
        if(keyword.length > 0){
            window.location.href = "index.php?c="+c+"&s="+keyword;
        }
    });
});