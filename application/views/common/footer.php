<footer class="main-footer">
	<div class="pull-right d-none d-sm-inline-block">

	</div>
	&copy; 2023 <a href="<?php echo site_url(); ?>">Davinder Chahal</a>. All Rights Reserved.
</footer>


<!-- Vendor JS -->
<script src="<?php echo base_url('main/js/vendors.min.js'); ?>"></script>
<script src="<?php echo base_url('main/js/pages/chat-popup.js'); ?>"></script>
<script src="<?php echo base_url('assets/icons/feather-icons/feather.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor_components/select2/dist/js/select2.full.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor_components/apexcharts-bundle/irregular-data-series.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor_components/jquery-steps-master/build/jquery.steps.js'); ?>"></script>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="<?php echo base_url('assets/vendor_components/Web-Ticker-master/jquery.webticker.min.js'); ?>"></script>

<!-- Crypto Tokenizer Admin App -->
<script src="<?php echo base_url('main/js/template.js'); ?>"></script>
<script src="<?php echo base_url('main/js/pages/dashboard.js'); ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
	jQuery.fn.bstooltip = jQuery.fn.tooltip;

	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		onOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});
</script>
<?php $successMsg = $this->session->userdata('form-success');
$this->session->unset_userdata('form-success');
$failMsg = $this->session->userdata('form-fail');
$this->session->unset_userdata('form-fail');

if ($successMsg != '' || $failMsg != '') {
	$msg = ($successMsg) ? $successMsg : $failMsg;
	$msgClass = ($successMsg) ? 'success' : 'error'; ?>
	<script>
		$.toast({
			heading: '',
			text: '<?php echo $msg; ?>',
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: '<?php echo $msgClass; ?>',
			hideAfter: 3500,
		});
	</script>
<?php } ?>
<script>
	$(document).ready(function() {
		$('.select2').select2();
	});

	$(document).on('submit', '.common-form-submit', function(e) {
		e.preventDefault();
		var form = $(this);
		$.post(form.attr("action"), form.serialize(), function(data) {
			if (Math.floor(data) == data && $.isNumeric(data)) {
				var redirectUrl = "<?php echo current_url(); ?>";
				window.location.href = redirectUrl;
			} else {
				if (data.includes("redirect#~@")) {
					var newData = data.replace("redirect#~@", "");
					window.location.href = $.trim(newData);
				} else {
					Swal.fire({
						icon: 'error',
						title: '',
						html: data,
					});
				}
			}
		});
	});
</script>
</body>

</html>