function rowEntry(control) {
	alert('oye');
	var id = $(control).closest('tr').find('td:first').html();
	console.log(id);
	// window.location.href = base + '/';
}
