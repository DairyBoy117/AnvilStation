jQuery().ready(function($) {

    $(document).ready(function(){

        var fileUpload,
            metaBox = $('#meta-box-tabs'),
            addFile = metaBox.find('#add-file'),
            fileIdInput = metaBox.find( '#file-uploader' );
          
        addFile.on( 'click', function( event ){
            
            event.preventDefault();
                
            if ( fileUpload ) {
                fileUpload.open();
                return;
            }

            fileUpload = wp.media({
                title: 'Select or Upload Image',
                button: {
                    text: 'Use this photo'
                },
                multiple: true
            });

            fileUpload.on( 'select', function() {
                  
                var fileAttachment = fileUpload.state().get('selection').first().toJSON();

                fileIdInput.val( fileAttachment.url );

            });

            fileUpload.open();
        });

    });

});