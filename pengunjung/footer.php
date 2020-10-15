<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul>
                <!-- <li>
                    <a href="#">
                        Home
                    </a>
                </li> -->
            </ul>
        </nav>
        <p class="copyright pull-right">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> - SPK</a> Rekomendasi ikan lele
        </p>
    </div>
</footer>

</div>
</div>


</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/holder.min.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/popper.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<script type="text/javascript">
    function show_alert(message, type) {
        $.notify({
            icon: 'pe-7s-info',
            message: message

        }, {
            type: type,
            timer: 4000
        });
    }

    //set active navigation status and user page title based on active navigation
    $(document).ready(function() {
        var CurrentUrl = document.URL;
        var CurrentUrlEnd = CurrentUrl.split('/').filter(Boolean).pop();
        $(".nav li a").each(function() {
            var ThisUrl = $(this).attr('href');
            var ThisUrlEnd = ThisUrl.split('/').filter(Boolean).pop();

            if (ThisUrlEnd == CurrentUrlEnd) {
                $(this).closest('li').addClass('active');
            }
            $('.navbar-brand').text($("li.active").find("p").html());
        });
    });

    $(document).ready(function() {

        //initiate datatable table data ikan
        var table = $('#tabeldata').DataTable({
            "language": {
                "info": "Menampilkan _START_ - _END_ dari total _TOTAL_ data ikan",
                "emptyTable": "Data identifikasi ikan kosong",
                "zeroRecords": "Tidak ada data ditemukan",
                "infoEmpty": "Data identifikasi ikan kosong",
                "search": "Cari:",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "lengthMenu": "Menampilkan _MENU_ data",
                "loadingRecords": "Memuat...",
                "processing": "Memproses..."
            },
            "ajax": {
                "url": "ajax/data_alternatif.php",
                "type": "POST",
                "dataType": "json",
                "dataSrc": ""
            },
            "columns": [{
                    "target": 0,
                    "data": "id_alternatif"
                },
                {
                    "target": 1,
                    "data": "nama_alternatif"
                },
                {
                    "target": 2,
                    "data": "sts_identifikasi",
                    "render": function(data, type, row) {
                        var bindHtml = data == '1' ? '<i class="fa fa-check text-success">' : '<i class="fa fa-times text-danger"></i>';
                        bindHtml += '<p hidden>' + data + '</p>';
                        return bindHtml;
                    }
                },
                {
                    "target": 3,
                    "data": "id_alternatif",
                    "orderable": false,
                    "render": function(data, type, row) {
                        var bindHtml = ' <td class="td-actions text-center">';
                        bindHtml += '<a href="../pengunjung/wizard.php?id=' + data + '&status=' + row['sts_identifikasi'] + '" rel="tooltip" title="Identifikasi" class="btn btn-info btn-simple btn-xs"><i class="fa fa-bolt"></i></a>';
                        bindHtml += '<a href="#IkanModal" data-alternatif-id="' + data + '" data-toggle="modal" data-backdrop="false" modal-action="update" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs"><i class="fa fa-edit"></i>';
                        bindHtml += '<a href="javascript:void(0)" rel="tooltip" id="' + data + '" title="Hapus" class="btn btn-danger btn-simple btn-xs hapus"><i class="fa fa-trash-o"></i></a>';
                        bindHtml += '</td>'
                        return bindHtml;
                    }
                },
            ]

        });

        //onclick  action on modal ikan
        $(document).on('click', '#ActionModalIkan', function() {
            var nama_ikan = document.getElementById("nama-ikan").value;
            var keterangan_ikan = document.getElementById("keterangan-ikan").value;
            var modal_action = document.getElementById("operation").value;
            var id = document.getElementById("id-ikan").value;

            if (modal_action == 'insert') {
                $.ajax({
                    type: "POST",
                    dataType: 'text',
                    url: "ajax/insert_alternatif.php",
                    data: "na=" + nama_ikan + "&d=" + keterangan_ikan,
                    success: function(data) {
                        $('#IkanModal').modal('hide');
                        switch (data) {
                            case 'success':
                                table.ajax.reload();
                                show_alert("Berhasil <b>tambah data ikan</b>", 'success');
                                break;
                            default:
                                show_alert("Gagal <b>tambah data ikan</b>", 'warning');
                                break;
                        }
                    }

                });
            }
            if (modal_action == 'update') {
                $.ajax({
                    type: "POST",
                    dataType: 'text',
                    url: "ajax/update_alternatif.php",
                    data: "id=" + id + "&na=" + nama_ikan + "&ki=" + keterangan_ikan,
                    success: function(data) {
                        $('#IkanModal').modal('hide');
                        switch (data) {
                            case 'success':
                                table.ajax.reload();
                                show_alert("Berhasil <b>ubah data ikan</b>", 'success');
                                break;
                            default:
                                show_alert("Gagal <b>ubah data ikan</b>", 'warning');
                                break;
                        }
                    }

                });
            }
        });

        //set modal based type of modal-action (insert or update)
        $('#IkanModal').on('show.bs.modal', function(event) {

            var modal = $(this);
            if ($(event.relatedTarget).attr('modal-action') == 'update') {
                document.getElementById("operation").value = "update";
                modal.find('h5#IkanModalLabel').text('Ubah Data Ikan');
                $('#ActionModalIkan').html('Ubah');
                var id = $(event.relatedTarget).data('alternatif-id');
                $.ajax({
                    method: "POST",
                    url: "ajax/data_alternatif_by_id.php",
                    dataType: "json",
                    data: "id=" + id,
                }).done(function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            document.getElementById('nama-ikan').value = value.nama_alternatif;
                            document.getElementById('keterangan-ikan').value = value.deskripsi;
                            document.getElementById('id-ikan').value = value.id_alternatif;
                        });
                    }
                });

            }

            if ($(event.relatedTarget).attr('modal-action') == 'insert') {
                document.getElementById("operation").value = "insert";
                modal.find('h5#IkanModalLabel').text('Tambah Data Ikan');
                $('#ActionModalIkan').html('Tambah');
            }
        });

        //clear modal ikan field on modal hide
        $('#IkanModal').on('hidden.bs.modal', function() {
            $(this).find("input,textarea").val('').end();

        });

        //show bootstap notification based url paramert
        if (window.location.hash === "#inserted") {
            show_alert("Berhasil <b>tambah data identifikasi</b>", 'success')
        }

        if (window.location.hash === "#insertedduplicated") {
            show_alert("Gagal tambah data identifikasi , <b> data sudah ada</b>", 'warning');
        }

        if (window.location.hash === "#errorinsert") {
            show_alert("Gagal <b>tambah data identifikasi</b>", 'warning');
        }

        if (window.location.hash === "#updated") {

            show_alert("Berhasil <b>update data identifikasi</b>", 'success');
        }

        if (window.location.hash === "#errorupdate") {
            show_alert("Gagal <b>update data identifikasi</b>", 'warning');
        }

        //onclick delete action button on datatable table data ikan 
        $('#tabeldata').on('click', '.hapus', function() {
            var confirm_delete = confirm('Yakin ingin menghapus data');
            if (confirm_delete) {
                var id = ($(this).attr('id'));

                $.ajax({
                    type: "POST",
                    dataType: 'text',
                    url: "ajax/delete_alternatif.php",
                    data: "id=" + id,
                    success: function(data) {
                        switch (data) {
                            case 'success':
                                table.ajax.reload();
                                show_alert("Berhasil <b>hapus data ikan</b>", 'success');
                                break;
                            default:
                                show_alert("Gagal <b>hapus data ikan</b>", 'warning')
                                break;
                        }
                    }
                });
                return false;
            }
        });

        //cek jika ada data yang belum diidentifikasi, iframe analisa tidak muncul
        $("#btnAnalisa").click(function() {
            var colll = table.columns(2).data().each(function() {});
            var allstt_identifkasi = colll[0];
            if (allstt_identifkasi.includes("0")) {} else {
                var analisis_source = '../pengunjung/rangking.php';
                var frame_analisis = $('#analisisFrame');
                frame_analisis.attr('src', analisis_source);
            }
        });


    });
</script>

</html>