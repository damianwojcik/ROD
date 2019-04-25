var clientsTable = document.getElementById('clients-table');

if (clientsTable) {
  clientsTable.addEventListener('click', function(event) {
    if (event.target.className === 'btn btn-danger js-delete-client') {
      if (confirm('Czy napewno chcesz usunąć?')) {
        var id = event.target.getAttribute('data-id');

        // TODO: babel ES6 / jquery fetch
        fetch(`/admin/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload);
      }
    }
  });
}
