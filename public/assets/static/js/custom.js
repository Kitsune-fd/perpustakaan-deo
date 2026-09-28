function submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed && redirectUrl) {
                        window.location.href = redirectUrl;
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }
        })
    });
}

function submitFormUploadAjaxNoReload(formSelector, actionUrl, contentSelector, reloadUrl) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let formData = new FormData(form[0]);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: false, // Jangan set content-type secara manual, biarkan FormData yang mengaturnya
            processData: false,
            success: function(response) {
                $(formSelector)[0].reset();
                $.ajax({
                    url: reloadUrl,
                    success: function (html) {
                        $(contentSelector).html(html);
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }
        })
    });
}

// Deklarasi global toast mixin sekali saja
// Fungsi helper agar lebih mudah dipanggil
function showToast(icon='error', message) {
    const toastMixin = Swal.mixin({
        toast: true,
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    toastMixin.fire({
        icon: icon,
        title: message
    });
}
// showToast('success', 'Data berhasil disimpan');

function submitFormAjaxModal(formSelector, actionUrl, successMessage) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        let form = $(this);    
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#modalForm').find('.close').trigger('click');
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }
        })
    });
}

function submitFormUploadAjaxModal(formSelector, actionUrl, successMessage) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: false, // Jangan set content-type secara manual, biarkan FormData yang mengaturnya
            processData: false, // Jangan proses data (karena kita mengirimkan FormData)
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }
        })
    });
}

function deleteDataAjax(url, table) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}

function deleteDataAjaxV2(url) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}

function updateStatusAjaxV2(url, table, newStatus = null, message = null) {
    let confirmText = message || "Data akan diupdate dan tidak dapat dibatalkan!";
    let confirmTitle = "Konfirmasi Update Status?";

    Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',          // atau 'PUT' kalau route pakai PUT
                data: { 
                    _method: 'PUT',      // kalau route pakai PUT/PATCH (Laravel spoofing)
                    status: newStatus    // misal: 'cancelled', 0, 1, 'approved', dll
                    // tambah data lain kalau perlu, misal: reason: '...'
                },
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    // Swal.fire('Berhasil!', response.message || 'Status berhasil diupdate.', 'success');
                    table.ajax.reload(null, false);  // reload tanpa reset paging
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan server.';
                    Swal.fire('Gagal', errorMsg, 'error');
                }
            });
        }
    });
}

function logoutUser() {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan keluar dari aplikasi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: route('logout'),
                method: 'POST',
                success: function(response) {
                    window.location.href = "/";
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}

function initializeDataTable(tableSelector, ajaxRoute, columnsConfig) {
  var table = $(tableSelector).DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: ajaxRoute,
    columns: columnsConfig,
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json', // CDN Bahasa Indonesia
    }
  });

  // Custom pagination icons
  table.on('draw', function() {
    $('#DataTables_Table_0_previous a').html('<i class="ni ni-bold-left"></i>');
    $('#DataTables_Table_0_next a').html('<i class="ni ni-bold-right"></i>');
  });

  return table;
}

function initializeFilterDataTable(selector, route, columns) {

  // kalau sudah ada, hancurkan dulu biar config baru kepakai
  if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().clear().destroy();
  }

  var table = $(selector).DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: route,
      type: "GET",
      data: function (d) {
        d.filter_category       = $('#filter_category').val();
        d.filter_classification = $('#filter_classification').val();
        d.filter_letter_type    = $('#filter_letter_type').val();
        d.filter_start_date     = $('#filter_start_date').val();
        d.filter_end_date       = $('#filter_end_date').val();
      },
      error: function (xhr) {
        console.log("AJAX ERROR:", xhr.status, xhr.responseText);
      }
    },
    columns: columns,
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json',
    }
  });

  table.off('draw.dtIcon').on('draw.dtIcon', function () {
    const wrapper = $(selector + '_wrapper');
    wrapper.find('.dataTables_paginate .previous a').html('<i class="ni ni-bold-left"></i>');
    wrapper.find('.dataTables_paginate .next a').html('<i class="ni ni-bold-right"></i>');
  });

  return table;
}



function updateStatusAjax(url, table, status) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Status data akan diubah menjadi "+status+"!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya Yakin!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'POST',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}


 function capitalizeWords(input) {
      let words = input.value.split(' ');
      for (let i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
      }
      input.value = words.join(' ');
    }

 function uppercaseWords(input) {
      input.value = input.value.toUpperCase();
    }

function convertHisToHi(timeString) {
  const parts = timeString.split(':');
  // Ensure there are at least two parts (hour and minute)
  if (parts.length >= 2) {
    return `${parts[0]}:${parts[1]}`;
  } else {
    // Handle cases where the input string is not in the expected format
    return null; // Or throw an error, depending on your error handling strategy
  }
}

function closeAlert() {
  const alertBox = document.getElementById("alert-static-custom");
  if (alertBox) {
    // For a simple disappearance, use remove():
    alertBox.remove(); 
    
    // Or add a 'hide' class for CSS-based hiding/fading:
    // alertBox.classList.add("hide"); 
  }
}

// Automatically call closeAlert function after 3000 milliseconds (3 seconds)
setTimeout(closeAlert, 3000);

function changeStatusAjax(url, table) {
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'PUT',
        success: function(response) {
            table.ajax.reload();
        },
        error: function(xhr) {
            Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
        }
    }).always(function() {
        $.ajaxSetup({
            headers: {}
        });
    });
}