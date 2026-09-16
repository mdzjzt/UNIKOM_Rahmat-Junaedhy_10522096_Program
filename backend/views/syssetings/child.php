<div class="overflow-x">
    <table id="dt_basic" 
           class="table table-striped table-bordered table-hover" 
           width="100%" style="margin-top: 0 !important;"
           data-source="<?php echo base_url() . $_modul . '/load'; ?>"
           data-filter="#filter_table">
        <thead>			                
            <tr>
                <th data-hide="phone" class="text-align-center">NO</th>
                <th data-class="expand" class="text-align-center">KEY</th>
                <th data-hide="expand">NAME</th>
                <th data-hide="expand">VALUE</th>
                <th data-hide="expand">DESCRIPTIONS</th>
                <th data-hide="phone" class="text-align-center">FUNCTION</th>
            </tr>
        </thead>
    </table>
</div>
