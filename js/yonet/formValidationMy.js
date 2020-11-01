$(document).ready(function() {
	/**sayfa input kontrol*/
    $('#pageFrm')
        .formValidation({
        	locale: 'tr_TR',
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            	url: {
                    validators: {
                    	  notEmpty: { message: 'Başlık boş bırakılamaz.' },
                          regexp: {
                          	regexp: /^[a-z0-9-_]+$/,
                              message: 'Başlık sadece karakter içerebilir'
                          },
                          stringLength: {
                              min: 3,
                              max: 70,
                              message: 'Sayfa url minimum 3 maksimum 70 karakterli olabilir.'
                          },
                         remote: {
                             url: baseUrl + 'ajax/url_check',
                             data: { url:
                                  function() {
                                   	return $( "#url" ).val();
                                  },
                                  id:
                                  function() {
                                    return $('input[name=id]').val();
                                  },
                                  lng:
                                      function() {
                                        return $('input[name=lng]').val();
                                      }                                  
                               },
                             message: 'Bu url daha önce kullanılmış. Url benzersiz olmalı.',
                             type: 'POST'
                         }
                     }
                 },
                name: {
                    validators: {
                        notEmpty: { message: 'Sayfa başlığı boş bırakılamaz' },
                      
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'Sayfa başlığı min 3  maksimum 70 karakterli olabilir.'
                        }      
                    }
                },
                header: {
                    validators: {
                        notEmpty: { message: 'Başlık boş bırakılamaz.' },
                        stringLength: {
                            min: 3,
                            max: 180,
                            message: 'Başlık minimum 3 maksimum 180 karakterli olabilir.'
                        }
                    }
                }
				
               
            }
        })
        .on('success.validator.fv', function(e, data) {
            // data.field     --> The field name
            // data.element   --> The field element
            // data.result    --> The result returned by the validator
            // data.validator --> The validator name

            if (data.field === 'url' && data.validator === 'remote'
                && (data.result.available === false || data.result.available === 'false'))
            {
            	
                // The userName field passes the remote validator
                data.element                    // Get the field element
                    .closest('.form-group')     // Get the field parent

                    // Add has-warning class
                    .removeClass('has-success')
                    .addClass('has-warning')

                    // Show message
                    .find('small[data-fv-validator="remote"][data-fv-for="url"]')
                        .show();
            }
        })
        // This event will be triggered when the field doesn't pass given validator
        .on('err.validator.fv', function(e, data) {
            // We need to remove has-warning class
            // when the field doesn't pass any validator
            if (data.field === 'url') {
                data.element
                    .closest('.form-group')
                    .removeClass('has-warning');
            }
        })
        .on('success.form.fv', function(e) {
            // Prevent submit form
            e.preventDefault();

            var $form     = $(e.target),
                validator = $form.data('formValidation');
            	//$form.find('.alert').html('' + validator.getFieldElements('urladres').val()).show();
           
            document.getElementById("pageFrm").submit();
        });
    
    
    
     
    
    /*sifre degis kayıt kontrol sonu*/
});