<script type="text/javascript">
	$('.subscribe-newsletter').on('submit', function(e){

		

			e.preventDefault()

			let fd = new FormData(this)

			  $.ajax({

			        type       : 'POST',
			        url        : '<?= base_url('subscribe-newsletter') ?>',
			        dataType   : 'JSON',
			        data       : fd,
			        contentType: false,
			        processData: false,
			        success    : function(result) {

			        	console.log(result);
			        	return false;

			         	
			        },error: function(jqXHR, exception) {
			            console.log(jqXHR.responseText);
			            console.log('bye');
			        }
			    })

	})

    // manage language
    $(document).mouseup(function(e)
    {
        $('.ds-onclick-e').click(function (e) {
            $('.ds-lang-d').toggle()
        })
        var container = $(".ds-lang-d");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.css('display','none');
        }
    });


</script>
