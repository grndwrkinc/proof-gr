jQuery(document).ready(function($){

    var img_attr = $('#case_icon_img').attr( "src" );

    if(img_attr == ''){
        $('#case_icon_img').css('display', 'none');
    } 
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('#case-icon-button').click(function(e){
 
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment id to our custom image input field.
            $('#case_icon').val(media_attachment.id);
            $('#case_icon_img').attr( "src", media_attachment.url);
            $('#case_icon_img').css('display', 'block');
            
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
});