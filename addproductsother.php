<?php
$page_title = 'All Product';
require_once('includes/load.php');

// Checking what level user has permission to view this page
page_require_level(2);

// Fetch products from the database
$products = join_other_table();



$all_categories = find_all('categories');

// Define an array with desired order of names
$desired_order = array(
  "Faculty",
  "Server Room",
  "Com lab 1",
  "Com lab 2",
  "Com lab 3",
  "Com lab 4"
);

// Function to determine position in desired order array
function custom_sort($product) {
  global $desired_order;
  $name = $product['name'];
  $position = array_search($name, $desired_order);
  return ($position === false) ? count($desired_order) : $position;
}

// Sort products based on custom sort function
usort($products, function($a, $b) {
  return custom_sort($a) - custom_sort($b);
});

include_once('layouts/header.php');
?>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h1 class="text-center">Other Devices</h1>
        <div class="pull-right">
          <div class="search-container" style="display: inline-block; margin-left: 10px;">
            <input type="text" id="search-bar" class="form-control" placeholder="Search...">
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="product-table">
            <thead>
              <tr>
                <th class="text-center" style="width: 10px;">#</th>
                <th class="text-center" style="width: 20%;">Device Categories</th>
                <th class="text-center" style="width: 40%;">Serial No.</th>
                <th class="text-center" style="width: 10px;">Add</th>
                <th class="text-center" style="width: 10px;">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $counter = 1; // Initialize counter
              foreach ($products as $product):
              ?>
              <tr>
                <td class="text-center"><?php echo $counter; ?></td>
                <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center">
                  <?php if ($product['media_id'] === '0'): ?>
                      <img class="img-thumbnail" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                      <img class="img-thumbnail" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product7.php?id=<?php echo (int)$product['id'];?>" 
                    class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                  </div>
                </td><td class="text-center">
                  <div class="btn-group">
                    <a href="delete_product7.php?id=<?php echo (int)$product['id'];?>" 
                    class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
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
<script src="sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    let successMessage = "";

    if (successParam === 'true') {
        if (urlParams.get('delete_photo')) {
            successMessage = "Other Device Deleted Successfully.";
        } else if (urlParams.get('update_success')) {
            successMessage = "Other Device updated successfully.";
        }

        swal("", successMessage, "success")
            .then((value) => {
                window.location.href = 'addproductsother.php';
            });
    }

    // Select box filter functionality
    const categorySelect = document.getElementById('category-select');
    const searchBar = document.getElementById('search-bar');
    const table = document.getElementById('product-table');
    const rows = table.querySelectorAll('tbody > tr');

    categorySelect.addEventListener('change', function() {
        const selectedCategory = this.value.toLowerCase();

        rows.forEach(row => {
            const categoryCell = row.querySelector('td:nth-child(4)');
            const category = categoryCell ? categoryCell.textContent.toLowerCase() : '';

            if (selectedCategory === '' || category === selectedCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    searchBar.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            const titleRoomCell = row.querySelector('td:nth-child(3)');
            const titleRoom = titleRoomCell ? titleRoomCell.textContent.toLowerCase() : '';

            if (titleRoom.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
<style>
.select-wrapper {
    margin-right: 20px;
}

.select-wrapper .form-control {
    width: 200px;
    text-align: left;
}

.search-container {
    display: inline-block;
    margin-left: 10px;
}

#search-bar {
    width: 180px;
    display: inline-block;
}
</style>
