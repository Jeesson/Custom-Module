(function ($, Drupal) {
  Drupal.behaviors.resume = {
    attach: function (context, settings) {

      // Add your Javascript code here.
      const myForm = document.getElementById('resume-form');
      myForm.addEventListener('submit', handleSubmit);
      // let submitTimer;

      function handleSubmit(event) {
        console.log('submitTimer');
        // document.getElementById('#edit-submit').prop('disabled', true)
        // event.preventDefault();
        // submitTimer = setTimeout(() => {
          // this.submit();
          // console.log('Submitted after 5 seconds');
        // }, 5000)
      }

    }
  };
})(jQuery, Drupal);
