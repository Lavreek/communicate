const $ = require('jquery');

$('form[name=sending]').submit(function (event) {
   event.preventDefault();

   $.ajax({
       method: 'POST',
       url: '/api/message/send',
       data: $(this).serialize(),

       success: function (response) {
           $('#sending_message').val('');
       }
   })
});

