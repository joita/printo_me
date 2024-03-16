						<?php // main-content ends ?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<script src="<?php echo site_url('assets/js/foundation.min.js'); ?>"></script>
		<script>
			$(document).foundation();
		</script>

		<script src="<?php echo site_url('assets/js/vendor/jquery.qtip.min.js'); ?>"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.0/isotope.pkgd.min.js"></script>


		<script src="<?php echo site_url('assets/js/spectrum/spectrum.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/spectrum/i18n/jquery.spectrum-es.js'); ?>"></script>

		<script src="<?php echo base_url('assets/js/dg-function.js?v='.time()); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo site_url('bower_components/jquery.tagsinput/src/jquery.tagsinput.js'); ?>"></script>
		<?php if(isset($scripts)) {
			$this->load->view($scripts);
		} ?>

		<!--[if lt IE 9]>
		<script src="<?php echo site_url('js/vendor/rem.min.js'); ?>"></script>
		<![endif]-->
	</body>
</html>
