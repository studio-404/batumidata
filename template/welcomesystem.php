<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				მთავარი
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> მთავარი</a></li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<ul class="timeline">
					    <!-- timeline time label -->
					    <li class="time-label">
					        <span class="bg-red">
					            10 Feb. 2014 13:35:22
					        </span>
					    </li>
					    <!-- /.timeline-label -->

					    <!-- timeline item -->
					    <li>
					        <!-- timeline icon -->
					        <i class="fa fa-bell-o bg-blue"></i>
					        <div class="timeline-item">
					            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

					            <h3 class="timeline-header"><a href="#">Support Team</a> ...</h3>

					            <div class="timeline-body">
					                Content goes here
					            </div>

					            <div class="timeline-footer">
					                <a class="btn btn-primary btn-xs">Button</a>
					            </div>
					            
					        </div>
					    </li>
					    <!-- END timeline item -->

					</ul>
					                  
				</div>
			</div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>