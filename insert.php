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
                    <h1 class="page-header">Quản lý chữ</h1>
                    <?php
                        if (isset($_POST['ok'])) {
                            if ($_POST['character'] == null) {
                                echo "<div class='alert alert-danger'>Vui lòng nhập chữ</div>";
                            } else {
                                $character = $_POST['character'];
                            }

                            if ($_POST['mean'] == null) {
                                echo "<div class='alert alert-danger'>Vui lòng nhập nghĩa</div>";
                            } else {
                                $mean = $_POST['mean'];
                            }
                            
                            if (isset($character) && isset($mean)) {
                                // Get collection
                                $conn = new MongoClient();
                                $db = $conn->hanviet;
                                $collection = $db->characters;

                                // Insert
                                $document = $collection->findOne(['character' => $character]);
					            if ($document) {
						    		echo "<div class='alert alert-danger'>Chữ này đã tồn tại</div>";
					            } else {      	
					              	$character = [
								    	'character'	=>	$character,
								    	'mean'		=>	$mean
								    ];
									$collection->insert($character);
									echo "<div class='alert alert-success'>Thêm thành công</div>";
					            }

                                $conn->close();
                            }
                        }
                    ?>
                    <form class="form-inline" action="insert.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="character" class="form-control" placeholder="Nhập chữ">
                        </div>
                        <div class="form-group">
                            <input type="text" name="mean" class="form-control" placeholder="Nghĩa">
                        </div>
                        <button type="submit" name="ok" class="btn btn-primary">Insert</button>
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

</body>

</html>

<meta charset="UTF-8">
<form method="POST" action="#">
  Chữ <input type="text" name="char" /><br />
  Đọc <input type="text" name="mean" /><br />
  <input type="submit" name="ok" value="Thêm">
</form>
<?php
	if (isset($_POST['ok'])) {
		try {
		    // a new MongoDB connection
		    $conn = new MongoClient("mongodb://localhost:27017");

		    // connect to dictionary database
		    $db = $conn->hanviet;

		    // a new products collection object
		    $collection = $db->characters;

		    // insert new document
			$document = $collection->findOne(array('character' => $_POST['char']));
            if ($document) {
	    		echo "Chữ này đã tồn tại !";
            } else {      	
              	$character = array(
			    	'character'	=>	$_POST['char'],
			    	'mean'		=>	$_POST['mean']
			    );
				$collection->insert($character);
				echo "Thêm thành công !";
            }
		    
		    // close the connection to MongoDB 
		    $conn->close();
		} catch (MongoConnectionException $e) {
		    // if there was an error, we catch and display the problem here
		    echo $e->getMessage();
		} catch (MongoException $e) {
		    echo $e->getMessage();
		}
	}
?>