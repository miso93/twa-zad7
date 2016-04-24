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
            <table>
                <tbody>
                <tr>
                    <?php foreach (app()->getWeathers() as $weather_day): ?>
                        <td class="text-center">
                            <?php echo $weather_day->weekday; ?><br>
                            <img src="http://icons.wxug.com/i/c/k/<?php echo $weather_day->icon ?>.gif"><br>
                            <span class=""><?php echo $weather_day->text ?></span>
                        </td>
                    <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php
Classes\View::get('template.footer');