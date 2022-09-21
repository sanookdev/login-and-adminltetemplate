<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dipslay</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped table-hover" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Code</th>
                        <th>Name TH</th>
                        <th>Leader</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $i = 0;
                foreach($result as $row) { 
                ?>
                    <tr>
                        <td><?php ++$i; ?></td>
                        <td><?php echo $row->projectCode; ?></td>
                        <td><?php echo $row->projectNameTH; ?></td>
                        <td><?php echo $row->projectLeader; ?></td>
                        <td><?php echo $row->projectCreated; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>