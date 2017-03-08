<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HanViet Tool</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">HanViet Tool v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Trang chủ</a>
                        </li>
                        <li>
                            <a href="translate.php"><i class="fa fa-exchange fa-fw"></i> Phiên âm</a>
                        </li>
                        <li>
                            <a href="insert.php"><i class="fa fa-edit fa-fw"></i> Thêm chữ mới</a>
                        </li>
                        <li>
                            <a href="update.php"><i class="fa fa-refresh fa-fw"></i> Cập nhật chữ</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Phiên âm</h1>
                    <form id="translate">
                    <div class="row">
                    	<div class="col-sm-6">
                			<label><h4>Nguyên văn</h4></label>
                			<textarea class="form-control" id="source" rows="15" cols="10"></textarea>
                    	</div>
                    	<div class="col-sm-6">
                    		<label><h4>Kết quả</h4></label>
                			<textarea class="form-control" id="target" rows="15" cols="10"></textarea>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                    		<button type="submit" class="btn btn-primary">Dịch</button>
                    	</div>
                    </div>
                	</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.min.js"></script>

    <script>
    	$(document).ready(function() {
            // Set two textarea synchronized scroll
            $("#target").scroll(function() {
                $("#source").scrollTop($("#target").scrollTop());
            });

            // Ajax translate
    		$("#translate").submit(function(e) {
    			var url = "translator.php";
    			var source = $("#source").val();

                // Break line after 15 words
    			source = source.replace(/[\n\r]+/g, "").replace(/(.{15})/g, "$1\n");

    			$.ajax({
    				type: "POST",
    				url: url,
    				data: "source=" + source,
    				success: function(res) {
    					$("#source").val(source);
    					$("#target").val(res);
    				}
    			});

    			e.preventDefault();
    		});
    	});
    </script>

</body>

</html>