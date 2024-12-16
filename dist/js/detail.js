  $(function () {
    $("#dokumen").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 5,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "Semua"]
      ],
      "lengthChange": true,
      "language": {
        "search": "Cari:",
        "searchPlaceholder": "Cari data...",
        "emptyTable": "Tidak ada dokumen yang diupload",
        "zeroRecords": "Tidak menemukan data yang sesuai",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang tersedia",
        "infoFiltered": "(disaring dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "previous": "Sebelumnya",
          "next": "Selanjutnya"
        }
      }
    });
  });

  $(".hapus-dokumen").click( async function(e) {
    e.preventDefault();
    const href = $(this).attr("href");
    try {      
      const result = await Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        })
        if (result.isConfirmed) {
          // Tampilkan Loading
          Swal.fire({
                  title: 'Memproses...',
                  html: 'Mohon tunggu sebentar',
                  allowOutsideClick: false,
                  showConfirmButton: false,
                  willOpen: () => {
                      Swal.showLoading()
                  }
                });
          document.location.href = href;
        }
    } catch (error) {
      console.error('Error:', error);
      Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Silakan coba lagi'
      });
    }
  });

  // Fungsi untuk mengecek ekstensi file
  function getFileExtension(filename) {
      return filename.split('.').pop().toLowerCase();
  }

  // Handle klik tombol preview
$('.preview-btn').click(function(e) {
    const file = $(this).data('file');
    const kategori = $(this).data('kategori');
    const judul = $(this).data('judul');
    const extension = file.split('.').pop().toLowerCase();
    
    // Cek ekstensi file terlebih dahulu
    if(!['jpg', 'jpeg', 'png', 'pdf'].includes(extension)) {
      // Prevent modal from showing
        e.preventDefault();
        $(this).removeAttr('data-target');
        $(this).removeAttr('data-toggle');

      // Tampilkan toast notification
      Swal.fire({
        icon: 'error',
        title: 'Tipe File Tidak Didukung',
        text: 'File dengan ekstensi .' + extension + ' tidak dapat ditampilkan dalam preview',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });
      return;
    }
    
    
    if(['jpg', 'jpeg', 'png'].includes(extension)) {
      $('#preview-content').html(`
        <img src="../uploads/${kategori}/${file}" class="img-fluid" alt="${judul}">
      `);
    } else if(extension === 'pdf') {
      $('#preview-content').html(`
        <embed src="../uploads/${kategori}/${file}" type="application/pdf" width="100%" height="500px">
      `);
    }
    
    // Reset preview content

    

  });

  // Tambahkan CSS untuk mengatur ukuran gambar preview
  $('#previewModal').on('shown.bs.modal', function () {
    const modalHeight = $(this).find('.modal-body').height();
    const modalWidth = $(this).find('.modal-body').width();
    
    $('#preview-content img').css({
      'max-height': modalHeight + 'px',
      'max-width': '100%',
      'object-fit': 'contain'
    });
  });