<script defer>
	function viewPost(postId) {
		const modal = document.getElementById("post_view");
		const bsModal = new bootstrap.Modal(modal);
		const body = document.getElementById("view_body");
		body.innerHTML = "";

		const rollback = function() {
			toast("An error occurred.", "danger");
			bsModal.hide();
		};

		const request = fetch(`${location.protocol}//${location.host}/posts/${postId}/view`).then((response) => {
			response.text().then((value) => {
				if (value) {
					body.innerHTML += value;
					bsModal.show();
				} else {
					rollback();
				}
			});
		}).catch((err) => {
			rollback();
			console.error(err);
		});
	}
</script>
