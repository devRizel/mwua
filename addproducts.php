<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
$page_title = 'All Product';
require_once('includes/load.php');

// Checking what level user has permission to view this page
page_require_level(2);




function fetch_products() {
  global $db; // Use global variable inside the function

  // Modified SQL query with a condition to check for empty 'mother' field
  $sql  = "SELECT p.id, p.name, p.categorie_id, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
  $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
  $sql .= "p.mother_images, p.date, p.mother_images, ";
  $sql .= "c.name AS categorie, m.file_name AS image ";
  $sql .= "FROM products p ";
  $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
  $sql .= "LEFT JOIN mother m ON m.id = p.mother_images ";
  $sql .= "WHERE p.mother IS NULL OR p.mother = '' "; // Filter condition for empty 'mother'
  $sql .= "ORDER BY p.id ASC";

  return $db->query($sql);
}


// Fetch products from the database
$products = fetch_products();

include_once('layouts/header.php');
?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h1 class="text-center">Manage Added Computer Units</h1>
        <div class="pull-right">
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="product-table">
            <thead>
              <tr>
                <th class="text-center" style="width: 10px;">#</th>
                <th class="text-center" style="width: 20%;">Device Categories</th>
                <th class="text-center" style="width: 40%;">Motherboard|Serial Num</th>
                <th class="text-center" style="width: 10px;">Add</th>
                <th class="text-center" style="width: 10px;">Delete</th>
              </tr>
            </thead>
            <tbody id="product-table-body">
              <?php
              $counter = 1; // Initialize counter
              foreach ($products as $product):
              ?>
              <tr>
                <td class="text-center"><?php echo $counter; ?></td>
                <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center">
                  <?php if ($product['mother_images'] === '0'): ?>
                      <img class="img-thumbnail" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                      <img class="img-thumbnail" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editaddproduct.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs" title="Add" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                  </div>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="delete_addproducts.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php
              $counter++; // Increment counter for next row
              endforeach;
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>

<script src="css/sweetalert.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    let successMessage = "";
    if (urlParams.get('update_success')) {
        successMessage = "Computer updated successfully.";
    }
    if (successMessage) {
        swal("", successMessage, "success")
            .then(() => {
              window.location.href = href;
            });
    }
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            const href = this.getAttribute('href');
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this computer!",
                icon: "warning",
                buttons: ["Cancel", "Delete"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Computer deleted successfully.", {
                        icon: "success",
                    }).then(() => {
                        window.location.href = href;
                    });
                } 
            });
        });
    });
});
</script>

