<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>


    <style scoped>
    input {
        width: 100%;
    }

    .modal .modal-body p {
        border: 0.1px solid black;
        padding: 5px;
    }

    table {
        border: 1px solid black;
        table-layout: fixed;
        width: 200px;
    }

    th,
    td {
        border: 1px solid black;
        width: 100px;
        overflow: hidden;
    }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Import Data</h1>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="container-fluid">
            this is setting page
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-reportall">

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>


    <script type="text/javascript">
    var rootUrl = location.hostname;
    $(document).ready(function() {

        var pId = '';
        var table = '';


        // upload the document of project by name type
        uploadDocument = async (element) => {
            let data = new FormData();
            let file = element[0].files;
            let nameId = element[0].id;
            let typeId = '';
            switch (nameId) {
                case 'document-a':
                    typeId = 1;
                    break;
                case 'document-b-a':
                    typeId = 2;
                    break;
                case 'document-b-b':
                    typeId = 3;
                    break;
                case 'document-c':
                    typeId = 4;
                    break;
                case 'document-d':
                    typeId = 5;
                    break;
                case 'document-e':
                    typeId = 6;
                    break;
                case 'document-f':
                    typeId = 7;
                    break;
                case 'document-g':
                    typeId = 8;
                    break;
                case 'document-h':
                    typeId = 9;
                    break;
            }
            if (file.length > 0) {
                data.append('file', file[0]);
                data.append('projectId', pId);
                data.append('rename', nameId);
                data.append('docType', typeId);
                console.log(data);
                $.ajax({
                    url: './api/file_upload_parser.php',
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        console.log(res);
                    },
                });
            }
        }

        // show modal edit form of project
        projectEdits = async (projectId) => {
            pId = projectId;
            let details = {};
            await axios.post('./api/informations.php', {
                action: 'projectEdits',
                projectId: projectId
            }).then((res) => {
                details = res.data.data[0]
                if (details == '') {
                    console.log('data empty')
                } else {
                    $.each(details, function(keys, values) {
                        $('#' + keys).val(values);
                    });
                }
            })
            $('#projectEdits').modal('show');
        }


        // update data of project 
        projectUpdate = async () => {
            let datas = {};
            $.each($("#projectEditForm").serializeArray(), function(i, field) {
                datas[field.name] = field.value;
            });
            await axios.post('./api/informations.php', {
                action: 'updateProjects',
                data: datas,
                projectId: pId
            }).then(async (res) => {
                if (res.data.status) {
                    await alertify.success('Updated')
                    await reportAll();
                    await $('#projectEdits').modal('hide');
                }
            })
        }

        // clear link file a tag every reclick for show list documents of project
        clearDataFile = async () => {
            console.log('clear data ready now !');
            $('#formDocuments a').each(function(index) {
                var forAttr = $(this);
                forAttr[0].remove()
            });
        }

        // show list documents of project
        projectDocuments = async (projectId) => {
            pId = projectId;
            console.log('project documents ready. id = ' + projectId);
            await clearDataFile();
            await axios.post('./api/informations.php', {
                action: 'projectDocuments',
                projectId: projectId
            }).then((res) => {
                console.log('project document list ready now !');
                if (res.data.message == 'success') {
                    let details = res.data.data;
                    console.log(res)
                    details.forEach(element => {
                        let name = element.documentNameFile.split('.');
                        let file = element.documentNameFile;
                        let targetUrl = "../uploads/projects/" + pId + "/" + file;
                        let el = $('label[for=' + name[0] + ']')[0].textContent.trim();
                        let linkFileopen = ' <a href = "' + targetUrl +
                            '" target = "_blank">' + file +
                            '</a>';
                        $('label[for="' + name[0] + '"]').after(linkFileopen);
                    });
                }
            })
            $('#projectDocuments').modal('show');
        }

        // get projects to table 
        reportAll = async () => {
            await axios.post('./api/informations.php', {
                action: 'listProjectAll'
            }).then(async (res) => {
                let projects = res.data.data;
                let tableHtml =
                    ' <table id="report_table" class="table table-responsive table-bordered table-hover text-center">';
                tableHtml +=
                    '<thead><tr><th>No.</th><th>รหัสโครงการ</th><th>สถานะ</th><th>ชื่อโครงการ(ไทย)</th><th>ชื่อโครงการ(อังกฤษ)</th><th>หัวหน้าโครงการ</th><th>วันที่ยื่นขอ</th><th>วันที่อนุมัติ</th><th width="100px"></th> </tr></thead><tbody></tbody>';
                $('.table-reportall').html(tableHtml);
                if (projects.length > 0) {
                    output = '';
                    for (i = 0; i < projects.length; i++) {
                        output += "<tr>";
                        output += "<td>" + (i + 1) + "</td>";
                        output += "<td>" + projects[i]['projectCode'] + "</td>";
                        if (projects[i]['projectStatus'] == '0') {
                            output += "<td class = 'text-info'>" + 'รออนุมัติ';
                        } else if (projects[i]['projectStatus'] == '1') {
                            output += "<td class = 'text-success'>" + 'อนุมัติ';
                        } else {
                            output += "<td class = 'text-danger'>" + 'ไม่อนุมัติ';
                        }
                        output += "</td>";
                        output += "<td>" + projects[i]['projectNameTH'] + "</td>";
                        output += "<td>" + projects[i]['projectNameEN'] + "</td>";
                        output += "<td>" + projects[i]['projectPosition'] + " " + projects[
                            i][
                            'projectLeader'
                        ] + "</td>";
                        output += "<td>" + projects[i]['projectRequestDate'] + "</td>";
                        output += "<td>" + projects[i]['projectApprovalDate'] + "</td>";
                        output += "<td>";
                        output +=
                            '<button class = "btn btn-sm btn-outline-info" onclick = "projectEdits(' +
                            projects[i][
                                'projectId'
                            ] + ')"><i class="fas fa-edit"></i></button>';
                        output +=
                            '<button class = "btn btn-sm btn-outline-info ml-1" onclick = "projectDocuments(' +
                            projects[i][
                                'projectId'
                            ] + ')"><i class="fas fa-folder"></i></button>';
                        output += "</td>";
                        output += "</tr>";
                    }
                    await $('#report_table tbody').html(output);
                    var table = await $('#report_table').DataTable({
                        language: {
                            searchPlaceholder: "Search records"
                        },
                        initComplete: function() {
                            this.api()
                                .columns()
                                .every(function() {
                                    var column = this;
                                    if (column[0] == 2) {
                                        let text = $(column.header())[0]
                                            .innerHTML;
                                        var select =
                                            $(
                                                '<select class = "form-control form-control-sm col-md-3 float-right ml-2"><option value="" >' +
                                                text + '</option></select>'
                                            )
                                            .appendTo($(
                                                '#report_table_filter'))
                                            .on('change', function() {
                                                var val = $.fn.dataTable
                                                    .util.escapeRegex($(
                                                        this).val());

                                                column.search(val ?
                                                        '^' +
                                                        val + '$' : '',
                                                        true, false)
                                                    .draw();
                                            });

                                        column
                                            .data()
                                            .unique()
                                            .sort()
                                            .each(function(d, j) {
                                                select.append(
                                                    '<option value="' +
                                                    d + '">' + d +
                                                    '</option>');
                                            });
                                    }

                                });
                        },
                    });
                }
            })
        }


        //  load default function on page
        initialLoadFunction = async () => {
            reportAll();
        }

        // initialLoadFunction();
    });
    </script>
</body>

</html>