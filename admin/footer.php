        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="gentella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="gentella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="gentella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="gentella/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="gentella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="gentella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="gentella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="gentella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="gentella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="gentella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="gentella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="gentella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="gentella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="gentella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="gentella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<!--
    <script src="gentella/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
-->
    <script src="gentella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="gentella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="gentella/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- bootstrap-progressbar -->
    <script src="gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="gentella/vendors/moment/min/moment.min.js"></script>
    <script src="gentella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="gentella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="gentella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="gentella/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="gentella/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="gentella/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="gentella/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="gentella/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="gentella/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="gentella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="gentella/vendors/starrr/dist/starrr.js"></script>
    
	<!-- Cropper -->
    <script src="gentella/vendors/cropper/dist/cropper.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="gentella/build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
		  if ($("#datatable-buttons").length > 0) {
			$("#datatable-buttons").DataTable({
			  dom: "Bfrtip",
			  buttons: [
				{
				  extend: "copy",
				  className: "btn-sm"
				},
				{
				  extend: "csv",
				  className: "btn-sm"
				},
				{
				  extend: "excel",
				  className: "btn-sm"
				},
				{
				  extend: "pdfHtml5",
				  className: "btn-sm"
				},
				{
				  extend: "print",
				  className: "btn-sm"
				},
			  ],
			  responsive: true
			});
		  }
		  
	  //add form
		$(".select2_multiple").select2({
			placeholder: "Domeny"
		});
	});
    </script>
    
 <!-- Cropper -->
    <script>
      $(document).ready(function() {
        var $image = $('#image');
        //~ var $download = $('#download');
        var options = {
              aspectRatio: 1,
              preview: '.img-preview'
            };


        // Tooltip
        //~ $('[data-toggle="tooltip"]').tooltip();


        // Cropper
        $image.on().cropper(options);


        // Buttons
        //~ if (!$.isFunction(document.createElement('canvas').getContext)) {
          //~ $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        //~ }

        //~ if (typeof document.createElement('cropper').style.transition === 'undefined') {
          //~ $('button[data-method="rotate"]').prop('disabled', true);
          //~ $('button[data-method="scale"]').prop('disabled', true);
        //~ }


        //~ // Download
        //~ if (typeof $download[0].download === 'undefined') {
          //~ $download.addClass('disabled');
        //~ }


        //~ // Options
        //~ $('.docs-toggles').on('change', 'input', function () {
          //~ var $this = $(this);
          //~ var name = $this.attr('name');
          //~ var type = $this.prop('type');
          //~ var cropBoxData;
          //~ var canvasData;

          //~ if (!$image.data('cropper')) {
            //~ return;
          //~ }

          //~ if (type === 'checkbox') {
            //~ options[name] = $this.prop('checked');
            //~ cropBoxData = $image.cropper('getCropBoxData');
            //~ canvasData = $image.cropper('getCanvasData');

            //~ options.built = function () {
              //~ $image.cropper('setCropBoxData', cropBoxData);
              //~ $image.cropper('setCanvasData', canvasData);
            //~ };
          //~ } else if (type === 'radio') {
            //~ options[name] = $this.val();
          //~ }

          //~ $image.cropper('destroy').cropper(options);
        //~ });


        //~ // Methods
        //~ $('.docs-buttons').on('click', '[data-method]', function () {
          //~ var $this = $(this);
          //~ var data = $this.data();
          //~ var $target;
          //~ var result;

          //~ if ($this.prop('disabled') || $this.hasClass('disabled')) {
            //~ return;
          //~ }

          //~ if ($image.data('cropper') && data.method) {
            //~ data = $.extend({}, data); // Clone a new one

            //~ if (typeof data.target !== 'undefined') {
              //~ $target = $(data.target);

              //~ if (typeof data.option === 'undefined') {
                //~ try {
                  //~ data.option = JSON.parse($target.val());
                //~ } catch (e) {
                  //~ console.log(e.message);
                //~ }
              //~ }
            //~ }

            //~ result = $image.cropper(data.method, data.option, data.secondOption);

            //~ switch (data.method) {
              //~ case 'scaleX':
              //~ case 'scaleY':
                //~ $(this).data('option', -data.option);
                //~ break;

              //~ case 'getCroppedCanvas':
                //~ if (result) {

                  //~ // Bootstrap's Modal
                  //~ $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                  //~ if (!$download.hasClass('disabled')) {
                    //~ $download.attr('href', result.toDataURL());
                  //~ }
                //~ }

                //~ break;
            //~ }

            //~ if ($.isPlainObject(result) && $target) {
              //~ try {
                //~ $target.val(JSON.stringify(result));
              //~ } catch (e) {
                //~ console.log(e.message);
              //~ }
            //~ }

          //~ }
        //~ });

        //~ // Keyboard
        //~ $(document.body).on('keydown', function (e) {
          //~ if (!$image.data('cropper') || this.scrollTop > 300) {
            //~ return;
          //~ }

          //~ switch (e.which) {
            //~ case 37:
              //~ e.preventDefault();
              //~ $image.cropper('move', -1, 0);
              //~ break;

            //~ case 38:
              //~ e.preventDefault();
              //~ $image.cropper('move', 0, -1);
              //~ break;

            //~ case 39:
              //~ e.preventDefault();
              //~ $image.cropper('move', 1, 0);
              //~ break;

            //~ case 40:
              //~ e.preventDefault();
              //~ $image.cropper('move', 0, 1);
              //~ break;
          //~ }
        //~ });

        // Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
          $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
              return;
            }

            if (files && files.length) {
              file = files[0];

              if (/^image\/\w+$/.test(file.type)) {
                blobURL = URL.createObjectURL(file);
                $image.one('built.cropper', function () {

                  // Revoke when load complete
                  URL.revokeObjectURL(blobURL);
                }).cropper('reset').cropper('replace', blobURL);
                $inputImage.val('');
              } else {
                window.alert('Please choose an image file.');
              }
            }
          });
        } else {
          $inputImage.prop('disabled', true).parent().addClass('disabled');
        }
      });
    </script>
    <!-- /Cropper -->
  </body>
</html>
