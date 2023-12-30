
$(document).ready(function(){
    $('.iframe-btn').fancybox({
    'width'   : 880,
    'height'  : 570,
    'type'    : 'iframe',
    'autoScale'   : false
    });

    $("[data-fancybox]").fancybox({
        iframe : {
            css : {
                width : '880px',
                height: '550px',
                autoScale: true
            }
        }
    });
});

function responsive_filemanager_callback(field_id) {
    //console.log(field_id);
    var url = jQuery('#' + field_id).val()
    var imgURL = url.replace(/https?:\/\/[^\/]+/i, '')
    //alert(imgURL);
    //alert('update '+field_id+" with "+url);
    //var src = $("image."+field_id).attr('src');
    $('img#view-img').attr('src', url)
    let input = "<input name='images[]' type='hidden' value='"+imgURL+"'/>"
    let image = "<img class='images-thumb' src='"+imgURL+"' width=80 height=80 />"
    $('.images-input').append(input)
    $('.product-images').append(image)
    //alert(src);
    $('input#' + field_id).val(imgURL)
  }