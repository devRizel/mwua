<?php
$page_title = 'Admin Home Page';
require_once('includes/load.php');

page_require_level(1);
$products = fetch_products_from_database(); 


if (!empty($products)) {
    $filtered_faculty = array_filter($products, function($product) {
        return $product['name'] === 'Faculty';
      });
      $count_faculty = count($filtered_faculty);

    $filtered_comlab4 = array_filter($products, function($product) {
      return $product['name'] === 'Com lab 4';
    });
    $count_it_comlab4 = count($filtered_comlab4);

    $filtered_comlab3 = array_filter($products, function($product) {
      return $product['name'] === 'Com lab 3';
    });
    $count_it_comlab3 = count($filtered_comlab3);

    $filtered_comlab2 = array_filter($products, function($product) {
       return $product['name'] === 'Com lab 2';
    });
    $count_it_comlab2 = count($filtered_comlab2);

    $filtered_comlab1 = array_filter($products, function($product) {
        return $product['name'] === 'Com lab 1';
    });
    $count_it_comlab1 = count($filtered_comlab1);

    $filtered_server_room = array_filter($products, function($product) {
        return $product['name'] === 'Server Room';
    });
    $count_server_room = count($filtered_server_room);
    
    
    $filtered_barrow1 = array_filter($products, function($product) {
      return $product['barrow'] === 'Return';
    });
    $count_it_barrow1 = count($filtered_barrow1);

    $filtered_maintenance1 = array_filter($products, function($product) {
      return $product['computer_images'] === 'Maintenance' ||
             $product['monitor_images'] === 'Maintenance' ||
             $product['keyboard_images'] === 'Maintenance' ||
             $product['mouse_images'] === 'Maintenance' ||
             $product['system_images'] === 'Maintenance' ||
             $product['vgahdmi_images'] === 'Maintenance' ||
             $product['power1_images'] === 'Maintenance' ||
             $product['power2_images'] === 'Maintenance' ||
             $product['chord1_images'] === 'Maintenance' ||
             $product['chord2_images'] === 'Maintenance' ||
             $product['mother_images'] === 'Maintenance' ||
             $product['cpu_images'] === 'Maintenance' ||
             $product['ram_images'] === 'Maintenance' ||
             $product['video_images'] === 'Maintenance' ||
             $product['hddssdgb_images'] === 'Maintenance';
  });
  
    $count_it_maintenance1 = count($filtered_maintenance1);




} else {
    $count_faculty = 0;
    $count_it_comlab4 = 0;
    $count_it_comlab3 = 0;
    $count_it_comlab2 = 0;
    $count_it_comlab1 = 0;
    $count_server_room = 0; 
    $count_it_maintenance1 = 0; 
    $count_it_barrow1 = 0; 
}

function fetch_products_from_database() {
    global $db;
    $query = "SELECT * FROM products";
    $result = $db->query($query);
    $products = [];
    while ($row = $db->fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

$other = fetch_other_from_database(); 

if (!empty($other)) {
  $filtered_maintenance2 = array_filter($other, function($item) {
      return $item['other_images'] === 'Maintenance';
  });
  $count_it_maintenance2 = count($filtered_maintenance2);

  $filtered_barrow2 = array_filter($other, function($item) {
      return $item['barrow'] === 'Return';
  });
  $count_it_barrow2 = count($filtered_barrow2);

} else {
  $count_it_barrow2 = 0; 
  $count_it_maintenance2 = 0;
}

function fetch_other_from_database() {
  global $db;
  $query = "SELECT * FROM other";
  $result = $db->query($query);
  $other = [];
  while ($row = $db->fetch_assoc($result)) {
      $other[] = $row;
  }
  return $other;
}

$c_categorie = count_by_id('categories');
$c_room = count_by_id('room');
$c_product = count_by_id('products');
$c_user = count_by_id('users');
$c_other = count_by_id('other');

$chartData = [
    'Faculty' => $count_faculty,
    'Server Room' => $count_server_room,
    'IT Comlab 1' => $count_it_comlab1,
    'IT Comlab 2' => $count_it_comlab2,
    'IT Comlab 3' => $count_it_comlab3,
    'IT Comlab 4' => $count_it_comlab4,
];

?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include_once('layouts/header.php'); ?>

<style>
.panel-box {
  height: 120px; 
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;
}

.panel-value {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.panel-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 50px; 
  border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;
}

.margin-top {
  margin-top: 0; 
}
</style>
<div class="row">
  <a href="users.php" style="color:black;" >
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_user['total']; ?> </h2>
          <p class="text-muted">Users</p>
        </div>
      </div>
    </div>
  </a>

  <a href="categorie.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);  " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_categorie['total']; ?> </h2>
          <p class="text-muted">Categories/Room</p>
        </div>
      </div>
    </div>
  </a>

  <a href="product7.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);  " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_other['total']; ?> </h2>
          <p class="text-muted">Peripheral Devices</p>
        </div>
      </div>
    </div>
  </a>

  <a href="product.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_product['total']; ?> </h2>
          <p class="text-muted">Computer Units</p>
        </div>
      </div>
    </div>
  </a>
  <a href="computer.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);  " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $count_it_maintenance1;['total']; ?> </h2>
          <p class="text-muted">Computer/s to be Repaired </p>
        </div>
      </div>
    </div>
  </a>
  <a href="otherdevices.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $count_it_maintenance2;['total']; ?> </h2>
          <p class="text-muted">Peripheral Devices to be Repaired </p>
        </div>
      </div>
    </div>
  </a>
  <a href="barrowedcomputer.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);  " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $count_it_barrow1;['total']; ?> </h2>
          <p class="text-muted">Borrowed Computer Units</p>
        </div>
      </div>
    </div>
  </a>
  <a href="barrowedother.php" style="color:black;">
    <div class="col-md-3">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); " class="panel panel-box clearfix riz">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $count_it_barrow2;['total']; ?> </h2>
          <p class="text-muted">Borrowed Peripheral Devices</p>
        </div>
      </div>
    </div>
  </a>
</div>
<div class="row">
  <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="col-md-12">
    <canvas id="dashboardChart" width="800" height="275"></canvas>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>

<script src="chart.js"></script>
<script>
  var ctx = document.getElementById('dashboardChart').getContext('2d');
  var dashboardChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Faculty', 'Server Room', 'IT Comlab 1', 'IT Comlab 2', 'IT Comlab 3', 'IT Comlab 4'],
          datasets: [{
    label: 'Count',
    data: [
        <?php echo $chartData['Faculty']; ?>,
        <?php echo $chartData['Server Room']; ?>,
        <?php echo $chartData['IT Comlab 1']; ?>,
        <?php echo $chartData['IT Comlab 2']; ?>,
        <?php echo $chartData['IT Comlab 3']; ?>,
        <?php echo $chartData['IT Comlab 4']; ?>
    ],
    backgroundColor: 'rgba(54, 162, 235, 0.5)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 1
}]

      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
</script>
<script src="sweetalert.min.js"></script>
<script>
        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');
        if (successParam === 'true') {
            swal("", "Login Successfully!", "success")
                .then((value) => {
                    window.location.href = 'admin.php'; 
                });
        }
</script>