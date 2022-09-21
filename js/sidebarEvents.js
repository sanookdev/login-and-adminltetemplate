$(document).ready(function () {

    // this function use for load page content
    loadPage = (page = 'admin_report') => {
        console.log(page.split('.')[0])
        $('.contentUrl').load(page);

    }

    // this function use for addClass and removeClass to menu report
    report_menu = (choice, e) => {
        // choice is mean   1 = projects list all , 2 = new projects Awaiting for approve , 3 = projects will expire
        $('.nav-item .nav-link').removeClass('active');
        $('.nav_reportMenu .nav-link').addClass('active');
        $('.nav_reportMenu .nav-treeview .nav-link').removeClass('active');
        $(e).addClass('active');
        if (choice == 1) {
            let contentPageUrl = 'report/reportAll.php';
            $(e).attr("href", '#' + contentPageUrl.split('.')[0])
            loadPage(contentPageUrl);
        } else if (choice == 2) {
            let contentPageUrl = 'report/reportAwaitingApprove.php';
            $(e).attr("href", '#' + contentPageUrl.split('.')[0])
            loadPage(contentPageUrl);
        } else if (choice == 3) {
            let contentPageUrl = 'report/reportExpire.php';
            $(e).attr("href", '#' + contentPageUrl.split('.')[0])
            loadPage(contentPageUrl);
        }
    }

    // this function use for addClass and removeClass to main menu
    activityClassNavLink = (e, page = null) => {
        $('.nav-item .nav-link').removeClass('active');
        if (page != 'report') {
            if (page == 'dashboard') {
                page = 'home.php';
            } else if (page == 'settings') {
                page = 'settings.php';
            }
            loadPage(page);
        }
        $(e).addClass('active');
    }

    loadPage();

})