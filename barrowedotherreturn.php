<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
$page_title = 'All Product';
require_once('includes/load.php');

// Checking what level user has permission to view this page
page_require_level(2);


$filtered_other = [];


function fetch_other() {
  global $db;

  $sql = "SELECT 
            p.id, 
            p.name, 
            p.categorie_id, 
            p.donate, 
            p.dreceived, 
            p.media_id, 
            p.date,
            p.serial, 
            p.barrow,
            c.name AS categorie, 
            m.file_name AS image,
            p.other_images
          FROM 
            other p 
          LEFT JOIN 
            categories c ON c.id = p.categorie_id 
          LEFT JOIN 
            media m ON m.id = p.media_id 
          WHERE 
            p.other_images NOT LIKE '%Maintenance%' 
          AND 
            p.barrow LIKE '%Return%' 
          ORDER BY 
            p.id ASC";

  return find_by_sql($sql);
}


// Fetch the products and assign them to $products
$products = fetch_other();

// Ensure $products is an array before sorting
if (is_array($products)) {
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
}

// Fetch categories
$all_categories = find_all('categories');


include_once('layouts/header.php');
?>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h1 class="text-center">Return Peripheral Devices</h1>
        <div class="select-wrapper">
          <select id="category-select"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;"  class="form-control" name="Device-Category">
            <option value="">All Peripheral Devices</option>
            <?php foreach ($all_categories as $cat): ?>
              <?php if ($cat['name'] != 'Computer'): ?>
                <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                  <?php echo htmlspecialchars($cat['name']); ?>
                </option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
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
                <th class="text-center" style="width: 150px;">Photo</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th class="text-center" style="width: 100px;">Return Date</th>
                <th class="text-center" style="width: 10%;">Device Categories</th>
                <th class="text-center" style="width: 10%;">Serial Num.</th>
                <th class="text-center" style="width: 100px;">Action</th>
                <th class="text-center" style="width: 100px;">Action</th>
                
              </tr>
            </thead>
            <tbody>
              <?php
              $counter = 1; // Initialize counter
              foreach ($products as $product):
              ?>
              <tr>
                <td class="text-center"><?php echo $counter; ?></td>
                <td class="text-center">
                  <?php if ($product['media_id'] === '0'): ?>
                      <img class="img-thumbnail" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                      <img class="img-thumbnail" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td class="text-center"><?php echo remove_junk($product['barrow']); ?></td>
                <td class="text-center"><?php echo remove_junk($product['date']); ?></td>
                <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"><?php echo remove_junk($product['serial']); ?></td>
    <td class="text-center">
    <form action="barrowedotherreturn1" method="get" style="display:inline;">
  <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
  <button type="submit" class="btn-custom" data-toggle="tooltip">
      <span class="glyphicon"></span> View
  </button>
</form>
<td class="text-center">
                    <a href="barrowedotherreturndelete.php?id=<?php echo (int)$product['id'];?>" 
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
<script src="css/sweetalert.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    let successMessage = "";
    if (urlParams.get('update_success')) {
        successMessage = "Peripheral Devices updated successfully.";
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
              text: "Once deleted, you will not be able to recover this Peripheral Devices!",
                icon: "warning",
                buttons: ["Cancel", "Delete"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Peripheral Devices deleted successfully.", {
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
       const categorySelect = document.getElementById('category-select');
    const searchBar = document.getElementById('search-bar');
    const table = document.getElementById('product-table');
    const rows = table.querySelectorAll('tbody > tr');

    function filterTable() {
        const selectedCategory = categorySelect.value.toLowerCase();
        const searchTerm = searchBar.value.toLowerCase();

        rows.forEach(row => {
            const categoryCell = row.querySelector('td:nth-child(4)');
            const serialCell = row.querySelector('td:nth-child(6)');
            const titleCell = row.querySelector('td:nth-child(3)');
            const category = categoryCell ? categoryCell.textContent.toLowerCase() : '';
            const serialNum = serialCell ? serialCell.textContent.toLowerCase() : '';
            const title = titleCell ? titleCell.textContent.toLowerCase() : '';

            const categoryMatch = selectedCategory === '' || category === selectedCategory;
            const searchMatch = serialNum.includes(searchTerm) || title.includes(searchTerm);

            if (categoryMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    categorySelect.addEventListener('change', filterTable);
    searchBar.addEventListener('input', filterTable);
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