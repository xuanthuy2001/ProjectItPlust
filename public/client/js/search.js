$(function(){
    $('#js-search').click(function(){
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