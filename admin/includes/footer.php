 <script src="assets/vendors/js/vendors.min.js"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/vendors/js/apexcharts.min.js"></script>
    <script src="assets/vendors/js/circle-progress.min.js"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/dashboard-init.min.js"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="assets/js/theme-customizer-init.min.js"></script>

        <script src="assets/vendors/js/circle-progress.min.js"></script>
    <script src="assets/vendors/js/dataTables.min.js"></script>
    <script src="assets/vendors/js/dataTables.bs5.min.js"></script>
    <script src="assets/vendors/js/tagify.min.js"></script>
    <script src="assets/vendors/js/tagify-data.min.js"></script>
    <script src="assets/vendors/js/quill.min.js"></script>
    <script src="assets/vendors/js/select2.min.js"></script>
    <script src="assets/vendors/js/select2-active.min.js"></script>
    <!--! END: Theme Customizer !-->
</body>

</html>

    <script>
function getNotifications() {
    $.ajax({
        url: 'assets/php/clients/get_notifications.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            let html = '';
            let unread = 0;

            data.forEach(notif => {
                if (notif.is_read == 0) unread++;

                // map status to icon & color
                let iconClass = '';
                switch(notif.status){
                    case 'en_attente': iconClass = 'feather-clock text-warning'; break;
                    case 'en_cours':   iconClass = 'feather-loader text-info'; break;
                    case 'valide':     iconClass = 'feather-check-circle text-success'; break;
                    case 'refuse':     iconClass = 'feather-x-circle text-danger'; break;
                }

                html += `
                <div class="notifications-item d-flex align-items-start mb-2">
                    <i class="${iconClass} me-3 fs-18"></i>
                    <div class="notifications-desc">
                        <div class="font-body text-truncate-2-line">${notif.message}</div>
                        <div class="text-muted fs-12">${notif.created_at}</div>
                    </div>
                </div>
                `;
            });

            $('#notifications-list').html(html);
            $('#notif-count').text(unread);
        }
    });
}

// Call every 15 sec
getNotifications();
setInterval(getNotifications, 15000);


/****************************************************************************** */

$(document).on('click', '#notificationDropdown', function () {

    // Optional: visually remove unread badge
    $(this).removeClass('unread');

    // Call PHP to mark as read
    $.post('assets/php/clients/mark_notification_read.php', { id: notifId }, function(response) {
        console.log('Notification marked as read');
        // Update unread counter
        getNotifications();
    }, 'json');
});

    </script>