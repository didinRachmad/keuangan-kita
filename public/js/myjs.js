"use strict";

$(document).ready(function () {
    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom auto",
        showWeekDays: true,
        disableTouchKeyboard: true,
        language: "id",
    });

    // Masking Uang
    // Format mata uang.
    $(".uang").mask("000.000.000.000", {
        reverse: true,
    });

    //  Sweet Alert
    const title = $("title").text();
    const dataSukses = $(".modal-sukses").data("flashdata");
    const dataGagal = $(".modal-gagal").data("flashdata");

    if (dataSukses) {
        Swal.fire({
            // title: title,
            text: "Berhasil " + dataSukses,
            icon: "success",
        });
    }
    if (dataGagal) {
        Swal.fire({
            // title: title,
            text: "Gagal : " + dataGagal,
            icon: "error",
        });
    }

    $(".tombol-hapus").on("click", function (e) {
        e.preventDefault();
        const href = $(this).attr("href");
        const id = $(this).data("id");
        const form = $(this).closest("td").find(".form-hapus");

        Swal.fire({
            title: "Yakin Hapus Data",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus Data!",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.attr("action", href + id);
                form.submit();
            }
        });
    });

    //   Tabel Master AKUN
    $("#tabel_master-akun").DataTable({
        responsive: true,
        dom:
            "<'row'<'col-sm-6 col-md-2'l><'col-sm-6 col-md-6 text-right'B><'col-sm-12 col-md-4 text-right'f>>" +
            "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "csv",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "pdf",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        order: [],
        columnDefs: [
            {
                targets: [2],
                searchable: false,
                orderable: false,
                className: "no-export",
            },
        ],
    });
    //   Tabel Master Kategori
    $("#tabel_master-kategori").DataTable({
        responsive: true,
        dom:
            "<'row'<'col-sm-6 col-md-2'l><'col-sm-6 col-md-6 text-right'B><'col-sm-12 col-md-4 text-right'f>>" +
            "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "csv",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "pdf",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        order: [],
        columnDefs: [
            {
                targets: [2],
                searchable: false,
                orderable: false,
                className: "no-export",
            },
        ],
    });
    //   Tabel Master Anggota
    $("#tabel_master-anggota").DataTable({
        responsive: true,
        dom:
            "<'row'<'col-sm-6 col-md-2'l><'col-sm-6 col-md-6 text-right'B><'col-sm-12 col-md-4 text-right'f>>" +
            "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "csv",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "pdf",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        order: [],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: [5],
                className: "no-export",
            },
        ],
    });

    //   Tabel Keuangan
    $("#tabel-keuangan").DataTable({
        dom:
            "<'row'<'col-sm-6 col-md-2'l><'col-sm-6 col-md-6 text-right'B><'col-sm-12 col-md-4 text-right'f>>" +
            "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "csv",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
            },
            {
                extend: "pdf",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
                customize: function (doc) {
                    var tblBody = doc.content[1].table.body;
                    // Menghitung total untuk kolom ke-5
                    var total = 0;
                    tblBody.forEach(function (row, index) {
                        if (index !== 0) {
                            var numericValue = parseFloat(
                                row[5].text.split(".").join("")
                            );
                            if (!isNaN(numericValue)) {
                                total += numericValue;
                            }
                        }
                    });

                    // Format total sesuai kebutuhan
                    var formattedTotal = total.toLocaleString("id-ID");

                    // Menambahkan <tfoot> dengan total
                    var tfootRow = [
                        { text: "Total:", colSpan: 5, alignment: "center" },
                        {},
                        {},
                        {},
                        {},
                        { text: formattedTotal, alignment: "center" },
                    ];
                    doc.content[1].table.body.push(tfootRow);

                    // Menambahkan footer ke setiap halaman
                    // var footer = function (page, pages) {
                    //     return {
                    //         columns: [
                    //             {
                    //                 text: "Total:",
                    //                 alignment: "right",
                    //                 margin: [0, 10, 0, 0],
                    //                 width: "auto",
                    //             },
                    //             { text: "", alignment: "center", width: "*" },
                    //             {
                    //                 text: formattedTotal,
                    //                 alignment: "center",
                    //                 width: "*",
                    //             },
                    //         ],
                    //         margin: [30, 0],
                    //     };
                    // };

                    doc.styles.tableFooter = {
                        bold: true,
                        border: "1px solid black",
                    };

                    // Penyesuaian gaya untuk border footer
                    doc.styles["footer"] = {
                        fillColor: "#021020",
                        lineWidth: 0.2,
                        lineColor: "#000000",
                    };

                    // FULL WIDTH TABEL
                    doc.content[1].table.widths = Array(
                        doc.content[1].table.body[0].length + 1
                    )
                        .join("*")
                        .split("");
                    doc.styles.tableHeader.alignment = "left";
                    doc.styles.tableBodyEven.alignment = "left";
                    doc.styles.tableBodyOdd.alignment = "left";
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 10;
                    doc.pageMargins = [20, 20, 20, 20];
                },
            },
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(.no-export)",
                },
                customize: function (win) {
                    // Menghitung total untuk setiap halaman yang dicetak
                    $(win.document.body)
                        .find("table")
                        .each(function (index) {
                            var table = $(this);
                            var total = 0;

                            // Menghitung total dari kolom ke-4
                            table.find("tbody tr").each(function () {
                                var row = $(this);
                                var cellText = row
                                    .find("td:nth-child(5)")
                                    .text();
                                var numericValue = parseFloat(
                                    cellText.split(".").join("")
                                );
                                if (!isNaN(numericValue)) {
                                    total += numericValue;
                                }
                            });

                            // Menambahkan footer dengan total
                            var formattedTotal = total.toLocaleString("id-ID");
                            table.append(
                                '<tfoot><tr><td colspan="5" class="text-center">Total:</td><td>' +
                                    formattedTotal +
                                    "</td></tr></tfoot>"
                            );
                        });
                },
            },
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        order: [],
        columnDefs: [
            {
                targets: [6],
                className: "no-export",
                orderable: false,
            },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(),
                data;
            var totalSalary = api
                .column(5, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    var numericValue = parseFloat(b.split(".").join(""));
                    return a + numericValue;
                }, 0);
            var formattedTotal = totalSalary.toLocaleString("id-ID");
            $(api.column(5).footer()).html(formattedTotal);
        },
    });
});
