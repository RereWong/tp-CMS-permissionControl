<script src="__PUBLIC__/admin/jquery/jquery-2.1.4.min.js"></script>
<script src="__PUBLIC__/admin/jquery/jquery-migrate-1.3.0.min.js"></script>
<script src="__PUBLIC__/admin/jquery-ui/jquery-ui-1.11.4.min.js"></script>
<script src="__PUBLIC__/admin/bootstrap3/js/bootstrap.min.js"></script>
<script src="__PUBLIC__/admin/masonry/masonry.pkgd.js"></script>
<script src="__PUBLIC__/admin/js/debug.js"></script>

<script>
	function applyMasonry() {
		if ( $(document).width() > 767 ) {
			$('.masonry-container').masonry({
				itemSelector: '.masonry-item'
			});
		}
	}

	function fixContentHeight() {

		var windowHeight = $(window).height();
		var headerHeight = $('#nav-header-bar').css('height');
		var footerHeight = $('#copyright').css('height');

		headerHeight = headerHeight.substr(0, headerHeight.length-2);
		footerHeight = footerHeight.substr(0, footerHeight.length-2);

		var h = windowHeight - headerHeight - footerHeight;
		$('#content').css('min-height', h);

		/*if (XSHOWROOM_ADMIN_DEBUG_MODE) {
			console.log("windowHeight: " + windowHeight);
			console.log("headerHeight: " + headerHeight);
			console.log("footerHeight: " + footerHeight);
			console.log("h: " + h);
			console.log( "min-height: " + $('#content').css('min-height') );
		}*/
	}

	$(document).ready(function(e) {
		var LEFT_DRAWER_OPEN = false;
		var RIGHT_DRAWER_OPEN = false;

		fixContentHeight();
		applyMasonry();

		$(window).resize(function() {
			fixContentHeight()
			applyMasonry();
		});

		// $(".sortable").sortable();

		// Toggle left drawer
		$('.nav-drawer-btn-left').click( function() {
			console.log("RIGHT_DRAWER_OPEN: " + RIGHT_DRAWER_OPEN);
			console.log("LEFT_DRAWER_OPEN: " + LEFT_DRAWER_OPEN);
			if( RIGHT_DRAWER_OPEN ) {
				$('.nav-drawer-btn').each( function() {
					var target = $(this).attr('data-target');
					$(target).toggleClass('open');
				});
				RIGHT_DRAWER_OPEN = !RIGHT_DRAWER_OPEN;
			} else {
				var target = $(this).attr('data-target');
				$(target).toggleClass('open');
			}
			LEFT_DRAWER_OPEN = !LEFT_DRAWER_OPEN;
		});

		// Toggle right drawer
		$('.nav-drawer-btn-right').click( function() {
			if( LEFT_DRAWER_OPEN ) {
				$('.nav-drawer-btn').each( function() {
					var target = $(this).attr('data-target');
					$(target).toggleClass('open');
				});
				LEFT_DRAWER_OPEN = !LEFT_DRAWER_OPEN;
			} else {
				var target = $(this).attr('data-target');
				$(target).toggleClass('open');
			}
			RIGHT_DRAWER_OPEN = !RIGHT_DRAWER_OPEN;
		});

		// Close drawer on clicking blank space
		$('#content').click( function() {
			if( LEFT_DRAWER_OPEN || RIGHT_DRAWER_OPEN ) {
				$('.nav-drawer-btn').each( function() {
					var target = $(this).attr('data-target');
					if ($(target).hasClass('open')) {
						$(target).removeClass('open');
					}
				});
				LEFT_DRAWER_OPEN = false;
				RIGHT_DRAWER_OPEN = false;
			}
		});
	});

</script>