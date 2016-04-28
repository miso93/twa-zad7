<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 19.04.2016
 * Time: 23:17
 */

Classes\View::get('template.header');
?>
<?php if (($code = \Classes\ViewData::get('code')) != null): ?>
    <?php $visitations = app()->getVisitationForCountryWithCode($code); ?>
    <div class="row">
        <div class="col-md-12">
            <h2>
                Country:
                <?php foreach ($visitations as $key => $value): ?>
                    <?php echo $key; ?>
                <?php endforeach; ?>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <td>City</td>
                    <td>Count</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($visitations as $key => $value): ?>
<!--                    --><?php //dd($value)?>
                    <?php foreach ($value as $city => $count): ?>
                        <tr>
                            <td><?php echo $city; ?></td>
                            <td><?php echo $count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
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
                        <td>
                            <a href="page3.php?country_code=<?php echo $key ?>"><?php echo $visitation['country_name'] ?></a>
                        </td>
                        <td><img class="max-30"
                                 src="http://www.geonames.org/flags/x/<?php echo strtolower($key) ?>.gif"></td>
                        <td><?php echo $visitation['count']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php
Classes\View::get('template.footer');