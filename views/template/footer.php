
</div>

<script type="text/javascript">
    $(function () {
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    });

</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
</article>
</body>
</html>


<?php
app()->get_user_IP();
app()->init_geo_plugin();
app()->parseLocation();
app()->initGoogleGeocode();
app()->initWorldBankApi();
Visitation::triggerVisit(app()->getLocationString(),app()->get_user_IP(), app()->getCountryAbbr(), app()->getCityName(), app()->getCountryName());

?>