
<table class="table-auto w-full mt-4">
        <thead>
          <tr>
            <th class="px-4 py-2 text-center">Name</th>
            <th class="px-4 py-2 text-center">Department</th>
            <th class="px-4 py-2 text-center">Position</th>
            <th class="px-4 py-2 text-center">Total Salary</th>
            <th class="px-4 py-2 text-center">Action</th>
          </tr>
        </thead>
        <?php foreach ($rows as $row): ?>
        <tbody>
            <tr>
              <td class='px-4 py-2 text-center'>
                <?php 
                    echo $row['first_name'] . ' ';
                    if (!empty($row['middle_name'])) {
                        echo substr($row['middle_name'], 0, 1) . '. ';
                    }
                    echo $row['last_name']; 
                ?>
                </td>
                <td class='px-4 py-2 text-center'><?php echo $row['department']; ?></td>
            </tr>
        </tbody>