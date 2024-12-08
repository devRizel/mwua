<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
$page_title = 'All Product';
require_once('includes/load.php');
// Checking what level user has permission to view this page
page_require_level(2);
$filtered_products = []; // Initialize an empty array for filtered products



function fetch_products() {
  global $db; // Use global variable inside the function

  // Modify SQL query to include a WHERE clause that filters out products with media_id = 0 or NULL
  $sql  = "SELECT p.id, p.name, p.categorie_id, p.recievedby, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
  $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
  $sql .= "p.media_id, p.date, ";
  $sql .= "c.name AS categorie, ";
  $sql .= "m.file_name AS image, ";
  $sql .= "p.computer_images, p.monitor_images, p.mouse_images, p.system_images, p.vgahdmi_images, ";
  $sql .= "p.power1_images, p.power2_images, p.chord1_images, p.chord2_images, p.mother_images, ";
  $sql .= "p.cpu_images, p.ram_images, p.video_images, p.hddssdgb_images ";
  $sql .= "FROM products p ";
  $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
  $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
  $sql .= "WHERE p.media_id IS NOT NULL AND p.media_id != '0' ";
  $sql .= "AND (p.computer_images NOT LIKE '%Maintenance%' AND p.monitor_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.mouse_images NOT LIKE '%Maintenance%' AND p.system_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.vgahdmi_images NOT LIKE '%Maintenance%' AND p.power1_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.power2_images NOT LIKE '%Maintenance%' AND p.chord1_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.chord2_images NOT LIKE '%Maintenance%' AND p.mother_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.cpu_images NOT LIKE '%Maintenance%' AND p.ram_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.video_images NOT LIKE '%Maintenance%' AND p.hddssdgb_images NOT LIKE '%Maintenance%' AND ";
  $sql .= "p.keyboard_images NOT LIKE '%Maintenance%') "; 
  $sql .= "ORDER BY p.id ASC";
  
  $result = $db->query($sql);
  return $result ? $result->fetch_all(MYSQLI_ASSOC) : array(); // Fetch as associative array
}


// Fetch products from the database
$products = fetch_products();

// Filter products where the name is 'Comlab 1'
foreach ($products as $product) {
    if ($product['name'] === 'Com lab 2') {
        $filtered_products[] = $product;
    }
}

$filtered_products = array_reverse($filtered_products); // Reverse the array of filtered products
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h1 class="text-center">IT Comlab 2 | Computer units</h1>
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
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Select</th>
                <th class="text-center" style="width: 150px;">Photo</th>
                <th class="text-center" style="width: 10%;">Title Room</th>
                <th class="text-center" style="width: 10%;">Device Categories</th>
                <th class="text-center" style="width: 20%;">Motherboard|Serial Num</th>
                <th class="text-center" style="width: 100px;">Actions</th>
                <th class="text-center" style="width: 100px;">Actions</th>
                <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $counter = 1; // Initialize counter
              foreach ($filtered_products as $product):
              ?>
               <tr>
    <td class="text-center"><?php echo $counter; ?></td>
    <td class="text-center">
      <input type="checkbox" name="select_product[]" value="<?php echo $product['id']; ?>" class="product-checkbox" data-row="<?php echo $counter; ?>">
    </td>
    <td class="text-center">
                  <?php if ($product['media_id'] === '0'): ?>
                      <img class="img-thumbnail" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                      <img class="img-thumbnail" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
    <td><?php echo remove_junk($product['name']); ?></td>
    <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
    <td class="text-center"><?php echo remove_junk($product['mother']); ?></td>
    <td class="text-center">
    <form action="product4main" method="get" style="display:inline;">
    <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
    <button style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;" type="submit" class="btn-light-green" data-toggle="tooltip">
        <span class="glyphicon"></span> Status
    </button>
</form>
    </td>
    <td class="text-center">
    <form action="product4view" method="get" style="display:inline;">
  <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
  <button type="submit" class="btn-custom" data-toggle="tooltip">
      <span class="glyphicon"></span> View
  </button>
