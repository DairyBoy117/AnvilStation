<script>

jQuery().ready(function($) {

    $(document).ready(function(){

        var frameFloor,
            metaBox = $('#meta-box-tabs'),
            addImgLinkFloor = metaBox.find('#add-floor'),
            imgIdInputFloor = metaBox.find( '#floor-plan' );
          
        addImgLinkFloor.on( 'click', function( event ){
            
            event.preventDefault();
                
            if ( frameFloor ) {
                frameFloor.open();
                return;
            }

            frameFloor = wp.media({
                title: 'Select or Upload Image',
                button: {
                    text: 'Use this photo'
                },
                multiple: false
            });

            frameFloor.on( 'select', function() {
                  
                var attachmentFloor = frameFloor.state().get('selection').first().toJSON();

                imgIdInputFloor.val( attachmentFloor.url );

            });

            frameFloor.open();
        });

    });

});

</script>