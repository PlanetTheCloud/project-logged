<div class="row">
    <div class="col-sm-7">
        <div class="input-group form-float" style="margin-bottom: 0px!important;">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input id="input_username" type="text" name="username" class="form-control" placeholder="Enter a subdomain name" autocomplete="off">
            </div>
            <small class="col-pink hidden" id="warn_username">{{WARNING}}</small>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="form-line">
            <select id="input_domain" name="domain" class="form-control">
                <?php
                foreach (config('sys.domain_selection') as $key => $value) {
                    if($key == 0){
                        echo "<option selected=\"selected\">{$value}</option>";
                    }else{
                        echo "<option>{$value}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <small class="col-pink hidden" id="warn_domain">{{WARNING}}</small>
    </div>
</div>