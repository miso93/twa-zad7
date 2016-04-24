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
        <div class="col-md-12">
            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <td>Country</td>
                    <td>Flag</td>
                    <td>Count</td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach (app()->getVisitationsByCountry() as $key => $visitation): ?>
                        <tr>
                            <td><?php echo $visitation['country_name']?></td>
                            <td><img src="http://www.geonames.org/flags/x/<?php echo strtolower($key)?>.gif"></td>
                            <td><?php echo $visitation['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
Classes\View::get('template.footer');