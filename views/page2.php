<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 19.04.2016
 * Time: 23:17
 */

Classes\View::get('template.header');
?>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td>Key</td>
                        <td>Value</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>IP</td>
                    <td><?php echo getRealIp()?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


<?php
Classes\View::get('template.footer');