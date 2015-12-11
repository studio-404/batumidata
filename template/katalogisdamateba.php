<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">TEST</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">

                          <div class="form-group">
                            <label>სახელი გვარი: <font color="red">*</font></label> <!-- Fisrname & lastname -->
                            <input class="form-control" type="text" placeholder="" id="namelname" value="გიორგი გვაზავა">
                            <p class="help-block namelname-required" style="display:none"><font color="red">სახელი გვარის ველი სავალდებულოა !</font></p>
                          </div>
                          
                    </div>
                </div>
          </div>
      </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>