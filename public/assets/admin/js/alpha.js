$(document).ready(function($) {
      $.extend( true, $.fn.dataTable.defaults, {
            buttons: ["colvis"],
            preDrawCallback: function( settings ) {
                  showLoading();
            },
            drawCallback: function( settings ) {
                  swal.close();
            },
		initComplete: function(settings, json) {
			settings.oInstance.api().buttons().container().appendTo(`#${settings.sTableId}_wrapper .col-md-6:eq(0)`)
		}
      });

      $('.select2').select2();

      // Summernote
      $('#summernote').summernote({
            height: 200,
            fontNames: ['SF Pro Display', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Time New Roman', 'Verdana', 'Source Sans Pro', '-apple-system'],
            fontNamesIgnoreCheck: ['SF Pro Display'],
            callbacks: {
                  onImageUpload: function(files) {
                        let data;
                        for(let i=0; i < files.length; i++) {
                              data = fileUpload(files[i]);
                              if (data) {
                                    var image = $('<img>').attr('src', data.url);
                                    $(this).summernote("insertNode", image[0]);
                              } else {
                                    swal.fire("Upload Server Error", '', 'error');
                              }
                        }
                  }
            }
      });

      $('#summernote:disabled').summernote('disable');

      $('.daterangepicker-input:not([readonly])').daterangepicker();
      
})
