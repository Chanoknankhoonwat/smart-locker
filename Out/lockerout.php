<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <link rel="stylesheet" href="../main.css">
    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
    session_start();
    if(empty($_SESSION['admin'])){
        header("Location:../login.php");
    }
    $admin = $_SESSION['admin'];
      include '../database.php';
      $selection = "";
      $build = "";
      $status = '';
      if (isset($_POST['search'])){
          $selection = $_POST['search'];
          $build = $_POST["build"];
      }
      if (isset($_POST['status'])){
        $status = $_POST['status'];
      }
      $query = "SELECT * FROM AuditData1 WHERE MONTH(enddate) = MONTH(GETDATE()) AND YEAR(enddate) = YEAR(GETDATE()) AND staudit = 'ok' AND selection = '0.5'";
      $result = sqlsrv_query($conn, $query);
      $count=0;
      if ($result === false) {
          echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
      } else {
          $rowCount = sqlsrv_has_rows($result);
          if (!$rowCount) {
              $count+=1;
          } else {}
      }
      $query = "SELECT * FROM AuditData1 WHERE
      (DATEDIFF(QUARTER, enddate, GETDATE()) >= 1 OR enddate IS NOT NULL)AND staudit = 'ok' AND selection = '1'";
      $result2 = sqlsrv_query($conn, $query);
      if ($result2 === false) {
        echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
      } else {
          $rowCount = sqlsrv_has_rows($result2);
          if (!$rowCount) {
              $count+=1;
          } else {}
      }

    ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Smart Locker</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>จัดการพนักงาน</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Emp/showEmployee.php">พนักงานทั้งหมด</a>
                        <a class="collapse-item" href="../Emp/admin_locker_new_employee.php">จัดการพนักงาน</a>
                        <a class="collapse-item" href="../Emp/adminAddhome.php">เพิ่มพนักงาน</a>
                    </div>
                </div>
            </li>
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ข้อมูลล็อคเกอร์</span>
                </a>
                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item active" href="../Out/lockerout.php">ที่เก็บรองเท้าภายนอก</a>
                        <a class="collapse-item" href="../Buddy/lockerbuddy.php">ที่เก็บรองเท้าบัดดี้</a>
                        <a class="collapse-item" href="../Shirt/lockershirt.php">ล็อคเกอร์เก็บของ</a>
                        <a class="collapse-item" href="../Log/showlog.php">ประวัติการทำงาน</a>
                        <a class="collapse-item" href="../Log/showbreaklog.php">ประวัติการแจ้งเสีย</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                    aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>การตรวจสอบ</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=1">เต็ม</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Allreport"
                    aria-expanded="true" aria-controls="Allreport">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>การทำรายงานผล</span>
                </a>
                <div id="Allreport" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../AllReport/MainReport.php">ตามแผนกพนักงาน</a>
                        <a class="collapse-item" href="../AllReport/date_select.php">รายงานการตรวจสอบ</a>
                        <a class="collapse-item" href="../AllReport/locker_filter.php">ตามล็อคเกอร์</a>
                    </div>
                </div>
            </li>

            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                if($count==0){
                                    echo'<span class="badge badge-danger badge-counter"></span>';
                                }else{
                                    echo'<span class="badge badge-danger badge-counter">'.$count.'</span>';
                                }
                                ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <?php
                                $query = "SELECT * FROM AuditData1 WHERE MONTH(enddate) = MONTH(GETDATE()) AND YEAR(enddate) = YEAR(GETDATE()) AND staudit = 'ok' AND selection = '0.5'";
                                $result = sqlsrv_query($conn, $query);
                                if ($result === false) {
                                    echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
                                } else {
                                    $rowCount = sqlsrv_has_rows($result);
                                    if (!$rowCount) {
                                        ?>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 12, 2019</div>
                                                ไม่มีข้อมูลแบบครึ่งในเดือนนี้ กรุณาเพิ่มข้อมูล!
                                            </div>
                                        </a>
                                        <?php
                                    } else {}
                                }
                                $query = "SELECT * FROM AuditData1 WHERE
                                (DATEDIFF(QUARTER, enddate, GETDATE()) >= 1 OR enddate IS NOT NULL)AND staudit = 'ok' AND selection = '1'";
                                $result2 = sqlsrv_query($conn, $query);
                                if ($result2 === false) {
                                    echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
                                } else {
                                    $rowCount = sqlsrv_has_rows($result2);
                                    if (!$rowCount) {
                                        ?>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 12, 2019</div>
                                                ไม่มีข้อมูลใน3เดือนนี้แบบเต็ม กรุณาเพิ่มข้อมูล!
                                            </div>
                                        </a>
                                        <?php
                                    } else {}
                                }
                                ?>
                                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin; ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../signature_php/sign_master.php">
                                    <i class="fas fa-signature fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Signature
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                <?php
                
                if( $conn ) {
                  $sql = "SELECT out_number,
                  STUFF((SELECT ', ' + namethai+' ' + surnamethai FROM employee_locker_out WHERE TypeLocker = 'out'AND out_number = t.out_number FOR XML PATH('')), 1, 2, '') AS names, 
                  UsStatus,
                  status_out
                  ,building_name
                  FROM (SELECT DISTINCT out_number, UsStatus, status_out,building_name FROM employee_locker_out) AS t";
                    $stmt = sqlsrv_query($conn, $sql);
                
                  
                  if ($stmt !== false) {
                      // echo '<div class="m-3">ที่เก็บรองภายนอก</div>';
                      $headerPrinted = false;
                ?>
                <!-- Page Heading -->
                    <!-- <div class="row">                  
                        <div class="col"><h1 class="h3 mb-2 text-gray-800">ที่เก็บรองภายนอก</h1></div>
                        <div class="col-2">
                        <a href="exportlockerout.php">
                            <button class="w-100 btn btn-outline-primary rounded-5" type = "button" 
                            onclick="javascript:ExcelReport();">นำตารางไปปริ้น</button>
                        </a>
                        </div>
                    </div> -->
    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">                  
                                <div class="col"><h2 class="m-0 text-primary">ล็อคเกอร์รองภายนอก</h2></div>
                                <div class="col-auto">
                                    <a href="#" data-toggle="modal" data-target="#AddLockerModal"
                                    class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">เพิ่มตู้ล็อคเกอร์</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>รหัสตู้</th>
                                            <th>จำนวนที่ว่าง</th>
                                            <th>สถานะ</th>
                                            <th>เจ้าของ</th>
                                            <th>อาคาร</th>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
                                            $name = '';
                                            if($row['UsStatus']==='ชำรุด'){
                                                echo "<tr class='bg-warning text-white'>";
                                            }else{
                                                echo "<tr>";
                                            }
                                            echo "<td class=' border-end border-start p-2'>" . $row['out_number'] . "</td>";
                                            echo "<td class=' border-end border-start p-2'>" . $row['status_out'] . "</td>";
                                            echo "<td class=' border-end border-start p-2'>" . $row['UsStatus'] . "</td>";
                                            echo "<td class=' border-end border-start p-2'>" . $row['names'] . "</td>";                                     
                          
                                            echo "<td class=' border-end border-start p-2'>" . $row['building_name'] ."</td>
                                            <td class=' border-end border-start p-2'>";
                                            if($row['UsStatus']==='ว่าง'||$row['UsStatus']==='เต็ม'){
                                              echo"<center>
                                              <a href='showoutlocker.php?employee_out=".$row['out_number']."&status=".$row['status_out']."' class='btn btn-success btn-icon-split'>
                                              <span class='icon text-white-50'>
                                                  </i><i class='fas fa-pen'></i>
                                              </span>
                                              <span class='text'>แก้ไข</span>
                                                </a>
                                            </center>";
                                            } else{
                                              echo"<center>
                                              <button type='button' disabled='disabled' class='btn btn-secondary btn-icon-split' id='Edit'>
                                              <span class='icon text-white-50'>
                                                  </i><i class='fas fa-pen'></i>
                                              </span>
                                              <span class='text'>แก้ไข</span>
                                              </button>
                                              </center>";
                                            }
                                            echo"</td><td class=' border-end border-start p-2'>";
                                            if ($row['UsStatus']==='ชำรุด'){
                                              echo'
                                              <center>
                                                <a href="../report/reportrepair.php?type=out&lockernumber='.$row['out_number'].'"class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-wrench"></i>
                                                </span>
                                                <span class="text">ซ่อมเรียบร้อย</span>
                                                </a>
                                            </center>
                                              ';
                                            }else{ 
                                              if(!$row['names']){
                                                echo'
                                                <center>
                                                  <button type="button" onclick="showPopup_5(\''.$row['out_number'].'\')" class="btn btn-danger btn-icon-split">
                                                  <span class="icon text-white-50">
                                                    <i class="fas fa-hammer"></i>
                                                  </span>
                                                  <span class="text">แจ้งเสีย</span>
                                                  </button>
                                              </center>
                                                ';
                                                }
                                                else{
                                                  echo'
                                                  <center>
                                                  <button type="button" disabled="disabled" class="btn btn-secondary btn-icon-split">
                                                  <span class="icon text-white-50">
                                                      <i class="fas fa-hammer"></i>
                                                  </span>
                                                  <span class="text">แจ้งเสีย</span>
                                                  </button>
                                                </center>
                                                ';
                                                }
                                            }
                          
                                            echo "</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                      echo "ไม่สามารถดึงข้อมูลได้: " . print_r(sqlsrv_errors(), true);
                  }
        
                  // ปิดการเชื่อมต่อ
                  sqlsrv_close($conn);
              } else {
                  echo "การเชื่อมต่อไม่สำเร็จ";
              }
              
              ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเสีย</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="../report/reportrebreak.php" method="post">
                    <div class="modal-body">
                    <?php
                        echo ('
                            <input type="hidden" name="type" id="type" class="w-100" value="out">
                            <input type="hidden" name="lockernumber" id="lockernumber">
                            <input class="form-control form-control-sm" type="text" name="detail" id="detail" class="w-100" placeholder="ระบุสาเหตุ">
                        ');
                    ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">ยืนยัน</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Repair Modal-->
    <div class="modal fade" id="RepairModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ซ่อมเรียบร้อยแล้ว</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> -->
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- AddLocker Modal-->
    <div class="modal fade" id="AddLockerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มตู้ล็อคเกอร์</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="add_locker.php" method="post">
                    <div class="modal-body">
                        <label class="form-check-label" for=""> ระบุอาคาร </label>
                        <select class="form-control form-control-sm" id="build" name="build" class="form-control form-control-sm">
                            <option value="1" selected>A</option>
                            <option value="2">B</option>
                        </select>
                        <label class="form-check-label" for=""> ระบุจำนวนที่สามารถบรรจุในตู้ได้ </label>
                        <input class="form-control form-control-sm mb-2" type="number" name="space" id="space" value="0">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">ยืนยัน</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
      <?php
        if (isset($_GET['message4'])) {
            ?>
            $("#RepairModal").modal('show');
            <?php
        }
      ?>
      console.log();
      function showPopup(type) {
        // ตรวจสอบ type แล้วแสดง Popup ตามที่ต้องการ
        if (type === '4') {
            showPopup_4();
        }
      }
      
      function showPopup_5(texts) {
          // Display the popup
          document.getElementById('lockernumber').value = texts;
            $("#ReportModal").modal('show');
      }
    </script>

</body>

</html>

