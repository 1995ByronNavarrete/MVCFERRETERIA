// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    pageLength: 5,
    dom: 'Blfrtip',
    buttons:[{
      //Botón para Excel
      extend: 'excelHtml5',
      footer: true,
      title: 'Archivo',
      filename: 'Inventario Excel',

      //Aquí es donde generas el botón personalizado
      text: '<button class="btn btn-success mb-2">Excel <i class="fas fa-file-excel"></i></button>',
      exportOptions: {
        columns: ":not(.no-exportar)"//exportar solo la primera y segunda columna
      }
    },
    //Botón para PDF
    {
      extend: 'pdfHtml5',
      footer: true,
      title: 'Inventario',
      filename: 'Inventario Pdf',
      text: '<button class="btn btn-danger mb-2">PDF <i class="far fa-file-pdf"></i></button>',
      exportOptions: {
        columns: ":not(.no-exportar)"//exportar solo la primera y segunda columna
      }
    },
    {
      extend: 'copyHtml5',
      footer:true,
      title: 'Inventario',
      text: '<button class="btn btn-secondary mb-2">Copy</button>',
      exportOptions: {
        columns: ":not(.no-exportar)"//exportar solo la primera y segunda columna
      }
    }
  ],
  
  });
});