</form>
    </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product4.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_product4.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
              <tr class="dropdown-row" id="dropdown-row-<?php echo $counter; ?>" style="display:none;">
    <td colspan="10">
      <strong>Additional Information:</strong>
      <br><br><br>
      <p><strong>•Title Room: </strong><?php echo remove_junk($product['name']); ?></p>
      <p><strong>•Device Categories: </strong> <?php echo remove_junk($product['categorie']); ?></p>
      <p><strong>•Donated By: </strong> <?php echo remove_junk($product['donate']); ?></p>
      <p><strong>•Date Received: </strong> <?php echo remove_junk($product['dreceived']); ?></p>
      <p><strong>•Received By: </strong> <?php echo remove_junk($product['recievedby']); ?></p>
      <p><strong>•Monitor: </strong> <?php echo remove_junk($product['monitor']); ?></p>
      <p><strong>•Keyboard: </strong> <?php echo remove_junk($product['keyboard']); ?></p>
      <p><strong>•Mouse: </strong> <?php echo remove_junk($product['mouse']); ?></p>
      <p><strong>•VGA|HDMI: </strong> <?php echo remove_junk($product['v1']); ?></p>
      <p><strong>•Power Chord 1: </strong> <?php echo remove_junk($product['p1']); ?></p>
      <p><strong>•Power Chord 2: </strong> <?php echo remove_junk($product['p2']); ?></p>
      <p><strong>•Power Supply|AVR: </strong> <?php echo remove_junk($product['power1']); ?></p>
      <p><strong>•System Unit Model: </strong> <?php echo remove_junk($product['system']); ?></p>
      <p><strong>•Motherboard|Serial Num: </strong> <?php echo remove_junk($product['mother']); ?></p>
      <p><strong>•CPU|Processor: </strong> <?php echo remove_junk($product['cpu']); ?></p>
      <p><strong>•RAM Quantity|Model: </strong> <?php echo remove_junk($product['ram']); ?></p>
      <p><strong>•Power Supply 2: </strong> <?php echo remove_junk($product['power2']); ?></p>
      <p><strong>•Video Card|GPU: </strong> <?php echo remove_junk($product['video']); ?></p>
      <p><strong>•HDD|SSD|GB: </strong> <?php echo remove_junk($product['h']); ?></p>
      <p><strong>•Date: </strong> <?php echo remove_junk($product['date']); ?></p>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.getElementById('search-bar');
    const table = document.getElementById('product-table');
    const rows = table.querySelectorAll('tbody > tr:not(.dropdown-row)'); // Exclude dropdown rows
    const dropdownRows = table.querySelectorAll('tbody > .dropdown-row'); // Dropdown rows

    searchBar.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            const motherCell = row.querySelector('td:nth-child(6)'); // Assuming 'Motherboard|Serial Num' is the 9th column
            const mother = motherCell ? motherCell.textContent.toLowerCase() : '';

            if (mother.includes(searchTerm)) {
                row.style.display = '';
                // Also show the related dropdown row
                const rowId = row.querySelector('.product-checkbox').getAttribute('data-row');
                const dropdownRow = document.getElementById('dropdown-row-' + rowId);
                if (dropdownRow) {
                    dropdownRow.style.display = 'table-row';
                }
            } else {
                row.style.display = 'none';
                // Hide the related dropdown row if the main row is hidden
                const rowId = row.querySelector('.product-checkbox').getAttribute('data-row');
                const dropdownRow = document.getElementById('dropdown-row-' + rowId);
                if (dropdownRow) {
                    dropdownRow.style.display = 'none';
                }
            }
        });

        // Hide all dropdown rows for hidden rows
        dropdownRows.forEach(dropdownRow => {
            if (dropdownRow.style.display !== 'none') {
                dropdownRow.style.display = 'none';
            }
        });
    });

    // Initial setup to ensure dropdown rows are in sync with visible rows
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const rowId = this.getAttribute('data-row');
            const dropdownRow = document.getElementById('dropdown-row-' + rowId);
            if (this.checked) {
                dropdownRow.style.display = 'table-row';
            } else {
                dropdownRow.style.display = 'none';
            }
        });
    });
});

</script>
<style>
.search-container {
  display: inline-block;
  margin-left: 10px;
}

#search-bar {
  width: 200px;
  display: inline-block;
}
/* Add this to your existing CSS file or within a <style> tag in your HTML */
.btn-light-green {
  background-color: green;
  border: none;
  color: #fff; /* White text */
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px; /* Rounded corners */
  box-shadow: 0 4px #999; /* Shadow effect */
}

.btn-light-green:hover {
  background-color: #76c7c0; /* Slightly darker green on hover */
}

.btn-light-green:active {
  background-color: green; /* Even darker green when clicked */
  box-shadow: 0 2px #666;
  transform: translateY(2px);
}
/* Style for buttons similar to the "Add New" button */
.btn-custom {
  background-color: #007bff; /* Primary blue color */
  border: none;
  color: #fff; /* White text */
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; /* Same border-radius as "Add New" button */
  box-shadow: 0 4px #999; /* Shadow effect */
}

.btn-custom:hover {
  background-color: #0056b3; /* Slightly darker blue on hover */
}

.btn-custom:active {
  background-color: #004080; /* Even darker blue when clicked */
  box-shadow: 0 2px #666;
  transform: translateY(2px);
}
/* Ensure buttons in the btn-group have a width of 30px */
.btn-group a.btn {
  width: 30px;
  padding: 5px; /* Adjust padding to fit the smaller width */
  text-align: center;
  font-size: 14px; /* Adjust font size if needed */
}

.btn-group a.btn .glyphicon {
  font-size: 16px; /* Adjust glyphicon size if needed */
}

</style>