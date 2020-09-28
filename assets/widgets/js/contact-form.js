; (function ($) {
    $(document).ready(function () {

        let __ajaxURL = adp_contact.ajax_url || '';

        $('.adp-cform').on('submit',function (event){
            event.preventDefault();
            let $thatForm = $(this),
                $thatBtn = $thatForm.find('button[type="submit"]');

            $thatBtn.prop('disabled',true);

            $.ajax({
                url: __ajaxURL,
                method: 'POST',
                data: $thatForm.serialize(),
                success: function (resp){
                    $thatBtn.prop('disabled',false);

                    if(resp.success == 'OK'){
                        $thatForm.find('.adp_message').addClass('success').text(resp.message).show(0);
                        $thatForm[0].reset();
                    }else {
                        $thatForm.find('.adp_message').addClass('error').text(resp.message).show(0);
                    }

                },
                error: function (err){
                    $thatBtn.prop('disabled',false);
                    console.log(err);
                }
            });


            return false;
        });


    });
})(jQuery);