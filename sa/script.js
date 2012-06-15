function deleteUser(userId, url) {
	if (confirm('Are you sure you really want to delete the selected user ?\n'+ userId) == false) {
		return false;
	} else {
		window.location.href=url;
	}
}