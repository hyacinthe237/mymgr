<script type="text/javascript" src="/backend/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="/backend/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('.iframe-btn').fancybox({
        'width'     : 900,
        'maxHeight' : 600,
        'minHeight'    : 400,
        'type'      : 'iframe',
        'autoSize'      : false
    });

    var photo = $("input[name='image']");
    if (photo && photo.val()) {
        $('#photo_view').html("<img class='thumbnail img-responsive mb-10' src='" + photo.val() +"'/>");
    }

    $("body").hover(function() {
        if (photo) {
            $('#photo_view').html("<img class='thumbnail img-responsive mb-10' src='" + photo.val() +"'/>");
        }
    })

    tinymce.init({
        selector: ".tiny",
        theme: "modern",
        relative_urls: false,
        height : 220,
        fontsize_formats: "8px 10px 12px 14px 16px 18px 24px 32px 36px 60px",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor filemanager code"
       ],
       toolbar1: "undo redo | fontsizeselect bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
       toolbar2: "|filemanager | link unlink anchor | image media | forecolor backcolor  | print preview code | styleselect",
       image_advtab: true ,

        external_filemanager_path:"/backend/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "/backend/filemanager/plugin.min.js"}
    })

    $(".clickable-row").click(function() {
        console.log('cliked on row');
        window.location = $(this).data("href")
    })
})

toggleSidebar = function () {
    $('#wrapper').toggleClass('toggled')
}
</script>
